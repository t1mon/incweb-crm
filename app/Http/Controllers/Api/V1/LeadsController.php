<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\Leads\LeadDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LeadsRequest;
use App\Http\Resources\Leads as LeadsResource;
use App\Jobs\Api\V2\Lead\FindEntries;
use App\Models\Project\Host;
use App\Models\Leads;
use App\Models\User;
use App\Models\Project\Project;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Journal\Facade\Journal;
use App\Models\Project\Integrations\Mango;
use App\Services\Project\Integrations\MangoService;
use Illuminate\Support\Facades\Http;

class LeadsController extends Controller
{
    public $leads;

    public MangoService $mangoService;

    public function __construct(Leads $leads, MangoService $mangoService)
    {
        $this->leads = $leads;
        $this->mangoService = $mangoService;
    }

    public function store(LeadsRequest $request)
    {
        $request->merge(['project_id' => Project::where('api_token', $request->api_token)->value('id')]);

        if (filter_var($request->host, FILTER_VALIDATE_URL)) {
            $host = parse_url($request->host);
            $request->merge(['host' => $host['host']]);
        }
        $request->merge(['host' =>  Str::lower($request->host)]);
        $phone = $request->phone;

        if ($phone[0] == 8) {
            $phone = preg_replace('/^./', '7', $phone);
            $request->merge(['phone' => $phone]);
        }

        $request->merge(['cost' => preg_replace("/[^0-9]/", '', trim($request->cost))]);

        //Получение источника и UTM-меток
        $request->merge(['source' => $this->detectSource($request)]);
        $request->merge(['utm' => $this->getUTM($request)]);

        //Проверка хоста у лида
        if (!Host::where([['host', $request->host], ['project_id', $request->project_id]])->exists()) {
            Journal::leadError(
                ['name' => $request->name, 'phone' => $request->phone, 'project_id' => $request->project_id],
                'Лид не добавлен в проект: хост ' . $request->host . ' не найден'
            );
            return response()->json([
                'data' =>
                [
                    'status'  => Host::HOST_NOT_FOUND,
                    'message' => trans('leads.host-error'),
                    'response' => Response::HTTP_PRECONDITION_FAILED,
                ]
            ], Response::HTTP_PRECONDITION_FAILED);
        }

        if (!Project::findOrFail($request->project_id)->settings['enabled']) {
            Journal::leadWarning(['name' => $request->name, 'phone' => $request->phone, 'project_id' => $request->project_id], "Попытка добавления лида в отключенный проект");
            return response()->json([
                'data' =>
                [
                    'status'  => Project::DISABLED,
                    'message' => trans('projects.enabled.false'),
                    'response' => Response::HTTP_FOUND,
                ]
            ], Response::HTTP_FOUND);
        }

        //Добавление владельца. Если владелец не авторизован, по умолчанию ставится "API"
        $user = User::where('api_token', $request->bearerToken())->first();
        $request->merge(['owner' => is_null($user) ? 'API' : $user->name]);

        //Переименование поля city в manual_city
        $request->merge(['manual_city' => $request->city]);
        $request->request->remove('city');

        //$new_lead = Leads::addToDB($request->all());
        // $new_lead = $this->leads->createOrUpdate($request->all());
        // Journal::lead($new_lead, $new_lead->entries == 1 ? 'Добавлен новый лид' : 'Лид уже существует в базе (кол-во вхождений: '  . $new_lead->entries . ')');

        $request->merge(['entries' => 1, 'status' => Leads::LEAD_NEW]);
        $new_lead = Leads::create($request->all());

        FindEntries::dispatch($new_lead);

        return new LeadsResource(
            $new_lead
        );
    }

    public function detectSource(LeadsRequest $request) // Определение источника лида
    {
        // 1. Высший приоритет: внешний referrer
        if ($request->exists('referrer')) {
            $refHost = parse_url($request->referrer, PHP_URL_HOST);
            $ownHost = parse_url($request->host, PHP_URL_HOST);

            if ($refHost && $refHost !== $ownHost) {
                return $this->cleanUTM($refHost);
            }
        }

        // 2. Средний приоритет: параметр source из query_string
        if ($request->exists('url_query_string')) {
            $queryString = parse_url($request->url_query_string, PHP_URL_QUERY) ?: $request->url_query_string;

            $utm = [];
            parse_str($queryString, $utm);

            if (!empty($utm['source'])) {
                $cleaned = $this->cleanUTM($utm['source']);
                if ($cleaned !== '') {
                    return $cleaned;
                }
            }

            // 3. Низкий приоритет: utm_source
            if (!empty($utm['utm_source'])) {
                $cleaned = $this->cleanUTM($utm['utm_source']);
                if ($cleaned !== '') {
                    return $cleaned;
                }
            }
        }

        // 4. По умолчанию: прямой заход
        Journal::leadWarning([
            'name' => $request->name,
            'phone' => $request->phone,
            'project_id' => $request->project_id,
        ], "Не удалось определить источник лида.");

        return Leads::SOURCE_DIRECT_ENTRY;
    }

    public function getUTM(LeadsRequest $request)
    {
        $utm = [];
        $utmKeys = ['utm_source', 'utm_campaign', 'utm_medium', 'utm_term', 'utm_content'];

        // 1. Основной источник — query_string
        if ($request->exists('url_query_string')) {
            $queryString = parse_url($request->url_query_string, PHP_URL_QUERY) ?: $request->url_query_string;
            parse_str($queryString, $utm);
        }

        // 2. Если нет ни одной utm-метки — пытаемся из referrer
        $hasUtmMarks = !empty(array_intersect_key($utm, array_flip($utmKeys)));

        if (!$hasUtmMarks && $request->exists('referrer')) {
            $refQuery = parse_url($request->referrer, PHP_URL_QUERY);
            if ($refQuery) {
                $tmp = [];
                parse_str($refQuery, $tmp);
                $utm = array_merge($utm, $tmp);
            }
        }

        // 3. Фильтрация и очистка
        $filtered = [];
        foreach ($utmKeys as $key) {
            if (isset($utm[$key])) {
                $cleaned = $this->cleanUTM($utm[$key]);
                if ($cleaned !== '') {
                    $filtered[$key] = $cleaned;
                }
            }
        }

        if (empty($filtered)) {
            Journal::leadWarning([
                'name' => $request->name,
                'phone' => $request->phone,
                'project_id' => $request->project_id,
            ], "Не удалось получить UTM-метки.");
        }

        return $filtered;
    }

    private function cleanUTM(string $value): string
    {
        // Убираем только опасные символы, оставляем больше валидных
        return preg_replace('/[<>\'"\\\\]+/u', '', trim($value));
    }

    public function update(LeadsRequest $request)
    {
        //Проверка наличия лида
        $lead = Leads::find($request->id);
        if (is_null($lead))
            return response()->json(['error' => 'Lead not found'], Response::HTTP_NOT_FOUND);


        //Проверка полномочий
        // if(!Auth::guard('api')->check())
        //     return response()->json(['error' => 'You are not authorized for this action'], Response::HTTP_UNAUTHORIZED);
        // $user = Auth::guard('api')->user();
        $user = User::where('api_token', $request->bearerToken())->first();
        if (is_null($user))
            return response()->json(['error' => 'You are not authorized for this action'], Response::HTTP_UNAUTHORIZED);
        if ($user->name !== $lead->owner) {
            if (!$user->isAdmin())
                return response()->json(['error' => 'You are not owner of this lead'], Response::HTTP_FORBIDDEN);
        }

        //Изменение лида
        $lead_copy = clone $lead; //Копия лида для записи
        $lead->fill($request->all());
        $lead->owner = $user->name;
        $lead->save();

        Journal::lead($lead_copy, $user->name . ' изменил лид');
        return response()->json(['messsage' => 'Lead has been updated'], Response::HTTP_OK);
    } //update

    public function destroy(Request $request)
    {
        //Валидация
        $request->validate(['id' => 'required|integer']);

        //Проверка наличия лида
        $lead = Leads::find($request->id);
        if (is_null($lead))
            return response()->json(['error' => 'Lead not found'], Response::HTTP_NOT_FOUND);

        $user = User::where('api_token', $request->bearerToken())->first();
        if (is_null($user))
            return response()->json(['error' => 'You are not authorized for this action'], Response::HTTP_UNAUTHORIZED);
        if ($user->name !== $lead->owner) {
            if (!$user->isAdmin())
                return response()->json(['error' => 'You are not owner of this lead'], Response::HTTP_FORBIDDEN);
        }

        $lead_copy = clone $lead; //Копия лида для записи
        $lead->delete();

        event(new LeadDeleted($lead_copy));
        Journal::lead($lead_copy, $user->name . ' удалил лид');

        return response()->json(['messsage' => 'Lead has been deleted'], Response::HTTP_OK);
    } //destroy

    public function test(Request $request) {} //test
}
