<?php

namespace App\Http\Controllers\Api\V2\Project\Integrations\Motomba;

use App\Events\Leads\LeadAdded;
use App\Events\Leads\LeadCreated;
use App\Events\Leads\LeadExists;
use App\Http\Controllers\Controller;
use App\Jobs\Api\V2\Lead\FindEntries;
use App\Models\Leads;
use App\Models\Project\Host;
use App\Models\Project\Integrations\Matomba;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function __invoke(Request $request, int $project)
    {
        $request->validate(rules: [
            'service' => 'required',
            'contacts' => 'required',
        ]);

        // Поиск интеграции по service
        $matombaUrl = Str::of($request->service)->slug('-') . '.mtmba.ru';
        $host = Host::where('host', $matombaUrl)->with('project')->first();
        if (is_null($host))
            return response(content: 'Интеграция отсутствует', status: 404);


        // Проверка, включен ли проект
        if (!$host->project->settings['enabled'])
            return response(content: 'Проект отключён', status: 403);

        // Компоновка ответов в читаемый вид
        $answersHumanized = [];
        if ($request->filled('answers')){
            $answersHumanized = array_map(
                callback: function ($item) {
                    $answers = implode(', ', array_map(callback: function ($item_answer) {
                        return $item_answer;
                    }, array: $item['a']));
                    return 'Вопрос: ' . $item['q'] . ', Ответ: ' . $answers;
                },

                array: $request->answers
            );
        }

        if ($request->filled('contacts.more'))
            $answersHumanized[] = 'Собственное поле: ' . $request->contacts['more'];


        // Создание лида
        $lead =  Leads::create([
                'name' => $request->contacts['name'] ?? 'Не заполнено',
                'phone' => $request->contacts['phone'],
                'email' => $request->contacts['mail'] ?? null,
                'host' => $host->host,
                'comment' => implode(separator: '; ', array: $answersHumanized),
                'project_id' => $host->project_id,
                'entries' => 1,
                'status' => Leads::LEAD_NEW,
                'referrer' => $request->filled('extra') && isset($request->extra['referer']) ? $request->extra['referer'] : null,
            ]);

        FindEntries::dispatch($lead);

        return response(content: 'Лид добавлен', status: 201);
    }
}
