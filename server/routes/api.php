<?php

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

Route::group(['prefix' => 'ceps'], function ($router) {
    Route::get('find/{id}', [\App\Http\Controllers\CepController::class, 'showCep']);

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {
        Route::get('/', [\App\Http\Controllers\CepController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\CepController::class, 'store']);
        Route::put('{id}', [\App\Http\Controllers\CepController::class, 'update']);
        Route::delete('{id}', [\App\Http\Controllers\CepController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'enderecos'], function ($router) {
    Route::get('find/{id}', [\App\Http\Controllers\CepController::class, 'showEndereco']);
});

Route::group(['prefix' => 'users'], function ($router) {
    Route::post('login', [\App\Http\Controllers\UserController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);


    Route::middleware('auth:api')->get('get', [\App\Http\Controllers\UserController::class, 'get']);
    Route::middleware('auth:api')->post('logout', [\App\Http\Controllers\UserController::class, 'logout']);

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store']);
        Route::put('{id}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    });
});
