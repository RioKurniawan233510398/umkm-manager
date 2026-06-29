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

Route::get('/login',
    [AuthController::class, 'showLogin']);

Route::post('/login',
    [AuthController::class, 'authenticate']);

Route::post('/logout',
    [AuthController::class, 'logout']);

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

Route::get('/reports/excel',
    [ReportController::class,'excel']
)->middleware('login');

Route::resource(
    'business-profile',
    BusinessProfileController::class
)->middleware('login');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Activity routes
Route::resource('activities', ActivityController::class)->middleware('login');
Route::post('/activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete')->middleware('login');
