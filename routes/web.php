<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffAuthDashboardController;
use App\Http\Controllers\MasterRecruitmentController;
use App\Http\Controllers\MasterJobController;
use App\Http\Controllers\MasterLeaveTypeController;
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


//login
Route::get('/', 'Auth\AuthController@login')->name('login');
Route::get('/login', 'Auth\AuthController@login')->name('login');
Route::post('/login', 'Auth\AuthController@authenticate');
Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
Route::get('/admin/dashboard', [AdminAuthDashboardController::class,'index']);
Route::get('/staff/dashboard', [StaffAuthDashboardController::class,'index']);
Route::get('/staff/password/{user}',[UserController::class,'edit']);
Route::put('/staff/password/{user}/saved',[UserController::class,'update']);
Route::get('/admin/password/{user}',[UserController::class,'edit']);
Route::put('/admin/password/{user}/saved',[UserController::class,'update']);

//route profile
Route::get('/admin/profile', [AdminAuthDashboardController::class,'profile']);
Route::get('/admin/profile/edit', [AdminAuthDashboardController::class,'editprofile']);
Route::put('/admin/profile/{user}', [AdminAuthDashboardController::class,'updateprofile']);
Route::get('/staff/profile', [StaffAuthDashboardController::class,'profile']);
Route::get('/staff/profile/edit', [StaffAuthDashboardController::class,'editprofile']);
Route::put('/staff/profile/{user}', [StaffAuthDashboardController::class,'updateprofile']);

//route recruitment
Route::get('/recruitment',[ MasterJobController::class,'index']);
Route::post('/recruitment/add',[ MasterRecruitmentController::class,'store']);
Route::get('/admin/recruitment',[ MasterRecruitmentController::class,'index']);
Route::delete('/admin/rectuitment/delete-all', [MasterRecruitmentController::class,'destroyAll']);

//route masterdata job
Route::delete('/admin/job/delete',[ MasterJobController::class,'destroy']);
Route::get('/admin/job/add',[ MasterJobController::class,'create']);
Route::post('/admin/job',[ MasterJobController::class,'store']);
Route::get('/admin/job',[ MasterJobController::class,'indexJob']);

//route masterdata staff
Route::get('/admin/data-staff',[App\Http\Controllers\DataStaffController::class,'index']);
Route::get('/admin/data-staff/add',[App\Http\Controllers\DataStaffController::class,'create']);
Route::post('/admin/data-staff', [App\Http\Controllers\DataStaffController::class, 'store']);
Route::get('/admin/data-staff/{staff}/edit', [App\Http\Controllers\DataStaffController::class, 'edit']);
Route::put('/admin/data-staff/{staff}', [App\Http\Controllers\DataStaffController::class, 'update']);
Route::delete('/admin/data-staff/', [App\Http\Controllers\DataStaffController::class, 'destroyAll']);

//route masterdata divisi
Route::get('/admin/division',[App\Http\Controllers\DivisionController::class,'index']);
Route::get('/admin/division/add',[App\Http\Controllers\DivisionController::class,'create']);
Route::post('/admin/division', [App\Http\Controllers\DivisionController::class, 'store']);
Route::get('/admin/division/{division}/edit', [App\Http\Controllers\DivisionController::class, 'edit']);
Route::put('/admin/division/{division}', [App\Http\Controllers\DivisionController::class, 'update']);
Route::delete('/admin/division', [App\Http\Controllers\DivisionController::class, 'destroyAll']);

//route masterdata posisi
Route::get('/admin/position',[App\Http\Controllers\PositionController::class,'index']);
Route::get('/admin/position/add',[App\Http\Controllers\PositionController::class,'create']);
Route::post('/admin/position', [App\Http\Controllers\PositionController::class, 'store']);
Route::get('/admin/position/{position}/edit', [App\Http\Controllers\PositionController::class, 'edit']);
Route::put('/admin/position/{position}', [App\Http\Controllers\PositionController::class, 'update']);
Route::delete('/admin/position/', [App\Http\Controllers\PositionController::class, 'destroyAll']);

//route masterdata shift
Route::get('/admin/shift',[App\Http\Controllers\ShiftController::class,'index']);
Route::get('/admin/shift/add',[App\Http\Controllers\ShiftController::class,'create']);
Route::post('/admin/shift', [App\Http\Controllers\ShiftController::class, 'store']);
Route::get('/admin/shift/{shift}/edit', [App\Http\Controllers\ShiftController::class, 'edit']);
Route::put('/admin/shift/{shift}', [App\Http\Controllers\ShiftController::class, 'update']);
Route::delete('/admin/shift/', [App\Http\Controllers\ShiftController::class, 'destroyAll']);

// Route Tipe Cuti List
Route::get('/admin/paid-leave-type',[MasterLeaveTypeController::class,'index'])->name('tablelist');
Route::get('/admin/paid-leave-type/add',[MasterLeaveTypeController::class,'create'])->name('addleavetype');
Route::post('/admin/paid-leave-type',[MasterLeaveTypeController::class,'store'])->name('save');
Route::get('/admin/paid-leave-type/{leavetype}/edit',[MasterLeaveTypeController::class,'edit']);
Route::put('/admin/paid-leave-type/{leavetype}',[MasterLeaveTypeController::class,'update'])->name('update');
Route::delete('/admin/paid-leave-type/{leavetype}',[MasterLeaveTypeController::class,'destroy']); 

//route system log

Route::get('/admin/log',[App\Http\Controllers\LogController::class,'index']);


