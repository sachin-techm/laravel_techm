<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemSettings;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;
use App\Traits\UserTrait;

class LoginController extends Controller
{   

    use UserTrait;
    /**
     * Comment
     */
    public function __construct() {
       
    }

    /**
     * Comment
     */
    public function login(Request $request) {
        
        try { 

            $validation = Validator::make($request->all(), [
                'email'         => 'required',
                'password'      => 'required|min:6',
            ]);

            $errors = $validation->errors();

            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            User::$shouldAppends = false;
            $user = User::where("email", $request->email)->first();

            if (!$user) {
                return $this->jsonResponse(false, null, "Unable to find user");
            }

            if (!$user->hasVerifiedEmail()) {
                return $this->jsonResponse(false, null, "Your account is not verified.", ['ERROR_TYPE' => 'EMAIL_UNVERIFIED']);
            }
            
            if (!Hash::check($request->password, $user->password)) {

                return $this->jsonResponse(false, null,  "Password not matched");  
            }

            $userDataArr = $this->getProfileData($user);
            $userDataArr['accessToken']= $user->createToken(env("APP_NAME", "Laravel"))->accessToken;

            return $this->jsonResponse(true, $userDataArr, "User Verified");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }

}