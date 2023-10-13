<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
            'name'              => 'required|string',
            'summary'           => 'nullable|string',
            'long'              => 'required|numeric',
            'width'             => 'required|numeric',
            'thickness'         => 'required|numeric',
            'rows'              => 'required|numeric',
            'tube'              => 'required|string',                      
            'start_date_p'      => 'required|date',
            'expected_date_p'   => 'required|date',
        ];
    }

    public function attributes(){
        return [
            'name'              => 'nombre del producto',
            'summary'           => 'resumen del proyecto',
            'long'              => 'medida de largo',
            'width'             => 'medida de ancho',
            'thickness'         => 'medida de espesor',
            'rows'              => 'cantidad de filas',
            'tube'              => 'tubo',                     
            'start_date_p'      => 'fecha inicio planificada',
            'expected_date_p'   => 'fecha fin planificada',
        ];

    }
}
