<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'question'  =>  'required|max:100|unique:faqs,question,NULL,id,deleted_at,NULL',
            'answer'    =>  'required',
        ];
    }
}
