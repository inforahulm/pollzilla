<?php

namespace App\Http\Requests\Api\PollVote;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Poll;

class PollVaoteRequest extends FormRequest
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

        $res = Poll::where('id',$this->poll_id)->select('id','poll_type_id')->first();
        if($res['poll_type_id'] == 4) {
            return [
                'poll_id' => 'required',
                'poll_answer_id' => 'required',
                'hito_meter_ans'=>'required|integer'
            ];
        } else if($res['poll_type_id'] == 5) {
            return [
                'poll_id' => 'required',
                'poll_answer_id' => 'required',
                'hito_meter_ans'=>'required'
            ];
        } else {

            return [
                'poll_id' => 'required',
                'poll_answer_id' => 'required'
            ];
        }
    }
}
