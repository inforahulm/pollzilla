<?php

namespace App\Http\Requests\Api\InterestSubCategory;

use Illuminate\Foundation\Http\FormRequest;

class InterestSubCategoryRequest extends FormRequest
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
            'interest_category_id' => 'required|numeric'
        ];
    }
}
