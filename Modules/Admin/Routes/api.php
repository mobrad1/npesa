<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\ActivityLogController;
use Modules\Admin\Http\Controllers\BusinessCategoryController;
use Modules\Admin\Http\Controllers\LoginAPIController;
use Modules\Admin\Http\Controllers\RegisterAPIController;
use Modules\Admin\Http\Controllers\CustomerController;
use Modules\Admin\Http\Controllers\BusinessController;
use Modules\Admin\Http\Controllers\TransactionCategoryController;
use Modules\Admin\Http\Controllers\TransactionController;

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
    Route::prefix('customers')->group(function(){
        Route::get('/', [CustomerController::class, 'index'])->name('admin.customer.index');
        Route::put('/{customer}',[CustomerController::class,'update'])->name('admin.customer.update');
        Route::delete('/{customer}',[CustomerController::class,'delete'])->name('admin.customer.delete');
        Route::put('/{customer}/ban',[CustomerController::class,'ban'])->name('admin.customer.ban');
        Route::get('/{customer}/transactions',[CustomerController::class,'transactions'])->name('admin.customer.transactions');
    });
    Route::prefix('businesses')->group(function(){

        Route::prefix('category')->group(function(){
            Route::post('/',[BusinessCategoryController::class,'store']);
            Route::get('/',[BusinessCategoryController::class,'index']);
            Route::put('/{id}',[BusinessCategoryController::class,'update']);
            Route::delete('/{id}',[BusinessCategoryController::class,'delete']);
        });
        Route::get('/',[BusinessController::class,'index'])->name('admin.businesses.index');
        Route::put('/{id}',[BusinessController::class,'update'])->name('admin.business.update');
        Route::post('/',[BusinessController::class,'store'])->name('admin.business.create');
        Route::delete('/{id}',[BusinessController::class,'delete'])->name('admin.business.delete');
        Route::get('/{business}/transactions',[BusinessController::class,'transactions'])->name('admin.business.transactions');
    });
    Route::prefix('transactions')->group(function(){
        Route::prefix('category')->group(function(){
            Route::post('/',[TransactionCategoryController::class,'store'])->name('admin.transaction_category.store');
            Route::put('/{id}',[TransactionCategoryController::class,'update'])->name('admin.transaction_category.update');
            Route::delete('/{id}',[TransactionCategoryController::class,'delete'])->name('admin.transaction_category.delete');
        });
        Route::get('/',[TransactionController::class,'index'])->name('admin.transactions');
        Route::get('/{id}',[TransactionController::class,'show'])->name('admin.transaction.show');
    });
    Route::prefix('activity')->group(function(){
        Route::get('/all',[ActivityLogController::class,'index']);
    });
});
