<?php

namespace App\Http\Requests\Project\Integrations\Matomba;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'host' => [
                'required',
                'url',
                Rule::unique('hosts')->where(function($query){
                    return $query->where(['host' => $this->host, 'project_id' => $this->project_id]);
                })
            ],
        ];
    }
}
