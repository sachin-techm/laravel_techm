<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SponsorRequest extends FormRequest
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
        $id         = $this->input('id', 0);
        return [
            'title'              => 'required',
            'link'       => 'required',
        ];

    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'link.required' => 'Url is required',
        ];
    }
}
