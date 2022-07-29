<?php

use Illuminate\Http\Request;
use Modules\Business\Http\Controllers\AccountVerificationController;
use Modules\Business\Http\Controllers\ProfileController;
use Modules\Business\Http\Controllers\Auth\LoginController;
use Modules\Business\Http\Controllers\BankAccountController;
use Modules\Business\Http\Controllers\Auth\RegisterController;
use Modules\Business\Http\Controllers\CompanyRegistrationController;
use Modules\Business\Http\Controllers\Auth\EmailVerificationController;

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

Route::prefix('business')->group(function () {
    Route::post('/create', [RegisterController::class, 'register'])->name('business.create');
    Route::post('/login', [LoginController::class, 'login'])->name('business.login');

    Route::put('/verify/email/{hash}/{id}', [EmailVerificationController::class, 'verify'])
        ->name('business.verification.verify')
        ->middleware('signed');
    Route::post('/verify',[AccountVerificationController::class,'verify']);
    Route::post('forgot-password', [\Modules\Business\Http\Controllers\ForgotPasswordController::class, 'sendOTP'])->name('forget.pin.send');
    Route::post('resend-otp', [\Modules\Business\Http\Controllers\ForgotPasswordController::class, 'sendOTP'])->name('otp.resend');
    Route::post('reset-pin', [\Modules\Business\Http\Controllers\ForgotPasswordController::class, 'updatePassword'])->name('reset.password.get');
    // only authenticated businesses route
    Route::middleware('auth:business')->group(function () {

        Route::group(['prefix' => 'transactions'], function () {
            Route::get('all', [\Modules\Business\Http\Controllers\TransactionController::class, 'index']);
            Route::get('search', [\Modules\Business\Http\Controllers\TransactionController::class, 'search']);
        });
        // Routes for sending money with customer
        Route::group(['prefix' => 'money'], function () {
            Route::post('mobile/send', [\Modules\Business\Http\Controllers\BusinessController::class, 'sendMoneyToMobile']);
            Route::post('business/send', [\Modules\Business\Http\Controllers\BusinessController::class, 'sendMoneyToBusiness']);
            Route::post('bank/send', [\Modules\Business\Http\Controllers\BusinessController::class, 'sendMoneyToBank']);
            Route::post('mobile-money/send', [\Modules\Business\Http\Controllers\BusinessController::class, 'sendMoneyToMobileMoney']);
        });
        Route::group(['prefix' => 'airtime'], function () {
            Route::post('buy', [\Modules\Business\Http\Controllers\BusinessController::class, 'buyAirtime']);

        });
        Route::group(['prefix' => 'withdraw'], function () {
            Route::post('agent', [\Modules\Business\Http\Controllers\BusinessController::class, 'withdrawViaAgent']);
            Route::post('atm', [\Modules\Business\Http\Controllers\BusinessController::class, 'withdrawViaAgent']);
        });
        Route::group(['prefix' => 'location'],function(){
        Route::get('find-atm',[\Modules\Business\Http\Controllers\LocationController::class,'findATM']);
        Route::get('find-bank',[\Modules\Business\Http\Controllers\LocationController::class,'findATM']);
        Route::get('find-agent',[\Modules\Business\Http\Controllers\LocationController::class,'findATM']);
        Route::get('find-business',[\Modules\Business\Http\Controllers\LocationController::class,'findATM']);
    });
        Route::group(['prefix' => 'pay'], function () {
            Route::post('bills', [\Modules\Business\Http\Controllers\BusinessController::class, 'payBill']);
        });
         Route::post('update/pin',[\Modules\Business\Http\Controllers\BusinessController::class,'updatePin']);
        Route::put('/update', [\Modules\Business\Http\Controllers\BusinessController::class, 'update'])->name('business.owner.profile-update');
        Route::get('/balance', [\Modules\Business\Http\Controllers\BusinessController::class, 'balance'])->name('business.balance');
        Route::middleware('business.owner.profiled')->group(function () {
            Route::post('/company/details/update', [CompanyRegistrationController::class, 'upload'])->name('business.company.reg-upload');
            Route::post('/company/bank/account/update', [BankAccountController::class, 'update'])->name('business.bank.account-update');
        });
    });


});
