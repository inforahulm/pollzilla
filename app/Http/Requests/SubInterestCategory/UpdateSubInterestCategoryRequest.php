<?php

namespace App\Http\Requests\SubInterestCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubInterestCategoryRequest extends FormRequest
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
        'interest_sub_category_name' => 'required|unique:interest_sub_category,interest_sub_category_name,'.$this->id,
    ];
}
}
