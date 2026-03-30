<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth apis without login access
Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function () {

    Route::prefix('auth')->group(function() {

        Route::post('login', [App\Http\Controllers\API\Auth\LoginController::class, 'login']);
        Route::post('register', [App\Http\Controllers\API\Auth\RegisterController::class, 'register']);

        // Via otp
        Route::post('forgot-password', [App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'forgotPassword']);
        Route::post('verify-otp', [App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'verifyOtp']);
        Route::post('reset-password', [App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'resetPassword']);
        Route::post('resend-otp', [App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'resendOtp']);

        // Account verify
        Route::post('send-account-verification-code', [App\Http\Controllers\API\Auth\AccountVerifyController::class, 'sendAccountVerificationCode']);
        Route::post('resend-account-verification-code', [App\Http\Controllers\API\Auth\AccountVerifyController::class, 'sendAccountVerificationCode']);
        Route::post('verify-account', [App\Http\Controllers\API\Auth\AccountVerifyController::class, 'verifyAccount']);

        // Via token
        // Route::post('reset-password-link', [App\Http\Controllers\API\Auth\ResetPasswordController::class, 'requestLink']);
        // Route::get('reset-password', [App\Http\Controllers\API\Auth\ResetPasswordController::class, 'validateToken']);
        // Route::post('reset-password', [App\Http\Controllers\API\Auth\ResetPasswordController::class, 'reset']);
    });
});


Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {

    Route::get('profile', [App\Http\Controllers\API\UserController::class, 'getProfile']);
    Route::put('profile', [App\Http\Controllers\API\UserController::class, 'updateProfile']);
    Route::delete('account', [App\Http\Controllers\API\UserController::class, 'deleteAccount']);
    Route::delete('logout', [App\Http\Controllers\API\UserController::class, 'deleteAccount']);
    Route::post('update-avatar', [App\Http\Controllers\API\UserController::class, 'updateProfilePhoto']);
    Route::post('update-firebase-token', [App\Http\Controllers\API\UserController::class, 'updateFirebaseToken']);
    Route::patch('update-notification-settings', [App\Http\Controllers\API\UserController::class, 'updateNotificationSettings']);
    Route::patch('password', [App\Http\Controllers\API\Auth\PasswordController::class, 'update']);

    // Notification routes
    Route::get('notifications/{slug?}', [App\Http\Controllers\API\NotificationController::class, 'index']);
    Route::delete('notification/{id}', [App\Http\Controllers\API\NotificationController::class, 'delete']);

});

// Common apis without login access
Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function () {

    Route::get('countries/{slug?}', [App\Http\Controllers\API\CommonController::class, 'getCountries']);
    Route::get('states/{slug?}', [App\Http\Controllers\API\CommonController::class, 'getStates']);
    Route::get('cities/{slug?}', [App\Http\Controllers\API\CommonController::class, 'getCities']);

});

// Test notifications
Route::post('/test-notification', function(Request $request) {

    return \App\Notifications\FCMPushNotification::testNotification($request);
   
});

// Fallback apis without login access
Route::fallback(function () {
    return response()->json(['status' => false, 'data' => null, 'message' => 'Not Found!'], 404);
});
