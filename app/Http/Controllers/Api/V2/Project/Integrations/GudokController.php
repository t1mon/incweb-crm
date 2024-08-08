<?php

namespace App\Http\Controllers\Api\V2\Project\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\Project\Integrations\GudokRequest;
use App\Models\Project\Project;
use App\Models\Project\Host;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GudokController extends Controller
{
    protected function _generateHost(int|string $crmProjectId, int|string $gudokProjectId): string
    {
        return "crm$crmProjectId-gudok$gudokProjectId.ru";
    }

    public function registerHost(GudokRequest $request, int|string $project)
    {
        $projectModel = Project::select(['id', 'settings'])->find($project);

        if(is_null($projectModel)){
            Log::channel('projects')->error(message: '[Api/V2/GudokController::registerHost] Проект с id ' . $project . ' не найден');
            return response(content: 'Проект не найден', status: Response::HTTP_NOT_FOUND);
        }

        if(!$projectModel->settings['enabled'])
        {
            Log::channel('projects')->warning(message: '[Api/V2/GudokController::registerHost] Проект #' . $projectModel->id . ' отключен');
            return response(content: 'Проект отключен', status: Response::HTTP_FORBIDDEN);
        }

        $hostName = $this->_generateHost(crmProjectId: $projectModel->id, gudokProjectId: $request->project_id);

        $user = User::where('email', 'incweb-163@yandex.ru')->select('id')->first();
        if(is_null($user))
        {
            Log::error(message: '[Api/V2/GudokController::registerHost] Не удалось загрузить пользователя incweb-163@yandex.ru для создания хоста');
            return response(content: 'Ошибка. См. логи', status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $host = Host::firstOrCreate([
            'host' => $hostName,
            'project_id' => $projectModel->id,
            'user_id' => $user->id,
        ]);

        Log::channel('projects')->info(
            message: '[Api/V2/GudokController::registerHost] Зарегистрирован хост ' . $host->host,
            context: ['host' => $host->toArray()],
        );

        return response(content: 'Хост зарегистрирован', status: Response::HTTP_CREATED);
    } // registerHost

    public function addLead(GudokRequest $request, int|string $project)
    {
        $projectModel = Project::select(['id', 'settings', 'api_token'])->find($project);

        if(is_null($projectModel)){
            Log::channel('projects')->error(message: '[Api/V2/GudokController::addLead] Проект с id ' . $project . ' не найден');
            return response(content: 'Проект не найден', status: Response::HTTP_NOT_FOUND);
        }

        if(!$projectModel->settings['enabled'])
        {
            Log::channel('projects')->warning(message: '[Api/V2/GudokController::registerHost] Проект #' . $projectModel->id . ' отключен');
            return response(content: 'Проект отключен', status: Response::HTTP_FORBIDDEN);
        }

        $host = Host::where(
            'host',
            $this->_generateHost(crmProjectId: $projectModel->id, gudokProjectId: $request->project_id)
        )->firstOrFail();

        $data = [
            'api_token' => $projectModel->api_token,
            'host' => $host->host,
            'name' => 'gudok.tel',
            'phone' => $request->src,
            'city' => $request->region,
            'comment' => json_encode(value: $request->all(), flags: JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
        ];

        $response = Http::post(
            url: route(name: 'lead.store'),
            data: $data,
        );

        Log::channel('projects')->info(
            message: '[Api/V2/GudokController::addLead] Отправлен запрос на создание лида на api/v1/lead.add',
            context: [
                'request_data' => $data,
                'response' => $response->json(),
            ],
        );
    
        return response(content: 'Запрос обработан', status: Response::HTTP_OK);
    } // addLead
}

?>