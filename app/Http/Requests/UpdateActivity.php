<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivity extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_edit'       => 'required',            
            'stage_id_edit'   => 'required',
        ];
    }

    public function attributes(){
        return [
            'name_edit'      => 'nombre de actividad',          
            'stage_id_edit'  => 'etapa de fabricación',
        ];

    }
}
