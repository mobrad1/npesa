<?php

use Illuminate\Http\Request;
use Modules\Business\Http\Controllers\Auth\EmailVerificationController;
use Modules\Business\Http\Controllers\Auth\RegisterController;
use Modules\Business\Http\Controllers\Auth\LoginController;
use Modules\Business\Http\Controllers\CompanyRegistrationController;
use Modules\Business\Http\Controllers\ProfileController;

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

Route::middleware('auth:api')->get('/business', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1/business')->group(function(){
    Route::post('/create', [RegisterController::class, 'register'])->name('business.create');

    Route::post('/login', [LoginController::class, 'login'])->name('business.login');

    Route::put('/verify/email/{hash}/{id}', [EmailVerificationController::class, 'verify'])
    ->name('business.verification.verify')
    ->middleware('signed');


    // only authenticated businesses route
    Route::middleware('auth:business')->group(function(){

        
        Route::middleware('business.verified')->group(function(){
            Route::put('/owner/update', [ProfileController::class, 'ownerProfile'])->name('business.owner.profile-update');
        });

        Route::middleware('business.owner.profiled')->group(function(){
            Route::post('/company/details',  [CompanyRegistrationController::class, 'upload'])->name('business.company.reg-upload');
        });
    });


   
});