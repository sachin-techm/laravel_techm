<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailTemplateRequest extends FormRequest
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
            'name' => 'required|' . Rule::unique('email_templates')->ignore($id, 'id'),
            'subject' => 'required',  
            'content' => 'required',  
            // 'name' => 'required|unique:email_templates,name,'.$id,            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique'   => 'Name already taken',
            'subject.required' => 'Subject is required',
            'content.required' => 'Content is required',
        ];
    }
}
