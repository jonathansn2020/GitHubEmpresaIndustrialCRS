<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivity extends FormRequest
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
            'name'       => 'required|max:100|string',            
            'stage_id'   => 'required',
        ];
    }

    public function attributes(){
        return [
            'name'      => 'nombre de actividad',          
            'stage_id'  => 'etapa de fabricación',
        ];

    }
}
