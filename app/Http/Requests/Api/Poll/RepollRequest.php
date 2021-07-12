<?php

namespace App\Http\Requests\Api\Poll;

use Illuminate\Foundation\Http\FormRequest;

class RepollRequest extends FormRequest
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
            'launch_date_time' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
