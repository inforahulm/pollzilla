<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $rules['name']  =  'required';
        
        if(isset($this->icon)) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg';
        }
        
        return $rules;
    }
}
