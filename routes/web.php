<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SecretFriendGroupController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::controller(SecretFriendGroupController::class)->group(function () {
        Route::get('/secretFriendGroups/formCreate','formCreate')->name('secretFriendGroups.formCreate');
        Route::get('/secretFriendGroups/{secretFriendGroup}/formUpdate','formUpdate')->name('secretFriendGroups.formUpdate');
        Route::get('/home', 'index')->name('home');
    });

    Route::resource('/secretFriendGroups', SecretFriendGroupController::class);

});

Route::get('/', [IndexController::class, 'welcome'])->name('welcome');

Auth::routes();
