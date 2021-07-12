<?php

namespace App\Http\Requests\Api\PollVote;

use Illuminate\Foundation\Http\FormRequest;

class PollInviteRequest extends FormRequest
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
        if($this->type == 2)
        {
            return $rules = [
                'poll_id'  =>    'required',
                'type'     =>    'required|in:1,2,3',
                'group_id' =>    'required'
            ];
        } else if($this->type == 1) {
            return [
                'poll_id' => 'required',
                'user_id' => 'required',
                'type'    => 'required|in:1,2,3'
            ];
        } else {
            return [
                'invite_count' => 'required|integer',
                'type'    => 'required|in:1,2,3'
            ];
        }

    }
}
