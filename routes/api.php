<?php

use App\Interfaces\Http\Controllers\AuthController;
use App\Interfaces\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [AuthController::class,"logout"]);
    Route::get('/claims/get-list', [ClaimController::class, 'index']);
    Route::post('/claims/store', [ClaimController::class, 'store'])->middleware('role:user');
    Route::put('/claims/{id}/verify', [ClaimController::class, 'verify'])->middleware('role:verifier');
    Route::put('/claims/{id}/approve', [ClaimController::class, 'approve'])->middleware('role:approver');
    Route::put('/claims/{id}/reject', [ClaimController::class, 'reject'])->middleware('role:approver');
});
