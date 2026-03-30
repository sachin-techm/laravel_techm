<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProfileRequest extends FormRequest
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
        $id = $this->input('id', 0);
     	return [
            'name'               => 'required|'. Rule::unique('admins')->ignore($id, 'id'),           
         	'email' => 'required | ' . Rule::unique('admins')->ignore($id, 'id'),
            'contact' => 'required',        
            'image' => 'required_without:id|image|mimes:jpeg,png,jpg,gif'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'email.required' => 'Email is required',
            'email.unique' 	=> 'Email already taken'
        ];
    }
}
