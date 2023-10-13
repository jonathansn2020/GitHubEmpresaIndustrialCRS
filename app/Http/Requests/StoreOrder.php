<?php

namespace App\Http\Requests;

use Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrder extends FormRequest
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
            'orders.user_id'         => 'required',
            'orders.requested'       => 'nullable|max:45|string',
            'orders.phone'           => 'required',
            'orders.delivery_place'  => 'required',
            'orders.expected_date'   => 'required|date',
            'orders.email'           => 'required',
            'orders.note'            => 'nullable',
            'orders.order_business'  => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'orders.user_id'           => 'cliente',
            'orders.requested'         => 'nombre del solicitante',
            'orders.phone'             => 'teléfono',
            'orders.delivery_place'    => 'lugar de entrega',
            'orders.expected_date'     => 'fecha de entrega',       
            'orders.email'             => 'email',    
            'orders.order_business'    => 'orden del cliente'
        ];
    }
}
