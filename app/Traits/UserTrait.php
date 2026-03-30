<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\User;
use App\Models\SystemSettings;
use Carbon\Carbon;
use DB;
use Hash;
use Image;
use Auth;
use Helper;
use ImageUploadHelper;
use FileUploadHelper;

trait UserTrait
{
    /**
     * Update a {{moduleTitle}}.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  int $user_id | null
     * @return \App\Models\User $User
     */
    public function storeUpdate(Request $request, $user_id = NULL)
    {
        $user       = User::findOrNew($user_id);

        if ($request->hasFile('user_image')) {

            $user_image         = $request->file('user_image');
            $user_image         = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $user_image, $request->input('name', 'User-avatar'), 600, 600, true);
            $user->user_image   = $user_image;
        }

        if ($request->has('first_name') && $request->filled('first_name')) {
            $user->first_name = $request->first_name;
        }

        if ($request->has('last_name') && $request->filled('last_name')) {
            $user->last_name = $request->last_name;
        }

        if ($request->has('email') && $request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->has('contact') && $request->filled('contact')) {
            $user->contact = $request->contact;
        }

        if ($request->has('password') && $request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->organization          =  $request->organization;
        $user->gender                =  $request->gender;
        $user->country_id            =  $request->country_id;
        $user->state_id              =  $request->state_id;
        $user->city_id               =  $request->city_id;
        $user->pin_code              =  $request->pin_code;        
        $user->status                =  $request->input('status', 0);
        $user->save();
        return $user;

    }

}