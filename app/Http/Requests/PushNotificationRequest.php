<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PushNotificationRequest extends FormRequest
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
        // $id = $this->input('id', 0);
         // . Rule::unique('push_notifications')->ignore($id, 'id')

        return [
            'title'     => 'required',
            'body'      => 'required',
            'users'     => ['required_if:all_users,0']
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
