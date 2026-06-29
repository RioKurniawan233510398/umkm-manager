<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;

// Root route - redirect to login
Route::get('/', function () {
    return redirect('/login');
});

// Public routes (no authentication required)
Route::get('/login',
    [AuthController::class, 'showLogin']);

Route::post('/login',
    [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout',
    [AuthController::class, 'logout']);

// Protected routes (authentication required)
Route::get('/dashboard',
    [DashboardController::class, 'index']
)->middleware('login');

Route::resource(
    'products',
    ProductController::class
)->middleware('login');

Route::resource(
    'sales',
    SaleController::class
)->middleware('login');

Route::resource(
    'finance',
    FinanceController::class
)->middleware('login');

Route::get('/reports',
    [ReportController::class,'index']
)->middleware('login');

Route::get('/reports/pdf',
    [ReportController::class,'pdf']
)->middleware('login');

Route::resource(
    'business-profile',
    BusinessProfileController::class
)->middleware('login');

// Activity routes
Route::resource('activities', ActivityController::class)->middleware('login');
Route::post('/activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete')->middleware('login');

// Fallback route for production
Route::fallback(function () {
    return redirect('/login');
});
