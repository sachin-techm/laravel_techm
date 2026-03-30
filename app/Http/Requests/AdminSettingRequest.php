<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSettingRequest extends FormRequest
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
        $id                       = $this->input('id', 0);

        return [
            
            'app_name'               => 'required',
            'logo'          => 'required_without:id|image|mimes:jpeg,png,jpg,gif',
            'favicon'          => 'required_without:id|image|mimes:jpeg,png,jpg,gif',
        ];
    }
    public function messages()
    {
        return [
           	
        ];
    }
}
