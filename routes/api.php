<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AgencyAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\DosesController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});

Route::prefix('api')->group(function () {
    Route::get('/doses', [DosesController::class, 'index']);
    Route::post('/doses', [DosesController::class, 'store']);
});
