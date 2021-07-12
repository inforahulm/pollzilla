<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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
            'user_name'  => [
                'required',
                'string',
                'max:250',
                'alpha_dash',
                Rule::unique('users', 'user_name')->where(function ($query) {
                   return $query->where('verify_status','1');
               }),
            ],
            'email'  => [
                'required',
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                   return $query->where('verify_status','1');
               }),
            ],
            'password'          =>  'required|min:6',
            'confirm_password'          =>   'required_with:password|same:password|min:6',
            'device_type'       =>  'required|in:0,1',
            'device_token'      =>  'required',
            'current_version'   =>  'required',
            'profile_picture'   =>  'nullable'
        ];
    }
}
