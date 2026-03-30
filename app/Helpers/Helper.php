<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Carbon\Carbon;
use \App\Models\SystemSettings;
use \App\Models\OrderNumber;

class Helper
{
    
    public static function curlRequest($url, $method, $fields = [])
    {
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if($method == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            // Set here requred headers
            "accept: */*",
            "accept-language: en-US,en;q=0.8",
            "content-type: application/json",
        ]);

        
        // Execute post
        $result = curl_exec($ch);
        // dd($result);
        if ($result === FALSE) {
            // die('Curl failed: ' . curl_error($ch));
            $result = curl_error($ch);
        }

        // Close connection
        curl_close($ch);
        return $result;
    }

    public static function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function isActivate($route){

        $routeName  =   \Route::currentRouteName();        
        if(in_array($routeName, $route)){
            return 'menu-item-active menu-item-open';
        }
    }

    static function createRecursiveFolders($folder, $base_path){

        $folderArr = explode(DIRECTORY_SEPARATOR, $folder);
        $folderTmp = $base_path.DIRECTORY_SEPARATOR;
        foreach ($folderArr as $key => $value) {

            $folderTmp .= $value.DIRECTORY_SEPARATOR;

            if (!(\File::isDirectory($folderTmp))) {
                \File::makeDirectory($folderTmp);
            }
        }
    }

    public static function deleteFile($folder, $fileName)
    {
        
        if (unlink($folder . $fileName)) {
            return true;
        } else {
            echo "No file deleted";
        }
    }

    public static function generateOtp($length = 6) {

        return rand(100000, 999999);
    }
    
    public static function generateRandomString($length = 10) {
    
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )), 1, $length);
    }

    public static function isSuperAdmin($moduleName, $rolePermissionArr = []) {
    	
    	if(empty($rolePermissionArr)) {
    		
    		$rolePermissionArr = session('rolePermission', ['roleCode' => null, 'permissions' => []]);
    	}

        if(@$rolePermissionArr['roleCode'] == 'SUPER_ADMIN') {
        	
        	return true;
        }

        return false;
    }

    public static function checkPermisson($moduleName, $rolePermissionArr = []) {
    	
    	if(empty($rolePermissionArr)){
    		
    		$rolePermissionArr = session('rolePermission', ['roleCode' => null, 'permissions' => []]);
    	}

        if(
        	@$rolePermissionArr['roleCode'] == 'SUPER_ADMIN' ||
        	@array_key_exists($moduleName, @$rolePermissionArr['permissions'])
    	){
        	return true;
        }

        return false;
    }

    public static function fixAdminPermissionSession() {
        
        $rolePermissionArr = session('rolePermission', ['roleCode' => null, 'permissions' => []]);

        if( 
            isset($rolePermissionArr['roleCode']) && 
            !empty($rolePermissionArr['roleCode']) && 
            isset($rolePermissionArr['permissions']) && 
            !empty($rolePermissionArr['permissions']) && 
            is_array($rolePermissionArr['permissions'])
        ) {

            return false;
        }

        $user           = \Auth::guard('admin')->user();

        if($user) {

            $role           = \App\Models\Role::find($user->role_id);
            $rolePermission = \App\Models\RolePermission::where('role_id', $user->role_id)->first();
            
            if($rolePermission && $role) {

                session([
                    'rolePermission' => 
                    [
                        'roleCode' => $role->role_code, 
                        'permissions' => $rolePermission->permission_data ?? []
                    ]
                ]);
            }
        }
    }

    public static function encrypt($string): string
   	{
   		if(empty($string)) return '';
        try {
        	return Crypt::encryptString($string);
        } catch (EncryptException $e) {
        	return '';
        }
   	}

   	public static function decrypt($string): string
    {
    	if(empty($string)) return 'N/A';
        try {
        	return Crypt::decryptString($string);
        } catch (DecryptException $e) {
        	return 'N/A';
        }
    }

    public static function setDateFromFormat($value){
        
        try {
            
            if(empty($value)){
                return NULL;
            }
            
            return Carbon::createFromFormat(env('DATE_PICKER_DATE_FORMAT', 'm/d/Y'), $value)->format(env('SQL_DATE_FORMAT', 'Y-m-d'));
        
        } catch (\Exception $e) {
            return NULL;
        }
    }

    public static function getDateFromFormat($value){
        
        try {
            if($value && strtotime($value) > 0){
                return Carbon::createFromFormat(env('SQL_DATE_FORMAT', 'Y-m-d'), $value)->format(env('DATE_PICKER_DATE_FORMAT', 'm-d-Y'));
            }

            return NULL;
        } catch (\Exception $e) {
            return NULL;
        }
    }

    public static function getDateFromFormat2($dateObj){
        
        try {
            if($dateObj && strtotime($dateObj) > 0){
                return $dateObj->format(env('DATE_PICKER_DATE_FORMAT', 'm-d-Y'));
            }

            return NULL;

        } catch (\Exception $e) {
            return NULL;
        }
    }

    // public function updateEnv($data = array())
    // {
    //     if (!count($data)) {
    //         return;
    //     }

    //     $pattern = '/([^\=]*)\=[^\n]*/';

    //     $envFile = base_path() . '/.env';
    //     $lines = file($envFile);
    //     $newLines = [];
    //     foreach ($lines as $line) {
    //         preg_match($pattern, $line, $matches);

    //         if (!count($matches)) {
    //             $newLines[] = $line;
    //             continue;
    //         }

    //         if (!key_exists(trim($matches[1]), $data)) {
    //             $newLines[] = $line;
    //             continue;
    //         }

    //         $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
    //         $newLines[] = $line;
    //     }

    //     $newContent = implode('', $newLines);
    //     file_put_contents($envFile, $newContent);
    // }

    // public static function changeEnvironmentVariable($key,$value)
    // {
    //     $path = base_path('.env');

    //     if(is_bool(env($key)))
    //     {
    //         $old = env($key)? 'true' : 'false';
    //     }
    //     elseif(env($key)===null){
    //         $old = 'null';
    //     }
    //     else{
    //         $old = env($key);
    //     }

    //     if (file_exists($path)) {
    //         file_put_contents($path, str_replace(
    //             "$key=".$old, "$key=".$value, file_get_contents($path)
    //         ));
    //     }
    // }

    private function setEnv($key, $value)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . env($value),
            $key . '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

}