<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id 					= $this->input('id', 0);
        // $password_rule          = 'required|string|min:6|max:12';
        // $password_confirm_rule  = 'required|same:password';
        // if($id != 0)
        // {
        //     $password_rule = '';
        //     $password_confirm_rule = '';
        // }
     	return [
            'first_name' 		=> 'required',            
            'last_name'         => 'required',            
         	'email' 			=> 'required|' . Rule::unique('users')->ignore($id, 'id'),
            'contact'           => 'nullable|digits:10',
            'organization'      => 'required',            
            // 'gender'            => 'required',
            // 'password'          => $password_rule,          
            // 'password_confirm'  => $password_confirm_rule,
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
