<?php

namespace App\Http\Requests\Api\Poll;

use Illuminate\Foundation\Http\FormRequest;

class setDurationPollRequest extends FormRequest
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
            'set_duration' => 'required'
            // 'poll_time'=>  'required'
        ];
    }
}
