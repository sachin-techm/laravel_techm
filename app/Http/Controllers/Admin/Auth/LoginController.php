<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin as User;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\AdminSettings;
use App\Models\SystemSettings;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $logo = AdminSettings::first();
        return view('admin.auth.login', compact('logo'));
    }

	protected function authenticated(Request $request, User $user) {

        $user->session_id = Session::getId();
        $user->save();

        Role::$shouldAppends = false;
        RolePermission::$shouldAppends = false;
        AdminSettings::$shouldAppends = false;
        SystemSettings::$shouldAppends = false;
        
		$role 			= Role::find($user->role_id);
		$rolePermission = RolePermission::where('role_id', $user->role_id)->first();
        $adminSettings  = AdminSettings::first();
        $systemSettings = SystemSettings::first();
		
	 	session([
            'rolePermission'    => ['roleCode' => $role->role_code, 'permissions' => $rolePermission->permission_data ?? []],
            'adminSettings'     => $adminSettings->toArray(),
            'systemSettings'    => $systemSettings->toArray()
        ]);

	   	return redirect()->intended($this->redirectPath());
	}

	/**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
