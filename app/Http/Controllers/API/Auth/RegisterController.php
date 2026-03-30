<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\SystemSettings;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;
use Illuminate\Support\Arr;
use ImageUploadHelper;
use FileUploadHelper;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{   

    /**
     * Comment
     */
    private $data;

    /**
     * Comment
     */
    public function __construct() {
       
       // code
    }

    /**
     * Comment
     */
    public function register(Request $request)
    {
        
        try { 

            $validation = Validator::make($request->all(), [
                'first_name'        => 'required',
                'last_name'         => 'nullable',
                'email'             => 'required|unique:users,email',
                'contact'           => 'nullable|digits:10',
                'password'          => 'required',
                'refer_code'        => 'nullable',
            ], [
                'email.unique' => 'User already registered using this email',
                // 'contact.unique' => 'User already registered using this contact',
            ]);

            $errors = $validation->errors();
            
            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            $data = $validation->validated();

            $referredUser = null;
            if($request->has('refer_code') && $request->filled('refer_code')) {

                $referredUser = User::where('refer_code', $request->refer_code)->first();

                if(!$referredUser) {

                    return $this->jsonResponse(false, null, "Invalid refer code");
                }
            }

            DB::beginTransaction();
            $user = new User(
                Arr::except($data, ['password', 'refer_code'])
            );

            $user->password         = Hash::make($request->password);
            $user->wallet_amount    = 0;
            $user->refer_code       = strtoupper(\App\Helpers\Helper::generateRandomString(8));
            $user->save();

            if($request->has('refer_code') && $request->filled('refer_code')) {

                if($referredUser) {

                    $refer_amount       = 0;
                    $user->referrer_id  = $referredUser->id;
                    $adminSettings      = SystemSettings::where('name', 'REFERRER_AMOUNT_PER_USER')->first();

                    if($adminSettings) {
                        $refer_amount = $adminSettings->value;
                    }

                    $user->referrer_amount  = $refer_amount;

                    // Credit refer bonus to referred user
                    $referredUser->wallet_amount = $referredUser->wallet_amount + $refer_amount;
                    $referredUser->save();

                    // Create wallet recird for refer bonus to referred user
                    $walletTransaction = new WalletTransaction();
                    $walletTransaction->user_id = $referredUser->id;
                    $walletTransaction->transaction_type = 1; // Credit
                    $walletTransaction->payment_by = 2; // Referrer
                    $walletTransaction->amount = $refer_amount;
                    $walletTransaction->transaction_date = Carbon::now();
                    $walletTransaction->title = 'Refer bonus credited';
                    $walletTransaction->message = 'Refer bonus credited against '.$user->fullName() . ' ('.$user->email.')';
                    $walletTransaction->status = 'SUCCESS';
                    $walletTransaction->save();
                }
            }

            $user->save();
            $user->sendOTP();
            \App\Notifications\FCMPushNotification::sendReferRewardCreditNotification($user);

            DB::commit();
            
            if (config('app.env') !== "local" && env('MAIL_ENABLED', false) ) {
                // \Mail::to($user->email)->send(new \App\Mail\RegisterMailable($user));
            }

            return $this->jsonResponse(true, null, "Registration successful. Please verify your email.");

        } catch (\Exception $e) {

            DB::rollBack();
            return $this->jsonResponse(false, null, $e->getMessage());
        }  
    }

}