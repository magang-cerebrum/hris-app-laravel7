<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthDashboardController;
use App\Http\Controllers\StaffAuthDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataStaffController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\MasterLeaveTypeController;
use App\Http\Controllers\MasterJobScheduleController;
use App\Http\Controllers\MasterAchievementController;
use App\Http\Controllers\TransactionPaidLeaveController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TransactionTicketingController;
use App\Http\Controllers\MasterJobController;
use App\Http\Controllers\MasterRecruitmentController;
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


//route autentikasi
Route::get('/', 'Auth\AuthController@login')->name('login');
Route::get('/login', 'Auth\AuthController@login')->name('login');
Route::post('/login', 'Auth\AuthController@authenticate');
Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

Route::get('/admin/dashboard', [AdminAuthDashboardController::class,'index'])->middleware('auth');
Route::get('/staff/dashboard', [StaffAuthDashboardController::class,'index'])->middleware('auth');
Route::get('/staff/charts/ajax', [StaffAuthDashboardController::class,'ajx'])->name('ajx');
Route::get('/staff/password',[UserController::class,'edit'])->middleware('auth');
Route::put('/staff/password/saved',[UserController::class,'update'])->middleware('auth');
Route::get('/admin/password',[UserController::class,'edit'])->middleware('auth');
Route::put('/admin/password/saved',[UserController::class,'update'])->middleware('auth');

//route profile
Route::get('/admin/profile', [AdminAuthDashboardController::class,'profile']);
Route::get('/admin/profile/edit', [AdminAuthDashboardController::class,'editprofile']);
Route::put('/admin/profile/{user}', [AdminAuthDashboardController::class,'updateprofile']);
Route::get('/staff/profile', [StaffAuthDashboardController::class,'profile']);
Route::get('/staff/profile/edit', [StaffAuthDashboardController::class,'editprofile']);
Route::put('/staff/profile/{user}', [StaffAuthDashboardController::class,'updateprofile']);

//route landing dashboard, ganti password & profil ==ADMIN==
Route::prefix('/admin')->group(function () {
    Route::get('/dashboard', [AdminAuthDashboardController::class,'index']);
    Route::get('/password/{user}',[UserController::class,'edit']);
    Route::put('/password/{user}/saved',[UserController::class,'update']);
    Route::get('/profile', [AdminAuthDashboardController::class,'profile']);
    Route::get('/profile/edit', [AdminAuthDashboardController::class,'editprofile']);
    Route::put('/profile/{user}', [AdminAuthDashboardController::class,'updateprofile']);
});

//route landing dashboard, ganti password & profil ==STAFF==
Route::prefix('/staff')->group(function(){
    Route::get('/dashboard', [StaffAuthDashboardController::class,'index']);
    Route::get('/password/{user}',[UserController::class,'edit']);
    Route::put('/password/{user}/saved',[UserController::class,'update']);
    Route::get('/profile', [StaffAuthDashboardController::class,'profile']);
    Route::get('/profile/edit', [StaffAuthDashboardController::class,'editprofile']);
    Route::put('/profile/{user}', [StaffAuthDashboardController::class,'updateprofile']);
});

//route masterdata staff
Route::prefix('/admin/data-staff')->group(function(){
    Route::get('/',[DataStaffController::class,'index']);
    Route::get('/add',[DataStaffController::class,'create']);
    Route::post('/', [DataStaffController::class, 'store']);
    Route::get('/{staff}/edit', [DataStaffController::class, 'edit']);
    Route::put('/{staff}', [DataStaffController::class, 'update']);
    Route::delete('/', [DataStaffController::class, 'destroyAll']);
});

//route masterdata divisi
Route::prefix('/admin/division')->group(function(){
    Route::get('/',[DivisionController::class,'index']);
    Route::get('/add',[DivisionController::class,'create']);
    Route::post('/', [DivisionController::class, 'store']);
    Route::get('/{division}/edit', [DivisionController::class, 'edit']);
    Route::put('/{division}', [DivisionController::class, 'update']);
    Route::delete('', [DivisionController::class, 'destroyAll']);
});

//route masterdata posisi
Route::prefix('/admin/position')->group(function(){
    Route::get('/',[PositionController::class,'index']);
    Route::get('/add',[PositionController::class,'create']);
    Route::post('/', [PositionController::class, 'store']);
    Route::get('/{position}/edit', [PositionController::class, 'edit']);
    Route::put('/{position}', [PositionController::class, 'update']);
    Route::delete('/', [PositionController::class, 'destroyAll']);
});

//route masterdata shift
Route::prefix('/admin/shift')->group(function(){
    Route::get('/',[ShiftController::class,'index']);
    Route::get('/add',[ShiftController::class,'create']);
    Route::post('/', [ShiftController::class, 'store']);
    Route::get('/{shift}/edit', [ShiftController::class, 'edit']);
    Route::put('/{shift}', [ShiftController::class, 'update']);
    Route::delete('/', [ShiftController::class, 'destroyAll']);
});

//route masterdata tipe cuti
Route::prefix('/admin/paid-leave-type')->group(function (){
    Route::get('/',[MasterLeaveTypeController::class,'index'])->name('tablelist');
    Route::get('/add',[MasterLeaveTypeController::class,'create'])->name('addleavetype');
    Route::post('/',[MasterLeaveTypeController::class,'store'])->name('save');
    Route::get('/{leavetype}/edit',[MasterLeaveTypeController::class,'edit']);
    Route::put('/{leavetype}',[MasterLeaveTypeController::class,'update'])->name('update');
    Route::delete('/',[MasterLeaveTypeController::class,'destroyAll']); 
});

// route masterdata hari libur
Route::prefix('/admin/holiday')->group(function() {
    Route::get('/',[HolidayController::class, 'index']);
    Route::get('/add',[HolidayController::class, 'create']);
    Route::post('/',[HolidayController::class, 'store']);
    Route::get('/{holiday}/edit',[HolidayController::class, 'edit']);
    Route::put('/{holiday}',[HolidayController::class, 'update']);
    Route::delete('/',[HolidayController::class, 'destroy']);
});

//route jadwal kerja admin & staff
Route::prefix('/admin/schedule')->group(function() {
    Route::get('/',[MasterJobScheduleController::class, 'index_month']);
    Route::post('/search',[MasterJobScheduleController::class, 'result_calendar']);
    Route::get('/add',[MasterJobScheduleController::class, 'filter']);
    Route::post('/add-schedule',[MasterJobScheduleController::class, 'schedule_add']);
    Route::post('/post',[MasterJobScheduleController::class, 'schedule_post']);
});
Route::prefix('/staff/schedule')->group(function() {
    Route::get('/',[MasterJobScheduleController::class, 'staff_calendar']);
    Route::post('/search',[MasterJobScheduleController::class, 'result_calendar']);
    Route::get('/add',[MasterJobScheduleController::class, 'filter']);
    Route::post('/add-schedule',[MasterJobScheduleController::class, 'schedule_add']);
    Route::post('/post',[MasterJobScheduleController::class, 'schedule_post']);
    Route::get('/division',[MasterJobScheduleController::class, 'index_month']);
});


//route transaksi cuti ==ADMIN==
Route::prefix('/admin/paid-leave')->group(function(){
    Route::get('/',[TransactionPaidLeaveController::class,'index']);
    Route::get('/history',[TransactionPaidLeaveController::class,'history']);
    Route::put('/approve',[TransactionPaidLeaveController::class,'update_approve']);
    Route::delete('/delete',[TransactionPaidLeaveController::class,'destroy']);
});

//route transaksi cuti ==STAFF==
Route::prefix('/staff/paid-leave')->group(function(){
    Route::get('/',[TransactionPaidLeaveController::class,'create']);
    Route::post('/',[TransactionPaidLeaveController::class,'store']);
    Route::get('/history',[TransactionPaidLeaveController::class,'show']);
    Route::delete('/delete',[TransactionPaidLeaveController::class,'destroy_staff']);
    Route::get('/{id}/cancel',[TransactionPaidLeaveController::class,'cancel_staff']);
});

//route transaction ticketing ==ADMIN==
Route::prefix('/admin/ticketing')->group(function (){
    Route::get('/',[TransactionTicketingController::class,'admin_index']);
    Route::get('/{ticket}/edit',[TransactionTicketingController::class,'admin_edit']);
    Route::put('/on-progress',[TransactionTicketingController::class,'make_on_progress']);
    Route::put('/{ticket}',[TransactionTicketingController::class,'admin_response']);
    Route::delete('/',[TransactionTicketingController::class,'admin_delete']);
});

//route transaction ticketing ==STAFF==
Route::prefix('/staff/ticketing')->group(function (){
    Route::get('/',[TransactionTicketingController::class,'staff_index']);
    Route::get('/create',[TransactionTicketingController::class,'staff_create']);
    Route::post('/input',[TransactionTicketingController::class,'staff_input']);
});

//route achievement ==ADMIN==
Route::prefix('/admin/achievement')->group(function () {
    Route::get('/', [App\Http\Controllers\MasterAchievementController::class,'index']);
    Route::get('/scoring',[MasterAchievementController::class,'scoring']);
    Route::post('/scoring',[MasterAchievementController::class,'scored']);
    Route::post('/search',[MasterAchievementController::class,'search']);
    Route::get('/charts', [MasterAchievementController::class,'admin_chart_index']);
});

//route achievement ==STAFF==

//route staff presence
Route::prefix('/staff/presence')->group(function () {
    Route::get('/',[PresenceController::class,'staff_view']);
    Route::get('/test',[PresenceController::class,'test_presence']);
    Route::post('/search',[PresenceController::class,'search']);
});

//route sistem log
Route::prefix('/admin/log')->group(function(){
    Route::get('/',[LogController::class,'index']);
    Route::delete('/',[LogController::class,'destroyselected']);
});

//route masterdata job
Route::prefix('/admin/job')->group(function (){
    Route::get('/',[ MasterJobController::class,'indexJob']);
    Route::post('/',[ MasterJobController::class,'store']);
    Route::get('/add',[ MasterJobController::class,'create']);
    Route::delete('/delete',[ MasterJobController::class,'destroy']);
});

//route recruitment
Route::get('/recruitment',[ MasterJobController::class,'index']);
Route::post('/recruitment/add',[ MasterRecruitmentController::class,'store']);
Route::get('/admin/recruitment',[ MasterRecruitmentController::class,'index']);
Route::delete('/admin/recruitment/delete-all', [MasterRecruitmentController::class,'destroyAll']);
