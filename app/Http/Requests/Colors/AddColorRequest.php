<?php

namespace App\Http\Requests\Colors;

use Illuminate\Foundation\Http\FormRequest;

class AddColorRequest extends FormRequest
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
            'color_palette_name'=>'required',
            'background_code'=>'required',
            'components_code'=>'required'
        ];
    }
}
