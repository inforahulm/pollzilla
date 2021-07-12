<?php

namespace App\Http\Requests\Api\Poll;

use Illuminate\Foundation\Http\FormRequest;

class PollRequest extends FormRequest
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
            'interest_category_id' => 'required',
            'interest_sub_category_id' => 'required',
            'generic_title' => 'required|max:255',
            'no_of_option' => 'required|in:1,2,3,4,5',
            'poll_type_id' => 'required|in:1,2,3,4,5,6',
            'color_palette_id' => 'required',
            'is_light' => 'required|in:0,1',
            'poll_style_id' => 'required|in:1,2,3,4,0',
            'background' => 'nullable',
            'is_background_image' => 'required|in:0,1',
            'template_id' => 'required',
            'launch_date_time' => 'required|date_format:Y-m-d H:i:s',
            'forever_status' => 'required|in:0,1',
            'set_duration' => 'nullable',
            'poll_privacy' => 'required|in:0,1',
            'chart_id' => 'required|in:1,2,3',
            'share_status' => 'required|in:0,1',
            // 'poll_answer' => 'nullable|array'
        ];
    }
}
