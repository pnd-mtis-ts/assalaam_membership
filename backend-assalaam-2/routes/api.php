<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'admin',
], function () { 
    Route::get('/card-members', [AdminMemberController::class, 'index']);
    Route::get('/card-members/{id}', [AdminMemberController::class, 'show']);
    Route::post('/card-members/{id}/activation', [AdminMemberController::class, 'updateActivation']);
    Route::post('/card-members/{id}/validation', [AdminMemberController::class, 'updateValidation']);

    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{transNo}', [TransaksiController::class, 'show']);

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
});

Route::group([
    'middleware' => [ 'auth:api'],
    'prefix' => 'auth',
], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'getDashboard']);
    Route::get('/transaction', [UserDashboardController::class, 'getAllTransactions']);
});

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'member',
], function () {
    Route::post('/validate', [MemberController::class, 'activate']);
    Route::post('/active', [MemberController::class, 'updateActivation']);
    Route::get('/{memberId}/transactions', [MemberController::class, 'getMemberTransactions']);
    
});

Route::group([
    'prefix' => 'member',
], function () {
   
    Route::post('/check', [MemberController::class, 'check']);
 
});