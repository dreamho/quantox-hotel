<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegister extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:60|unique:users',
            'name' => 'required|max:60',
            'password'=> 'required|max:100',
            'confirm_password' => 'same:password',
            'role' => 'numeric'
        ];
    }
}
