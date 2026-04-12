<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Profile routes
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/preferences', [ProfileController::class, 'updatePreferences']);

    //Students
    Route::apiResource('students', StudentController::class);
    // Export
    Route::get('/students/export/excel', [StudentController::class, 'exportExcel']);
    Route::get('/students/export/csv', [StudentController::class, 'exportCsv']);
    Route::get('/students/export/pdf', [StudentController::class, 'exportPdf']);
    Route::get('/students/{student}/receipt', [StudentController::class, 'printReceipt']);
});
