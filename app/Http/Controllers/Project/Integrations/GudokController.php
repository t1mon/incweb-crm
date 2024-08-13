<?php

namespace App\Http\Controllers\Project\Integrations;

use App\Http\Controllers\Controller;
use App\Models\Project\Integrations\GudokToken;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GudokController extends Controller
{
    public function createToken(int|string $project)
    {
        $timestamp = now()->subMinutes(GudokToken::VALIDITY_PERIOD);
        
        // Проверка наличия действительных неиспользованных токенов у проекта
        $token = GudokToken::where(['project_id' => $project, 'used' => false])
            ->where('created_at', '>=', $timestamp)
            ->first();

        // Если токенов нет, создать новый
        if(is_null($token)){
            $validTokens = GudokToken::where('used', false)->where('created_at', '>=', $timestamp)->select('token')->pluck('token')->toArray();
            
            $newToken = null;
            do{
                $newToken = Str::random(6);
            }while(in_array(needle: $newToken, haystack: $validTokens));

            $token = GudokToken::create(['project_id' => $project, 'token' => $newToken, 'used' => false]);
        }

        $projectModel = Project::findOrFail($project);

        return view(view: 'material-dashboard.project.integrations.gudok-create-token', data: ['project' => $projectModel, 'token' => $token]);
    }
}
