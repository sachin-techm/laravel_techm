<?php

namespace App\Helpers;

use Request;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use File;

class ImageUploadHelper
{

    private static $mainImgWidth = 900;
    private static $mainImgHeight = 900;

    private static $thumbImgWidth1 = 250;
    private static $thumbImgHeight1 = 250;

    private static $thumbFolder = 'thumbnails/250/';

    public static function uploadImage($destinationPath, $field, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true)
    {
        if ($width > 0 && $height > 0) {
            self::$mainImgWidth = $width;
            self::$mainImgHeight = $height;
        }

        $destinationPath    = ImageUploadHelper::real_public_path() . $destinationPath;
        
        $extension          = $field->getClientOriginalExtension();
        $fileName           = Str::slug($newName, '-') . '-' . time() . '-' . rand(1, 999) . '.' . $extension;

        // Original image will be replaced by resized image
        $field->move($destinationPath, $fileName);

        /************* Resizing Images *************/
        $imageToResize          = Image::make($destinationPath . '/' . $fileName);
        $destinationFullPath    = $destinationPath . '/' . $fileName;

        $imageToResize->resize(self::$mainImgWidth, self::$mainImgHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationFullPath);

        if ($makeOtherSizesImages) {

            $thumbnailFullPath       = $destinationPath . '/' . self::$thumbFolder . $fileName;
            self::createThumbnail($destinationFullPath, $thumbnailFullPath);
        }
        /************* End Resizing Images *************/

        return $fileName;
    }

    public static function createThumbnail($source, $destination)
    {

        $imageToResize = Image::make($source);
        $imageToResize->resize(self::$thumbImgWidth1, self::$thumbImgHeight1, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destination);

    }

    public static function uploadImageBase64($destination, $base64String, $newName = '', $width = 0, $height = 0, $makeOtherSizesImages = true) {

        try {
            
            if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $base64String)) {
                return null;
            }
            
            $imageContents = base64_decode($base64String);

            // If its not base64 end processing and return false
            if ($imageContents === false) {
                return null;
            }

            $img = $base64String;
            $img = str_replace('data:image/jpg;base64,', '', $img);
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);

            if(strlen($img) < 25) {
                return null;
            }
            
            $extension              = 'jpg';
            $uploadBasePath         = ImageUploadHelper::real_public_path();
            $data                   = base64_decode($img);
            $fileName               = Str::slug($newName, '-') . '-' . time() . '-' . rand(10000, 99999) . '.' . $extension;
            $destinationFullPath    = $uploadBasePath . $destination . $fileName;
            $success                = file_put_contents($destinationFullPath, $data);

            /************* Resizing Images *************/
            if ($width > 0 && $height > 0) {
                self::$mainImgWidth = $width;
                self::$mainImgHeight = $height;
            }
            
            $imageToResize          = Image::make($destinationFullPath);

            $imageToResize->resize(self::$mainImgWidth, self::$mainImgHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationFullPath);

            if ($makeOtherSizesImages) {

                $thumbnailFullPath       = $uploadBasePath . $destination . self::$thumbFolder . $fileName;
                self::createThumbnail($destinationFullPath, $thumbnailFullPath);
            }

            return $fileName;

        } catch (Exception $e) {
            
            return null;
        }
        
    }

    public static function saveImage($request, $file_name, $destination)
    {
        $image = $request->file($file_name);
        $input['file_name'] = uniqid() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path($folder);
        $image->move($destinationPath, $input['file_name']);
        return $input['file_name'];
    }

    public static function real_public_path()
    {
        return public_path() . DIRECTORY_SEPARATOR;
    }

    public static function deleteImage($image, $folder)
    {
        try {
            if (!empty($image)) {
                File::delete(ImageUploadHelper::real_public_path() . $folder.'/' . $image);
                File::delete(ImageUploadHelper::real_public_path() . $folder.'/thumbnails/250/' . $image);
            }
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
