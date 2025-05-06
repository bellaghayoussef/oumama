<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AgencyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\ProcedureController;
use App\Http\Controllers\Admin\EtapController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\FormulerController;
use App\Http\Controllers\Admin\VariableController;
use App\Http\Controllers\Admin\RepenceController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DossierController;
use App\Http\Controllers\Agency\AuthController as AgencyAuthController;
use App\Http\Controllers\Agency\DashboardController as AgencyDashboardController;
use App\Http\Controllers\Agency\UserController as AgencyUserController;
use App\Http\Controllers\Agency\DossierController as AgencyDossierController;




use App\Http\Controllers\Api\DosesController;

// ... existing code ...






use App\Http\Controllers\API\AuthController;





Route::get('/', function () {
    return view('welcome');
});

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Agencies Management
    Route::resource('agencies', AgencyController::class);

    // Users Management
    Route::resource('users', UserController::class);

    // Procedures Management
    Route::resource('procedures', ProcedureController::class);

    // Etaps Management
    Route::resource('etaps', EtapController::class);

    // Tasks Management
    Route::resource('tasks', TaskController::class);

    // Formulers Management
    Route::resource('formulers', FormulerController::class);

    // Questions Management
    Route::resource('questions', QuestionController::class);

    // Variables Management
    Route::resource('variables', VariableController::class);

    // Repences Management
    Route::resource('repences', RepenceController::class);

    // Dossiers Management
    Route::resource('dossiers', DossierController::class);
});

// Agency Authentication Routes
Route::get('/agency/login', [AgencyAuthController::class, 'showLoginForm'])->name('agency.login');
Route::post('/agency/login', [AgencyAuthController::class, 'login']);
Route::post('/agency/logout', [AgencyAuthController::class, 'logout'])->name('agency.logout');

// Agency Protected Routes
Route::middleware(['auth:agency'])->prefix('agency')->name('agency.')->group(function () {
    Route::get('/', [AgencyDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AgencyUserController::class);
    Route::resource('dossiers', AgencyDossierController::class);
});
