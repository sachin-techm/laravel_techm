<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemSettings;
use Carbon\Carbon;
use Validator;
use Auth;
use Hash;
use Illuminate\Support\Arr;
use ImageUploadHelper;
use FileUploadHelper;
use Illuminate\Support\Facades\Log;
use App\Traits\UserTrait;

class UserController extends Controller
{   

    use UserTrait;
    /**
     * construct
     *
     */
    public function __construct()
    {

    }

    /**
     * get profile api
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function getProfile(Request $request)
    {
        
        try {

            User::$shouldAppends = false;
            
            $user = Auth::guard('api')->user();
            $userDataArr = $this->getProfileData($user);

            return $this->jsonResponse(true, $userDataArr, "User profile");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }  
    }

    /**
     * update profile api
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function updateProfile(Request $request)
    {
        
        try {

            $validation = Validator::make($request->all(), [
                'first_name'            => 'required',
                'last_name'             => 'required',
                'contact'               => 'required',
                'user_image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $errors = $validation->errors();
            
            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            $data = $validation->validated();

            User::$shouldAppends = false;
            
            $user = Auth::guard('api')->user();

            $user->fill(
                Arr::except($data, ['user_image'])
            )->save();

            $userDataArr = $this->getProfileData($user);
            
            return $this->jsonResponse(true, $userDataArr, "Profile updated successfully.");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage());
        } 
    }

    /**
     * Delete user account
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function deleteAccount(Request $request)
    {

        $validation = Validator::make($request->all(), [
           
        ]);

        $errors = $validation->errors();
        
        if(count($errors) > 0){

            return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
        }

        $user = Auth::user();

        $user->currentAccessToken()->delete();
        $user->delete();

        return $this->jsonResponse(true, $user, "Account deleted successfully.");
    }

   /**
     * Update profile photo
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function updateProfilePhoto(Request $request)
    {
        
        try {

            $validation = Validator::make($request->all(), [
                'user_image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $errors = $validation->errors();
            
            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            User::$shouldAppends = false;
            
            $user = Auth::guard('api')->user();

            if ($request->hasFile('user_image')) {

                $user_image = $request->file('user_image');
                $user_image = ImageUploadHelper::uploadImage((new \App\Http\Controllers\Admin\UserController)::$moduleConfig['imageUploadFolder'], $user_image, $request->input('name', 'User-avatar'), 900, 900, true);
                $user->user_image = $user_image;
            }

            $user->save();

            $userDataArr = $this->getProfileData($user);
            
            return $this->jsonResponse(true, $userDataArr, "Profile photo updated successfully.");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }  
    }
    
    /**
     * Logout, remove /remove token
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function logout()
    {
        /** @var mixed */
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return $this->jsonResponse(true, $user, "User logged out successfully.");
    }

   /**
     * Update firebase token
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function updateFirebaseToken(Request $request)
    {
        
        try {

            $validation = Validator::make($request->all(), [
                'firebase_token'    => 'required',
                'platform'          => 'nullable',
            ]);

            $errors = $validation->errors();
            
            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            User::$shouldAppends = false;
            
            $user = Auth::guard('api')->user();
            $user->firebase_token = $request->firebase_token;

            if($request->has('platform') && $request->filled('platform')) {

                $user->platform = $request->platform;
            }
            
            $user->save();

            return $this->jsonResponse(true, $user, "Firebase token updated successfully.");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }  
    }

   /**
     * Update notification settings
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function updateNotificationSettings(Request $request)
    {
        
        try {

            $validation = Validator::make($request->all(), [
                'is_notification'   => 'required',
            ]);

            $errors = $validation->errors();
            
            if(count($errors) > 0){

                return $this->jsonResponse(false, null, $errors->first(), "Error while validating user inputs");
            }

            User::$shouldAppends = false;
            
            $user = Auth::guard('api')->user();
            $user->is_notification = $request->is_notification;
            
            if($user->isDirty()){
                $user->save();
            }

            return $this->jsonResponse(true, $user, "Notification settings updated successfully.");

        } catch (\Exception $e) {

            return $this->jsonResponse(false, null, $e->getMessage(), "Error while validating user inputs");
        }  
    }
}