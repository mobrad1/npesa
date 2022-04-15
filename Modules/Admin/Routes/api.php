<?php

use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\LoginAPIController;
use Modules\Admin\Http\Controllers\RegisterAPIController;

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

Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function(){
    Route::post('/login', [LoginAPIController::class, 'store'])->name('admin.login');
    Route::post('/create', [RegisterAPIController::class, 'store'])->name('business.create');
});
