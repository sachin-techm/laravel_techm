<?php

namespace App\Helpers;

use Request;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use File;

class FileUploadHelper
{

    public static function UploadFile($destinationPath, $field, $newName = '')
    {

        $destinationPath = ImageUploadHelper::real_public_path() . $destinationPath;

        $extension = $field->getClientOriginalExtension();
        $fileName = Str::slug($newName, '-') . '-' . time() . '-' . rand(1, 999) . '.' . $extension;

        $field->move($destinationPath, $fileName);

        return $fileName;
    }

    public static function real_public_path()
    {
        return public_path() . DIRECTORY_SEPARATOR;
    }

    public static function deleteFile($file, $folder)
    {
        try {
            if (!empty($file)) {
                File::delete(FileUploadHelper::real_public_path() . $folder.'/' . $file);
            }
            
            return true;
        } catch (Exception $e) {
        	
            return false;
        }
    }

}
