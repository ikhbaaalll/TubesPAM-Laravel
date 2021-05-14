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

Route::post('kelas/show',           [KelasController::class, 'show']);
Route::post('kelas/destroy',        [KelasController::class, 'destroy']);
Route::post('kelas/update',         [KelasController::class, 'update']);
Route::post('kelas/list',           [KelasController::class, 'index']);
Route::post('kelas/status',         [KelasController::class, 'status']);
Route::resource('kelas', KelasController::class)->only(['store']);
