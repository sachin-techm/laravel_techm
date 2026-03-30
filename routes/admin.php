<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');

    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');
        
    Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset']);
    
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');        
        Route::get('/profile/edit', [App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('profile.edit');        
        Route::put('/update/{id}', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');        
        Route::get('/profile/change-password', [App\Http\Controllers\Admin\AdminProfileController::class, 'changePassword'])->name('profile.change_password');
        Route::put('/profile/update-password', [App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('password.update');

        Route::group(['prefix' => 'admin-user', 'middleware' => ['AdminPermissionCheck:AdminUserController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin_user.'], function(){
                Route::get('list/',                     'AdminUserController@index')->name('index');
                Route::post('fetch-data/',              'AdminUserController@fetchData')->name('fetch.data');
                Route::get('create/',                   'AdminUserController@create')->name('create');
                Route::post('store/',                   'AdminUserController@store')->name('store');
                Route::get('show/{id}',                 'AdminUserController@show')->name('show');
                Route::get('edit/{id}',                 'AdminUserController@edit')->name('edit');
                Route::put('update/{id}',               'AdminUserController@update')->name('update');
                Route::get('delete/{id}',               'AdminUserController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'system-settings', 'middleware' => ['AdminPermissionCheck:SystemSettingsController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'system_settings.'], function(){
                Route::get('list/',                     'SystemSettingsController@index')->name('index');
                Route::post('fetch-data/',              'SystemSettingsController@fetchData')->name('fetch.data');
                Route::get('create/',                   'SystemSettingsController@create')->name('create');
                Route::post('store/',                   'SystemSettingsController@store')->name('store');
                Route::get('show/{id}',                 'SystemSettingsController@show')->name('show');
                Route::get('edit/{id}',                 'SystemSettingsController@edit')->name('edit');
                Route::put('update/{id}',               'SystemSettingsController@update')->name('update');
                Route::get('delete/{id}',               'SystemSettingsController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'admin-settings', 'middleware' => ['AdminPermissionCheck:AdminSettingsController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin_settings.'], function(){
                Route::get('list/',                     'AdminSettingsController@index')->name('index');
                Route::post('fetch-data/',              'AdminSettingsController@fetchData')->name('fetch.data');
                Route::get('create/',                   'AdminSettingsController@create')->name('create');
                Route::post('store/',                   'AdminSettingsController@store')->name('store');
                Route::get('show/{id}',                 'AdminSettingsController@show')->name('show');
                Route::get('edit/{id}',                 'AdminSettingsController@edit')->name('edit');
                Route::put('update/{id}',               'AdminSettingsController@update')->name('update');
                Route::get('delete/{id}',               'AdminSettingsController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'sms-template', 'middleware' => ['AdminPermissionCheck:SmsTemplateController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'sms_template.'], function(){
                Route::get('list/',                     'SmsTemplateController@index')->name('index');
                Route::post('fetch-data/',              'SmsTemplateController@fetchData')->name('fetch.data');
                Route::get('create/',                   'SmsTemplateController@create')->name('create');
                Route::post('store/',                   'SmsTemplateController@store')->name('store');
                Route::get('show/{id}',                 'SmsTemplateController@show')->name('show');
                Route::get('edit/{id}',                 'SmsTemplateController@edit')->name('edit');
                Route::put('update/{id}',               'SmsTemplateController@update')->name('update');
                Route::get('delete/{id}',               'SmsTemplateController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'email-template', 'middleware' => ['AdminPermissionCheck:EmailTemplateController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'email_template.'], function(){
                Route::get('list/',                     'EmailTemplateController@index')->name('index');
                Route::post('fetch-data/',              'EmailTemplateController@fetchData')->name('fetch.data');
                Route::get('create/',                   'EmailTemplateController@create')->name('create');
                Route::post('store/',                   'EmailTemplateController@store')->name('store');
                Route::get('show/{id}',                 'EmailTemplateController@show')->name('show');
                Route::get('edit/{id}',                 'EmailTemplateController@edit')->name('edit');
                Route::put('update/{id}',               'EmailTemplateController@update')->name('update');
                Route::get('delete/{id}',               'EmailTemplateController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'user-role', 'middleware' => ['AdminPermissionCheck:UserRoleController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'user_role.'], function(){
                Route::get('list/',                     'UserRoleController@index')->name('index');
                Route::post('fetch-data/',              'UserRoleController@fetchData')->name('fetch.data');
                Route::get('create/',                   'UserRoleController@create')->name('create');
                Route::post('store/',                   'UserRoleController@store')->name('store');
                Route::get('show/{id}',                 'UserRoleController@show')->name('show');
                Route::get('edit/{id}',                 'UserRoleController@edit')->name('edit');
                Route::put('update/{id}',               'UserRoleController@update')->name('update');
                Route::get('delete/{id}',               'UserRoleController@delete')->name('delete');
                Route::get('permission/{id}',           'UserRoleController@permission')->name('permission');
                Route::post('save_permission',          'UserRoleController@save_permission')->name('save_permission');
            });
        });

        Route::group(['prefix' => 'permission', 'middleware' => ['AdminPermissionCheck:PermissionController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'permission.'], function(){
                Route::get('list/',                     'PermissionController@index')->name('index');
                Route::post('fetch-data/',              'PermissionController@fetchData')->name('fetch.data');
                Route::get('create/',                   'PermissionController@create')->name('create');
                Route::post('store/',                   'PermissionController@store')->name('store');
                Route::get('show/{id}',                 'PermissionController@show')->name('show');
                Route::get('edit/{id}',                 'PermissionController@edit')->name('edit');
                Route::put('update/{id}',               'PermissionController@update')->name('update');
                Route::get('delete/{id}',               'PermissionController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'push-notification', 'middleware' => ['AdminPermissionCheck:PushNotificationController']], function(){

            // Category routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'push_notification.'], function(){
                Route::get('list/',        'PushNotificationController@index')->name('index');
                Route::post('fetch-data/', 'PushNotificationController@fetchData')->name('fetch.data');
                Route::get('create/',      'PushNotificationController@create')->name('create');
                Route::post('store/',      'PushNotificationController@store')->name('store');
                Route::get('show/{id}',    'PushNotificationController@show')->name('show');
                Route::get('edit/{id}',    'PushNotificationController@edit')->name('edit');
                Route::put('update/{id}',  'PushNotificationController@update')->name('update');
                Route::get('delete/{id}',  'PushNotificationController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'admin-module', 'middleware' => ['AdminPermissionCheck:AdminModuleController']], function(){

            // program routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin_module.'], function(){
                Route::get('list/',                     'AdminModuleController@index')->name('index');
                Route::post('fetch-data/',              'AdminModuleController@fetchData')->name('fetch.data');
                Route::get('create/',                   'AdminModuleController@create')->name('create');
                Route::post('store/',                   'AdminModuleController@store')->name('store');
                Route::get('show/{id}',                 'AdminModuleController@show')->name('show');
                Route::get('edit/{id}',                 'AdminModuleController@edit')->name('edit');
                Route::put('update/{id}',               'AdminModuleController@update')->name('update');
                Route::get('delete/{id}',               'AdminModuleController@delete')->name('delete');
            });
        });

        Route::group(['prefix' => 'user', 'middleware' => ['AdminPermissionCheck:UserController']], function(){

            // User routes
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'user.'], function(){
                Route::get('list/',           'UserController@index')->name('index');
                Route::post('fetch-data/',    'UserController@fetchData')->name('fetch.data');
                Route::get('create/',         'UserController@create')->name('create');
                Route::post('store/',         'UserController@store')->name('store');
                Route::get('show/{id}',       'UserController@show')->name('show');
                Route::get('edit/{id}',       'UserController@edit')->name('edit');
                Route::put('update/{id}',     'UserController@update')->name('update');
                Route::get('delete/{id}',     'UserController@delete')->name('delete');
                Route::post('export/',        'UserController@export')->name('export');
            });
        });
        
        // SpeakerType routes
        Route::group(['prefix' => 'speaker-type', 'middleware' => ['AdminPermissionCheck:SpeakerTypeController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'speaker_type.'], function(){
                Route::get('list/',         'SpeakerTypeController@index')->name('index');
                Route::post('fetch-data/',  'SpeakerTypeController@fetchData')->name('fetch.data');
                Route::get('create/',       'SpeakerTypeController@create')->name('create');
                Route::post('store/',       'SpeakerTypeController@store')->name('store');
                Route::get('show/{id}',     'SpeakerTypeController@show')->name('show');
                Route::get('edit/{id}',     'SpeakerTypeController@edit')->name('edit');
                Route::put('update/{id}',   'SpeakerTypeController@update')->name('update');
                Route::get('delete/{id}',   'SpeakerTypeController@delete')->name('delete');
            });
        });

        // Speaker routes
        Route::group(['prefix' => 'speaker', 'middleware' => ['AdminPermissionCheck:SpeakerController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'speaker.'], function(){
                Route::get('list/',           'SpeakerController@index')->name('index');
                Route::post('fetch-data/',    'SpeakerController@fetchData')->name('fetch.data');
                Route::get('create/',         'SpeakerController@create')->name('create');
                Route::post('store/',         'SpeakerController@store')->name('store');
                Route::get('show/{id}',       'SpeakerController@show')->name('show');
                Route::get('edit/{id}',       'SpeakerController@edit')->name('edit');
                Route::put('update/{id}',     'SpeakerController@update')->name('update');
                Route::get('delete/{id}',     'SpeakerController@delete')->name('delete');
                Route::post('export/',        'SpeakerController@export')->name('export');
            });
        });

        // Testimonial routes
        Route::group(['prefix' => 'testimonial', 'middleware' => ['AdminPermissionCheck:TestimonialController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'testimonial.'], function(){
                Route::get('list/',         'TestimonialController@index')->name('index');
                Route::post('fetch-data/',  'TestimonialController@fetchData')->name('fetch.data');
                Route::get('create/',       'TestimonialController@create')->name('create');
                Route::post('store/',       'TestimonialController@store')->name('store');
                Route::get('show/{id}',     'TestimonialController@show')->name('show');
                Route::get('edit/{id}',     'TestimonialController@edit')->name('edit');
                Route::put('update/{id}',   'TestimonialController@update')->name('update');
                Route::get('delete/{id}',   'TestimonialController@delete')->name('delete');
            });
        });

        // Sponsor routes
        Route::group(['prefix' => 'sponsor', 'middleware' => ['AdminPermissionCheck:SponsorController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'sponsor.'], function(){
                Route::get('list/',         'SponsorController@index')->name('index');
                Route::post('fetch-data/',  'SponsorController@fetchData')->name('fetch.data');
                Route::get('create/',       'SponsorController@create')->name('create');
                Route::post('store/',       'SponsorController@store')->name('store');
                Route::get('show/{id}',     'SponsorController@show')->name('show');
                Route::get('edit/{id}',     'SponsorController@edit')->name('edit');
                Route::put('update/{id}',   'SponsorController@update')->name('update');
                Route::get('delete/{id}',   'SponsorController@delete')->name('delete');
            });
        });

        // Edition routes
        Route::group(['prefix' => 'edition', 'middleware' => ['AdminPermissionCheck:EditionController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'edition.'], function(){
                Route::get('list/',         'EditionController@index')->name('index');
                Route::post('fetch-data/',  'EditionController@fetchData')->name('fetch.data');
                Route::get('create/',       'EditionController@create')->name('create');
                Route::post('store/',       'EditionController@store')->name('store');
                Route::get('show/{id}',     'EditionController@show')->name('show');
                Route::get('edit/{id}',     'EditionController@edit')->name('edit');
                Route::put('update/{id}',   'EditionController@update')->name('update');
                Route::get('delete/{id}',   'EditionController@delete')->name('delete');
            });
        });

        // Gallery routes
        Route::group(['prefix' => 'gallery', 'middleware' => ['AdminPermissionCheck:GalleryController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'gallery.'], function(){
                Route::get('list/',         'GalleryController@index')->name('index');
                Route::post('fetch-data/',  'GalleryController@fetchData')->name('fetch.data');
                Route::get('create/',       'GalleryController@create')->name('create');
                Route::post('store/',       'GalleryController@store')->name('store');
                Route::get('show/{id}',     'GalleryController@show')->name('show');
                Route::get('edit/{id}',     'GalleryController@edit')->name('edit');
                Route::put('update/{id}',   'GalleryController@update')->name('update');
                Route::get('delete/{id}',   'GalleryController@delete')->name('delete');
            });
        });

        // Schedule routes
        Route::group(['prefix' => 'schedule', 'middleware' => ['AdminPermissionCheck:ScheduleController']], function(){
            Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'schedule.'], function(){
                Route::get('list/',         'ScheduleController@index')->name('index');
                Route::post('fetch-data/',  'ScheduleController@fetchData')->name('fetch.data');
                Route::get('create/',       'ScheduleController@create')->name('create');
                Route::post('store/',       'ScheduleController@store')->name('store');
                Route::get('show/{id}',     'ScheduleController@show')->name('show');
                Route::get('edit/{id}',     'ScheduleController@edit')->name('edit');
                Route::put('update/{id}',   'ScheduleController@update')->name('update');
                Route::get('delete/{id}',   'ScheduleController@delete')->name('delete');
            });
        });
    });
});