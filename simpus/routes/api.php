<?php

use App\Http\Controllers\APIController\AntrianController;
use App\Http\Controllers\Simpusk\AuthController;
use App\Http\Controllers\Simpusk\LoginController;
use App\Http\Controllers\Simpusk\StaffController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::put('/testis', function(){return "tes";});
Route::group(['middleware' => 'api', 'namespace' => 'App\Http\Controllers'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::post('/', [AuthController::class, 'login']);
    });
    Route::group(['prefix' => 'antrean'], function(){
        Route::post('/', [AntrianController::class, 'create_antrean']);
        Route::get('status/{kdpoli}/{tglperiksa}', [AntrianController::class, 'status_antrean']);
        Route::get('sisapeserta/{nokartu}/{kdpoli}/{tgl_periksa}', [AntrianController::class, 'sisa_antrean']);
        Route::post('batal', [AntrianController::class, 'batal_antrean']);
    });
    Route::group(['prefix' => 'peserta'], function(){
        Route::post('/', [AntrianController::class, 'create_pasien']);
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

});
