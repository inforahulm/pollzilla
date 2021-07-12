<?php

namespace App\Http\Requests\SubInterestCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSubInterestCategoryRequest extends FormRequest
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
            'interest_sub_category_name' => [
                'required',
                Rule::unique('interest_sub_category', 'interest_sub_category_name')->where(function ($query) {
                    return $query->where('interest_category_id',$this->interest_category_id);
                })
            ],
        ];
    }
}
