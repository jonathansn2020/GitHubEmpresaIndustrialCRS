<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
        $rules = [
            'name'     => 'required',            
            'email'    => 'required|email|unique:users',            
            'password' => 'required|min:6|confirmed',
            'role'     => 'required'
        ];
       
        if ($this->hasFile('profile_photo_path')){
            $rules['profile_photo_path'] = ['image','max:2048','mimes:jpeg,png,jpg'];
        }

        return $rules;
        
    }

    public function attributes(){
        return [
            'name'                  => 'nombre de usuario',            
            'email'                 => 'email',            
            'password'              => 'password',
            'profile_photo_path'    => 'foto de perfil',
            'role'                  => 'rol'
        ];

    }
}
