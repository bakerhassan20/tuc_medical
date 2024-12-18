<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SpareController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
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
    Route::resource('clinics', ClinicController::class);

    Route::get('/get-devices-by-department', [ReportController::class, 'getDevicesByDepartment'])->name('get.devices.by.department');


    Route::get('get-settings', [SettingController::class, 'getSettings'])->name('get.settings');
    Route::post('set-settings', [SettingController::class, 'setSettings'])->name('set.settings');






    //delete Notifications
    Route::post('/markAs',function(Request $r){
        auth()->user()->unreadNotifications->find($r->not_id)->delete();
        return redirect()->back();
    })->name('markAs');

    //markAsRead
    Route::get('/markAsRead', function(){
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
            return redirect()->back();
        })->name('mark');



    });
require __DIR__.'/auth.php';
