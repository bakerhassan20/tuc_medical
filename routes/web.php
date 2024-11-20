<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SpareController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EngineerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;



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

    Route::resource('departments', DepartmentController::class);
    Route::resource('engineers', EngineerController::class);

    Route::resource('devices', DeviceController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('stores', StoreController::class);
    Route::resource('spares', SpareController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('books', BookController::class);

    
    Route::get('/get-devices-by-department', [ReportController::class, 'getDevicesByDepartment'])->name('get.devices.by.department');









    });
require __DIR__.'/auth.php';
