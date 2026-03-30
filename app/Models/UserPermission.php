<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Common\MasterModel;

class UserPermission extends MasterModel
{
    use HasFactory;

    public static function checkPermission($param)
    {
    	$user = \Auth::guard()->user();

    	$userPermissionsArr = \Cache::get( 'UserPermission_'.$user->role_id );

    	if(empty($userPermissionsArr))
    	{
			    		
	    	$userPermissions = UserPermission::select('is_allowed', 'route_name')->where(['role_id' => $user->role_id, 'status' => true ])->get();
	        if($userPermissions->count() == 0)
	        {
	        	return false;
	        }

    		$userPermissionsArr = $userPermissions->pluck('is_allowed', 'route_name')->toArray();
    		\Cache::Forever('UserPermission_'.$user->role_id, $userPermissionsArr , 15);
    	}

        return isset($userPermissionsArr[$param]) && $userPermissionsArr[$param] == true ? true: false;
    }
}
