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

// Auth::routes(['verify' => true]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/gallery/fetch-images', [App\Http\Controllers\GalleryController::class, 'fetchGalleryImages'])->name('admin.gallery.fetch.data');

Route::fallback(function () {

    if (request()->is('admin') || request()->is('admin/*')) {
        return response()->view('errors.admin.404', [], 404);
    }

    return response()->view('errors.404', [], 404);
});