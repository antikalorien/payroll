<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('GetAttendaceToDevice', 'C_SolutionAttendace@getAttendaceToDevice');

// insert Periode Jadwal
Route::post('PostPeriodeJadwal', 'sync_master@addPeriode');

// service ---------------------------------------------------------
Route::controller(service_penggajian::class)->group(function () {
    Route::get('get_periode', 'getPeriode'); 
    Route::post('gajiku', 'getPenggajian'); 
});

Route::controller(service_login::class)->group(function () {
    Route::post('edit_password', 'editPassword'); 
});
