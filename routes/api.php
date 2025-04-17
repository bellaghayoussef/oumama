<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AgencyAuthController;
use App\Http\Controllers\Admin\DashboardController;

// Admin Authentication Routes
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
    Route::get('/admin/profile', [AdminAuthController::class, 'profile']);
});

// Agency Authentication Routes
Route::post('/agency/login', [AgencyAuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/agency/logout', [AgencyAuthController::class, 'logout']);
    Route::get('/agency/profile', [AgencyAuthController::class, 'profile']);
    Route::get('/agency/clients', [AgencyAuthController::class, 'clients']);
});

// Admin Dashboard Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/agencies', [DashboardController::class, 'listAgencies']);
    Route::post('/admin/agencies', [DashboardController::class, 'createAgency']);
    Route::put('/admin/agencies/{agency}', [DashboardController::class, 'updateAgency']);
    Route::delete('/admin/agencies/{agency}', [DashboardController::class, 'deleteAgency']);
    Route::get('/admin/agencies/{agency}/clients', [DashboardController::class, 'getAgencyClients']);
});
