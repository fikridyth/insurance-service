<?php

use App\Interfaces\Http\Controllers\AuthController;
use App\Interfaces\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [AuthController::class,"logout"]);
    Route::post('/claims', [ClaimController::class, 'store'])->middleware('role:user');
    Route::post('/claims/{id}/verify', [ClaimController::class, 'verify'])->middleware('role:verifier');
    Route::post('/claims/{id}/approve', [ClaimController::class, 'approve'])->middleware('role:approver');
    Route::post('/claims/{id}/reject', [ClaimController::class, 'reject'])->middleware('role:approver');
});
