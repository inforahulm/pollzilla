<?php

namespace App\Http\Requests\InterestCategory;

use Illuminate\Foundation\Http\FormRequest;

class AddInterestCategoryRequest extends FormRequest
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
            'interest_category_name'  =>  'required|unique:interest_category,interest_category_name',
        ];
    }
}
