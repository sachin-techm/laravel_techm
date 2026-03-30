<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;
use App\Models\User;
use App\Models\Otp;

class ForgotPasswordController extends Controller
{

    /**
     * Comment
     */
    public function forgotPassword(Request $request)
    {
        
        return $this->sendOtp($request);
    }

    /**
     * Comment
     */
    public function resendOtp(Request $request)
    {
        
        return $this->sendOtp($request);
    }

    /**
     * Comment
     */
    private function sendOtp(Request $request)
    {
        
        try {

            $validation = Validator::make($request->all(), [
                'email'         => 'required',
            ]);

            $errors = $validation->errors();

            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return $this->jsonResponse(false, null, "Unable to find user");
            }

            $user->sendOTP();
            return $this->jsonResponse(true, null, "OTP sent to your email address.");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }

    /**
     * Comment
     */
    public function verifyOtp(Request $request)
    {
        
        try {

            $validation = Validator::make($request->all(), [
                'email'             => 'required',
                'code'              => 'required',
            ]);

            $errors = $validation->errors();

            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            $user = User::where('email', $request->email)->first();
            
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

            return $this->jsonResponse(true, null, "OTP verified successfully");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }

    /**
     * Comment
     */
    public function resetPassword(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [
                'email'                 => 'required',
                'password'              => 'required|string|min:6',          
                'password_confirmation'  => 'required_with:password|same:password|min:6'
            ]);

            $errors = $validation->errors();

            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            User::$shouldAppends = false;
            
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return $this->jsonResponse(false, null, "Unable to find user");
            }
            
            $user->password         = Hash::make($request->password);
            $user->save();
            
            return $this->jsonResponse(true, null, "Password reset successfully");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }
}
