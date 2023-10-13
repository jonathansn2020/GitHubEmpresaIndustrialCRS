<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadProject extends FormRequest
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
            'file_input'  => 'image|max:2048|mimes:jpeg,png,jpg',            
        ];        
    }

    public function attributes(){
        return [
            'file_input'     => 'foto del radiador',            
        ];

    }
}
