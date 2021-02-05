<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffAuthDashboardController;
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

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/login', 'Auth\AuthController@login')->name('login');
Route::post('/login', 'Auth\AuthController@authenticate');
Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
Route::get('/dashboard/admin', [AdminAuthDashboardController::class,'index']);
Route::get('/dashboard/staff', [StaffAuthDashboardController::class,'index']);
Route::get('/staff/password/{user}',[UserController::class,'edit']);
Route::put('/staff/password/{user}/saved',[UserController::class,'update']);
