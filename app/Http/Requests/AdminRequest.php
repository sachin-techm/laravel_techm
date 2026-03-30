<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
        $role_id    = $this->input('role_id', 0);

        $password_rule          = 'required|string|min:6|max:12';
        $password_confirm_rule  = 'required|same:password';
        
        if($id != 0) {
            $password_rule          = '';
            $password_confirm_rule  = '';
        }

        // dd($id);
        return [
            'name'              => 'required|'. Rule::unique('admins')->ignore($id, 'id'),           
            'email'             => 'required | ' . Rule::unique('admins')->ignore($id, 'id'),
            // 'contact'        => 'required',            
            'password'          => $password_rule,          
            'password_confirm'  => $password_confirm_rule,
            'role_id'           => 'required'
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'email.required' => 'Email is required',
            'email.unique'  => 'Email already taken',
            // 'contact.required' => 'Contact is required',
            'password.required' => 'Password is required',
            'role_id.required' => 'Role is required'
        ];
    }
}
