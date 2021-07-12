<?php

namespace App\Http\Requests\Api\Image;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
        if($this->type == 3 || $this->type == 4 || $this->type == 5 || $this->type == 6)
        {
            //for image file validation
            $rules = [
                'type' => 'required|in:3,4,5,6',
                'file' =>  'required|mimes:jpg,png,jpeg'
            ];
        }
        else if($this->type == 2)
        {
            //for video file validation
            $rules = [
                'type' => 'required|in:2',
                'file' => 'required|mimes:mp4,flv,m3u8,3gp,mov,avi,wmv,qt'
            ];
        }
        else if($this->type == 1)
        {
            //for audio file validation
            $rules = [
                'type' => 'required|in:1',
                'file' => 'required',
                'file' => 'required|mimes:aac,mp3,m4a'
            ];
        }
        else
        {
            $rules = [
                'type' => 'required|in:1,2,3,4,5,6'
            ]; 
        }

        return $rules;

    }

}
