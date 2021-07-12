<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SocialRequest extends FormRequest
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
            'social_types' => ['required', Rule::in([1, 2, 3, 4, 5])],
            'social_id'       =>  'required',
            'email'       =>  'email',
            'device_type'       =>  'required|in:0,1',
            'device_token'      =>  'required',
            'current_version'   =>  'required'
        ];
    }
}
