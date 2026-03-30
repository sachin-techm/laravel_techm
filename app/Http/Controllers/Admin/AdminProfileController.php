<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\AdminProfileRequest;
use Hash;
use Image;
use Auth;
use ImageUploadHelper;

class AdminProfileController extends Controller
{   
    /*
    |--------------------------------------------------------------------------
    | {{moduleTitle}} Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles create, update, delete and show list of {{moduleTitle}}.
    |
    */

    public static $moduleConfig = [
        "routes" => [
            "listRoute" => 'admin.profile.index',
            "fetchDataRoute" => 'admin.profile.fetch.data', 
            "createRoute" => 'admin.profile.create', 
            "storeRoute" => 'admin.profile.store', 
            "editRoute" => 'admin.profile.edit', 
            "updateRoute" => 'admin.profile.update', 
            "changePasswordRoute" => 'admin.profile.change_password',
            "updatePasswordRoute" => 'admin.password.update',
        ],
        "moduleTitle" => 'Admin Profile',
        "moduleName" => 'Admin Profile',
        "viewFolder" => 'admin_profile',
        "imageUploadFolder" => 'uploads/admin_users/',
    ];

    /**
     * Constructor Method.
     *
     * Setting Authentication
     *
     */

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');

    }

    /**
     * Show list of {{moduleTitle}}.
     *
     * @param  null
     * @return \Illuminate\Http\Response
     */

    public function changePassword()
    {
        $userId = Auth::user()->id;
        $row = Admin::findOrFail($userId);

        return view('admin.' . self::$moduleConfig['viewFolder'] . '.change_password')
            ->with('moduleConfig', self::$moduleConfig)
            ->with('row', $row);
    }

    public function updatePassword(Request $request)
    {
        $userId = Auth::user()->id;
        $user = Admin::findOrFail($userId);

        $validatedData = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'max:12', 'confirmed'],
        ], [
            'current_password.required' => 'The current password field is required.',
            'password.required' => 'The new password field is required.',
            'password.string' => 'The new password must be a string.',
            'password.min' => 'The new password must be at least :min characters.',
            'password.max' => 'The new password must not be greater than :max characters.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ]);

        // Check if the provided current password matches the user's current password
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            
            return response()->json(['success' => false, 'message' => 'Incorrect current password']);
        }

        // Change the user's password
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        \Flash::success(self::$moduleConfig['moduleTitle'].' updated successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['editRoute']);
    }



    /**
     * Show edit form of {{moduleTitle}}.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $Admin){

        $userId     = Auth::user()->id;
        $row        = Admin::findOrFail($userId);

        return view('admin.'.self::$moduleConfig['viewFolder'].'.edit')->with('moduleConfig', self::$moduleConfig)->with('row', $row);
    }

    /**
     * Update a {{moduleTitle}}.
     *
     * @param  $id
     * @return Redirect
     */
    public function update(AdminProfileRequest $request, $id)
    {
        $user = Admin::findOrFail($id);

        if ($request->hasFile('image')) {
            $image         = $request->file('image');
            $fileName      = ImageUploadHelper::uploadImage(self::$moduleConfig['imageUploadFolder'], $image, $request->input('name'), 900, 900, true);
            $user->image  = $fileName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        //dd($user);die();
        $user->contact = $request->contact;

        $user->save();

        \Flash::success(self::$moduleConfig['moduleTitle'].' updated successfully.');
        return \Redirect::route(self::$moduleConfig['routes']['editRoute']);
    }

}
