<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Validator;

class ResetPasswordController extends Controller
{

    /**
     * Comment
     */
    public function requestLink(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|exists:users'
        ]);

        $errors = $validation->errors();

        if(count($errors) > 0){

            return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
        }

        $data = $validation->validated();

        /** @var User */
        User::where('email', $data['email'])->firstOrFail();

        $status = Password::sendResetLink($data);

        $statusCode = $status === Password::RESET_LINK_SENT ? 201 : 400;

        if($statusCode === 201){

            return $this->jsonResponse(true, null, 'Reset password link sent' );

        } else {

            return $this->jsonResponse(false, null, 'Too many attempts!');
        }

    }

    /**
     * Comment
     */
    public function validateToken(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required'
        ]);

        $errors = $validation->errors();

        if(count($errors) > 0){

            return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
        }

        $data = $validation->validated();

        $user = User::where('email', $data['email'])->firstOrFail();

        $exist = Password::tokenExists($user, $data['token']);

        if (!$exist) {

            return $this->jsonResponse(false, null, "Reset token not found");
        }

        return $this->jsonResponse(true, null, "Reset token found");

    }

    /**
     * Comment
     */
    public function reset(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6',
            'email' => 'required'
        ]);

        $errors = $validation->errors();

        if(count($errors) > 0){

            return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
        }

        $data = $validation->validated();

        $user = User::where('email', $data['email'])->firstOrFail();
        
        $exist = Password::tokenExists($user, $data['token']);

        if (!$exist) {

            return $this->jsonResponse(false, null, "Reset token not found");
        }

        $data['password_confirmation'] = $data['password'];

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // event(new PasswordReset($user));
            }
        );

        if (!$status === Password::PASSWORD_RESET) {

            return $this->jsonResponse(false, null, "Failed to reset password");
        }

        return $this->jsonResponse(true, null, "Password successfully changed!");

    }
}
