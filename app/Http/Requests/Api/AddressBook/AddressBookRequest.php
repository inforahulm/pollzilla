<?php

namespace App\Http\Requests\Api\AddressBook;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressBookRequest extends FormRequest
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
        'contact_user_id'=>Rule::unique('address_book', 'contact_user_id')->where(function ($query) {
                return $query->where('user_id',$this->user()->id)->where('contact_user_id',$this->contact_user_id);
            })
        ];
    }

    public function messages()
    {
        return [
            'contact_user_id.unique' => 'This user already taken in address book',
        ];
    }
}
