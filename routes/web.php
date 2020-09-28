<?php

use App\Http\{Controllers\DepartmentController,
    Controllers\UserController,
    Controllers\StatsController};
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google_auth', [UserController::class,'redirectToProvider']);
Route::get('/google_callback',[UserController::class,'handleProviderCallback']);


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('departments',DepartmentController::class);
    Route::resource('users', UserController::class);
    Route::get('/stats',[StatsController::class,'index'])->name('graph');
});
