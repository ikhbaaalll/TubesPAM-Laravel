<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\UserControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login',            [UserControler::class, 'login']);
Route::post('logout',           [UserControler::class, 'logout']);

Route::post('user/index',           [UserControler::class, 'index']);
Route::post('isadmin',              [UserControler::class, 'isAdmin']);
Route::post('user/store',           [UserControler::class, 'register']);
Route::post('user/update',          [UserControler::class, 'update']);
Route::post('user/destroy',         [UserControler::class, 'destroy']);

Route::post('kelas/show',               [KelasController::class, 'show']);
Route::post('kelas/destroy',            [KelasController::class, 'destroy']);
Route::post('kelas/list',               [KelasController::class, 'index']);
Route::post('kelas/status',             [KelasController::class, 'status']);
Route::post('kelas/get/presensi',       [KelasController::class, 'getPresensi']);
Route::post('kelas/update/presensi',    [KelasController::class, 'setPresensi']);
Route::post('kelas',                    [KelasController::class, 'store']);
