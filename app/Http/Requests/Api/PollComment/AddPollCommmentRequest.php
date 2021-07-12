<?php

namespace App\Http\Requests\Api\PollComment;

use Illuminate\Foundation\Http\FormRequest;

class AddPollCommmentRequest extends FormRequest
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
            'poll_id' => 'required',
            'comment'=>'required'
        ];
    }
}
