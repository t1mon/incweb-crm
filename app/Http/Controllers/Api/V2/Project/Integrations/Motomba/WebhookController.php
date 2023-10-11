<?php

namespace App\Http\Controllers\Api\V2\Project\Integrations\Motomba;

use App\Events\Leads\LeadAdded;
use App\Events\Leads\LeadCreated;
use App\Events\Leads\LeadExists;
use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Project\Host;
use App\Models\Project\Integrations\Matomba;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request, int $project)
    {
        $request->validate(rules: [
            'service' => 'required',
            //'answers' => 'required',
            'contacts' => 'required',
        ]);

        // Поиск интеграции по service
        $matombaUrl = 'https://' . $request->service . '.mtmba.ru';
        $host = Host::where('host', $matombaUrl)->with('project')->first();
        if (is_null($host))
            return response(content: 'Интеграция отсутствует', status: 404);


        // Проверка, включен ли проект
        if (!$host->project->settings['enabled'])
            return response(content: 'Проект отключён', status: 403);

        // Определение количества вхождений
        $lead = Leads::find($request->contacts['phone']);
        $entries = 1;
        $status = Leads::LEAD_NEW;

        if (!is_null($lead)) {
            if ($host->project->settings['leadValidDays'] === 0) { //Если выставлен срок годности лида
                $entries = $lead->entries + 1;
                $status = Leads::LEAD_EXISTS;
            }
            else{
                // Если срок годности лида уже истёк, создать новый лид
                if (Carbon::now()->greaterThan(Carbon::parse($lead->created_at)->addDays($host->project->settings['leadValidDays']))) {
                    $entries = $lead->entries + 1;
                    $status = Leads::LEAD_EXISTS;
                }
            }
        }

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
            'entries' => $entries,
            'status' => $status,
            'referrer' => $request->filled('extra') && isset($request->extra['referer']) ? $request->extra['referer'] : null,
        ]);

        event(new LeadAdded($lead));

        if($lead->entries === 1) //Если лид новый, сделать рассылку
            event(new LeadCreated($lead));
        else
            event(new LeadExists($lead));

        return response(content: 'Лид добавлен', status: 201);
    }
}
