<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrder extends FormRequest
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
            'requested'         => 'nullable|max:45|string',
            'phone'             => 'required|max:15',
            'email'             => 'required|max:35|email',
            'delivery_place'    => 'required',       
            'order_business'    => 'required',     
            'expected_date'     => 'required|date',
            'status'            => 'required|string',
        ];
    }

    public function attributes(){
        return [            
            'requested'         => 'nombre del solicitante',
            'phone'             => 'teléfono',
            'delivery_place'    => 'lugar de entrega',            
            'expected_date'     => 'fecha de entrega solicitada',            
            'status'            => 'estado de la orden',
            'order_business'    => 'orden del cliente',     
        ];

    }
}
