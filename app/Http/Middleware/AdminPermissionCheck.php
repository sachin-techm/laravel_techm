<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserPermission;

class AdminPermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $perm)
    {
        // dd($request);

        // dd(session('adminSettings'));
        // dd(session('systemSettings'));
        
        $routeAction 		= \Route::currentRouteAction();
        $controllerAction 	= class_basename($routeAction);

        list($controller, $action) = explode('@', $controllerAction);
        // dd([$controller, $action]);

        // dd($request->is('admin'));

        \App\Helpers\Helper::fixAdminPermissionSession();
        $rolePermission = session('rolePermission', ['roleCode' => null, 'permissions' => []]);
        // dd($rolePermission);

        if(!isset($rolePermission) || empty($rolePermission) ||
            !isset($rolePermission['roleCode']) || empty($rolePermission['roleCode']) ||
            !isset($rolePermission['permissions']) || empty($rolePermission['permissions'])

        ){
            \Flash::error("You don't have access!");
            return redirect()->route('admin.dashboard'); 
        }

        if($rolePermission['roleCode'] == 'SUPER_ADMIN'){
            return $next($request);
        }

        if(array_key_exists($perm, $rolePermission['permissions'])){

        	// dd($rolePermission['permissions'][$perm]);
			if (str_contains($action, 'view')) { 
			    $action = 'view';
			}

			if (str_contains($action, 'edit')) { 
			    $action = 'edit';
			}

			if (str_contains($action, 'delete')) { 
			    $action = 'delete';
			}

			// dd($action);

        	if( in_array($action, ['view', 'edit', 'delete']) && !array_key_exists($action, $rolePermission['permissions'][$perm])){

        		\Flash::error("You don't have edit access!");
            	return redirect()->route('admin.dashboard'); 
        	}

    		return $next($request);
        }

        \Flash::error("You don't have access.");
        return redirect()->route('admin.dashboard'); 

        // $route = \Route::current();
        // $name = \Route::currentRouteName();
        // $routeAction = \Route::currentRouteAction();
        // $routeArray = app('request')->route()->getAction();
        // $controllerAction = class_basename($routeAction);
        // list($controller, $action) = explode('@', $controllerAction);
        // dd([$route, $name, $routeAction, $controller, $action]);
    }
}
