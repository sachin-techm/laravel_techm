<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\SystemSettings;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;
use App\Traits\UserTrait;

class AccountVerifyController extends Controller
{   

    use UserTrait;
    /**
     * Comment
     */
    public function __construct() {
       //
    }

    /**
     * Send accoutn verification email/sms
     */
    public function sendAccountVerificationCode(Request $request)
    {
        
        try {

            // return $this->jsonResponse(false, null, "Account verification process is down for now.");
            
            $validation = Validator::make($request->all(), [
                'email'     => 'required_without:contact',
                'contact'   => 'required_without:email',
                'via'       => 'nullable|in:mail,sms',
            ]);

            $errors = $validation->errors();

            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            $via = $request->input('via', 'mail');

            if($via == 'sms') {

                $user = User::where("contact", $request->contact)->first();

            } else {

                $user = User::where("email", $request->email)->first();
            }
            
            if (!$user) {
                return $this->jsonResponse(false, null, "Unable to find user");
            }

            $user->sendOTP();

            return $this->jsonResponse(true, null, "Verification code sent to your email address.");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }

    /**
     * Verify account via mail/sms code
     */
    public function verifyAccount(Request $request)
    {
        
        try { 

            // return $this->jsonResponse(false, null, "Account verification process is down for now.");

            $validation = Validator::make($request->all(), [
                'email'     => 'required_without:contact',
                'contact'   => 'required_without:email',
                'code'      => 'required',
                'via'       => 'nullable|in:mail,sms',
                'referrer'  => 'nullable',
            ]);

            $errors = $validation->errors();

            if(count($errors) > 0) {

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            $via = $request->input('via', 'mail');

            if($via == 'sms') {

                $user = User::where("contact", $request->contact)->first();

            } else {

                $user = User::where("email", $request->email)->first();
            }
            
            if (!$user) {
                
                return $this->jsonResponse(false, null, "Unable to find user");
            }

            /** @var Otp */
            $otp = Otp::where([
                'code' => $request->code,
                'type' => 'login',
                'user_id' => $user->id,
            ])->first();

            if(env('OTP_BYPASS', false) && env('DEFAULT_OTP', null) == '222222'){

            } else if (!$otp) {
                
                return response()->json(['message' => 'Invalid OTP'], 400);
            }

            if( $otp ) {

                $OTP_EXPIRY_TIME = env('OTP_EXPIRY_TIME', 10) * 60;
                $now = Carbon::now()->getTimestamp(); // timestamp (seconds)
                $expired_at = Carbon::parse($otp->expired_at)->timestamp;

                if( ($now - $expired_at) > $OTP_EXPIRY_TIME ){
                    
                    return $this->jsonResponse(false, null, "OTP expired");
                }
                
                $otp->delete();
            }

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
            
            if($request->has('referrer') && $request->referrer == 'Register') {

                $userDataArr = $this->getProfileData($user);
                $userDataArr['accessToken']= $user->createToken(env("APP_NAME", "Laravel"))->accessToken;

                return $this->jsonResponse(true, $userDataArr, "Account Verified");
                
            } else {

                return $this->jsonResponse(true, null, "Account Verified");
            }

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }

}