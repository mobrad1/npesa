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

Route::group(['prefix' => 'customer'],function(){
    Route::post('register',[\Modules\Customer\Http\Controllers\RegisterAPIController::class,'store']);
    Route::post('login',[\Modules\Customer\Http\Controllers\LoginAPIController::class,'store']);
});
