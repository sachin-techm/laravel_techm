<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class PasswordController extends Controller
{

    /**
     * Comment
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'current_password'          => 'required|min:6',
            'password'                  => 'required|min:6',
            'password_confirmation'     => 'min:6|required_with:password|same:password',
        ]);

        $errors = $validation->errors();

        if(count($errors) > 0){

            return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        $data = $validation->validated();

        if ($user->password && !isset($data['current_password'])) {
            return $this->jsonResponse(false, null, 'The current password is incorrect');
        }

        if (!!$user->password && !Hash::check($data['current_password'], $user->password)) {
            
            return $this->jsonResponse(false, null, 'The current password is incorrect');
        }

        $currentPassword = $data['current_password'] ?? null;

        if ($currentPassword === $data['password']) {
            
            return $this->jsonResponse(false, null, 'The password cannot be the same as the current password');
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return $this->jsonResponse(true, $user, "Password has been changed");
    }
}
