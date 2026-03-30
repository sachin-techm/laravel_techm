<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRoleRequest extends FormRequest
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
        // dd($id);
        return [
            'name' => 'required|' . Rule::unique('roles')->ignore($id, 'id'),
            'role_code' => 'required|' . Rule::unique('roles')->ignore($id, 'id'),
            // 'type' => 'required',  
            // 'name' => 'required|unique:email_templates,name,'.$id,            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'type.required' => 'Type is required',
        ];
    }
}
