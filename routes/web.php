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

    // Variables Management
    Route::resource('variables', VariableController::class);

    // Repences Management
    Route::resource('repences', RepenceController::class);
});
