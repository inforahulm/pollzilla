<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'             =>  'required|email|exists:users,email',
            'password'          =>  'required|min:6',
            'device_type'       =>  'required|in:1,2',
            'device_token'      =>  'required',
            'current_version'   =>  'required'
        ];
    }
}
