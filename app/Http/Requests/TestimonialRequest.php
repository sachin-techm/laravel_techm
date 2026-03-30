<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestimonialRequest extends FormRequest
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
            'name'              => 'required',          
            'organization'      => 'required',
            'description'       => 'required',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'organization.required' => 'Designation is required',
            'description.required' => 'Place is required',
            'image.required' => 'Please upload an image.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Only jpeg, png, jpg, and gif formats are allowed.',
            'image.max' => 'The image size must not exceed 4MB.',
        ];
    }
}
