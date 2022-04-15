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
    Route::group(['middleware' => 'auth:customer'],function(){
         Route::post('update/pin',[\Modules\Customer\Http\Controllers\CustomerController::class,'updatePin']);
        Route::post('update',[\Modules\Customer\Http\Controllers\CustomerController::class,'update']);
        Route::get('balance',[\Modules\Customer\Http\Controllers\CustomerController::class,'balance']);
    });
    // Routes for sending money with customer
    Route::group(['prefix' => 'money','middleware'=>'auth:customer'],function(){
        Route::post('mobile/send',[\Modules\Customer\Http\Controllers\CustomerController::class,'sendMoneyToMobile']);
        Route::post('bank/send',[\Modules\Customer\Http\Controllers\CustomerController::class,'sendMoneyToBank']);
        Route::post('mobile-money/send',[\Modules\Customer\Http\Controllers\CustomerController::class,'sendMoneyToMobileMoney']);
    });
    Route::group(['prefix' => 'airtime','middleware'=>'auth:customer'],function(){
       Route::post('buy',[\Modules\Customer\Http\Controllers\CustomerController::class,'buyAirtime']);
    });
    Route::group(['prefix' => 'pay','middleware'=>'auth:customer'],function(){
       Route::post('bills',[\Modules\Customer\Http\Controllers\CustomerController::class,'payBill']);
    });
    Route::group(['prefix' => 'withdraw',],function(){
        Route::post('agent',[\Modules\Customer\Http\Controllers\CustomerController::class,'withdrawViaAgent']);
    });
    Route::group(['prefix' => 'location'],function(){
        Route::get('find-atm',[\Modules\Customer\Http\Controllers\LocationController::class,'findATM']);
        Route::get('find-bank',[\Modules\Customer\Http\Controllers\LocationController::class,'findATM']);
        Route::get('find-agent',[\Modules\Customer\Http\Controllers\LocationController::class,'findATM']);
        Route::get('find-business',[\Modules\Customer\Http\Controllers\LocationController::class,'findATM']);
    });
    // Routes for  Transactions with customer
    Route::group(['prefix' => 'transactions','middleware' => 'auth:customer'],function(){
        Route::get('all',[\Modules\Customer\Http\Controllers\TransactionController::class,'index']);
        Route::get('search',[\Modules\Customer\Http\Controllers\TransactionController::class,'search']);
    });
    Route::post('forgot-password', [\Modules\Customer\Http\Controllers\ForgotPasswordController::class, 'sendOTP'])->name('forget.pin.send');
    Route::post('reset-pin', [\Modules\Customer\Http\Controllers\ForgotPasswordController::class, 'updatePassword'])->name('reset.password.get');


});
