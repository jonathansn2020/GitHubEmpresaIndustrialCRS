<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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
            'name'         => ['unique:roles','required'],
            'permissions'  => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name'         => 'nombre del rol',
            'permissions'  => 'permisos'
        ];
    }
}
