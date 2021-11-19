<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/sanctum/token", [LoginController::class, "login"]);
Route::post("register", [RegisteredUserController::class, "store"])->middleware("guest");
Route::post('/forgot-password',[ForgotPasswordController::class,"sendResetPasswordEmail"])->middleware("guest");
Route::post('/verify-token',[ResetPasswordController::class,"verifyOtp"])->middleware("guest");
Route::post('/password/reset',[ResetPasswordController::class,"reset"])->middleware("guest");
