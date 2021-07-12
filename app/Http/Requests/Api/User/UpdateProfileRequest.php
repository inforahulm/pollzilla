<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
        $id = request()->user()->id;
        $email = request()->user()->email;

        return [
            'first_name'  => 'required',
            'user_name'  => 'required|string|max:250|alpha_dash|required|unique:users,user_name,'.$id,
            'email'  => 'required|email|unique:users,email,'.$id,
            'mobile_number'  => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|nullable',
            'birthdate'  => 'date|nullable',
            'gender'  => 'required|in:1,2,3',
            'country_id'  => 'required|numeric',
            'state_id'  => 'required|numeric',
            'city_id'  => 'required|numeric',
            'company_name'  => 'nullable',
            'school_name'  => 'nullable',
            // 'facebook_url'  => 'nullable|url',
            // 'twitter_url'  => 'nullable|url',
            // 'interest_sub_category_ids'  => 'required',
            'profile_picture' => 'nullable',
        ];
    }
}
