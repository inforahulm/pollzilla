<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'             =>  'required|email|exists:users,email',
            'password'          =>  'required|min:6',
            'device_type'       =>  'required|in:0,1',
            'device_token'      =>  'required',
            'current_version'   =>  'required'
        ];
    }
}
