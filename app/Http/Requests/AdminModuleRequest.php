<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidHost;

class AdminModuleRequest extends FormRequest
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
            'name' => 'required| ' . Rule::unique('admin_modules')->ignore($id, 'id'),            
            'controller' => 'required',            
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'controller.required' => 'Controller is required',
            
        ];
    }
}
