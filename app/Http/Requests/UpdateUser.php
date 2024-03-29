<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
     * Get the validation rules that apply to the request.sol
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required', 
            'email'    => ['required','email', Rule::unique('users')->ignore($this->user)]                
        ];
    }

    public function attributes()
    {
        return [
            'name'     => 'nombre de usuario', 
            'email'    => 'email'                   
        ];
    }
}
