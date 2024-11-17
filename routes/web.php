<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'profile_update'])->name('profile.update');
    Route::post('/update-password', [App\Http\Controllers\HomeController::class, 'update_password'])->name('profile.update-password');


    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');




    });
require __DIR__.'/auth.php';
