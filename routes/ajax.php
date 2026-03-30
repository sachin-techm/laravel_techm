<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('countries', 'App\Http\Controllers\AjaxController@getCountry')->name('ajax.countries');
Route::get('states/{country_id?}', 'App\Http\Controllers\AjaxController@getStates')->name('ajax.states');
Route::get('cities/{state_id?}', 'App\Http\Controllers\AjaxController@getCity')->name('ajax.cities');

// For Delete Routes
Route::get('delete-gallery-repeater/{id?}', 'App\Http\Controllers\AjaxController@deleteGalleryRepeater');