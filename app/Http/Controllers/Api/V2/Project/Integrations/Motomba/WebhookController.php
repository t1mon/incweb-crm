<?php

namespace App\Http\Controllers\Api\V2\Project\Integrations\Motomba;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Project\Integrations\Matomba;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(rules: [
            'service' => 'required|exists:integrations_matomba,service',
            'answers' => 'required',
            'contacts' => 'required',
        ]);

        // Поиск интеграции по service
        $matomba = Matomba::service($request->service)->with('project')->firstOrFail();

        // Проверка, включен ли проект
        if(!$matomba->project->settings['enabled'])
            return response(content: 'Проект отключён', status: 403);

        // TODO Проверка хоста

        // Определение количества вхождений
        $lead = Leads::find($request->contacts['phone']);
        $entries = 1;
        $status = Leads::LEAD_NEW;

        if(!is_null($lead))
        {
            if($matomba->project->settings['leadValidDays'] > 0){ //Если выставлен срок годности лида
                // Если срок годности лда уже истёк, создать новый лид
                if( Carbon::now()->greaterThan(Carbon::parse($lead->created_at)->addDays($matomba->project->settings['leadValidDays'])) ){
                    $entries = $lead->entries + 1;
                    $status = Leads::LEAD_EXISTS;
                }
            }
        }

        // Создание лида
        Leads::create([
            'name' => $request->contacts['name'],
            'phone' => $request->contacts['phone'],
            'host' => 'Test Host',
            'comment' => json_encode(value: $request->answers, flags: JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),
            'project_id' => $matomba->project_id,
            'entries' => $entries,
            'status' => $status,
            'referrer' => $request->filled('extra') && isset($request->extra['referer']) ? $request->extra['referer'] : null,
        ]);
        
        // TODO Рассылка по синхронизации

        return response(content: 'Лид добавлен', status: 201);
    }
}
