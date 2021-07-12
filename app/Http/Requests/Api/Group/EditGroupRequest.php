<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditGroupRequest extends FormRequest
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
            'group_id' => 'required',
            'group_icon' => 'nullable',
            // 'group_join_user_ids' => 'required',
            'group_name'=>Rule::unique('address_group', 'group_name')->where(function ($query) {
                return $query->where('group_owner_id',$this->user()->id)->where('group_name',$this->group_name)->whereNotIn('id', [$this->group_id]);
            }),
        ];
    }
}
