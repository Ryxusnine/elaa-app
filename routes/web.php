<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class,'HalamanDashboard'])->name('dashboard.index');
Route::post('/analisis', [DashboardController::class,'analisis'])->name('dashboard.analisis');

Route::get('/ulasan', [DashboardController::class,'HalamanUlasan'])->name('ulasan.index');
Route::get('/about', [DashboardController::class,'HalamanAbout'])->name('about.index');
