<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperator extends FormRequest
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
            'name'      => 'required',
            'document'  => 'required|max:9',
            'phone'     => 'required|max:11|unique:operators',
            'email'     => 'required|email|unique:operators',
            'position'  => 'required',
        ];
    }

    public function attributes(){
        return [
            'name'      => 'nombre del operario',
            'document'  => 'documento de identidad',
            'phone'     => 'número de teléfono',
            'email'     => 'email',
            'position'  => 'cargo del operario',
        ];

    }

}
