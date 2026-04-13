<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\PaymentController;  // ← ADD THIS
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // ==================== AUTH ROUTES ====================
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // ==================== STUDENT ROUTES ====================
    Route::apiResource('students', StudentController::class);
    Route::get('/students/export/excel', [StudentController::class, 'exportExcel']);
    Route::get('/students/export/pdf', [StudentController::class, 'exportPdf']);
    Route::get('/students/{student}/receipt', [StudentController::class, 'printReceipt']);

    // ==================== INSTRUCTOR ROUTES ====================
    Route::apiResource('instructors', InstructorController::class);
    Route::get('/instructors/export/excel', [InstructorController::class, 'exportExcel']);
    Route::get('/instructors/export/pdf', [InstructorController::class, 'exportPdf']);

    // ==================== VEHICLE ROUTES ====================
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('/vehicles/{id}/maintenance', [VehicleController::class, 'addMaintenance']);
    Route::post('/vehicles/{id}/documents', [VehicleController::class, 'addDocument']);
    Route::post('/vehicles/{id}/incidents', [VehicleController::class, 'addIncident']);
    Route::get('/vehicles/export/excel', [VehicleController::class, 'exportExcel']);
    Route::get('/vehicles/export/csv', [VehicleController::class, 'exportCsv']);
    Route::get('/vehicles/export/pdf', [VehicleController::class, 'exportPdf']);
    Route::get('/vehicles/{id}/export', [VehicleController::class, 'exportVehiclePdf']);

    // ==================== SESSION ROUTES ====================
    Route::apiResource('sessions', SessionController::class);
    Route::get('/sessions/calendar', [SessionController::class, 'getCalendarSessions']);
    Route::get('/sessions/upcoming', [SessionController::class, 'getUpcoming']);
    Route::get('/sessions/today', [SessionController::class, 'getTodaySessions']);
    Route::get('/sessions/date/{date}', [SessionController::class, 'getByDate']);
    Route::get('/sessions/export/excel', [SessionController::class, 'exportExcel']);
    Route::get('/sessions/export/pdf', [SessionController::class, 'exportPdf']);
    Route::get('/sessions/{session}/receipt', [SessionController::class, 'printReceipt']);

    // ==================== PAYMENT ROUTES ====================
    Route::apiResource('payments', PaymentController::class);
    Route::get('/payments/export/excel', [PaymentController::class, 'exportExcel']);
    Route::get('/payments/export/pdf', [PaymentController::class, 'exportPdf']);
    Route::get('/payments/{id}/receipt', [PaymentController::class, 'exportReceipt']);

});
