<?php

namespace App\Http\Requests\Api\V2\Project\Integrations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class GudokRequest extends FormRequest
{
    public function authorize()
    {
        Log::channel('projects')->info(
            message: '[GudokRequest] Поступил запрос',
            context: [
                'path' => $this->path(),
                'request' => $this->all(),
            ],
        );

        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}

?>