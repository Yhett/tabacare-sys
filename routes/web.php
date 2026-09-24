<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::view('/help', 'help')->name('help');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('patients', PatientController::class)->only(['index', 'store', 'update', 'destroy']);
Route::post('/patients/export', [PatientController::class, 'export'])->name('patients.export');
Route::get('/reports/create', [ReportController::class, 'index'])->name('reports.create');
Route::get('/reports/generate', [ReportController::class, 'index']);
Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
Route::post('/reports/download', [ReportController::class, 'download'])->name('reports.download');
Route::post('/reports/submit', [ReportController::class, 'submit'])->name('reports.submit');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
Route::post('/admin/patients', [AdminController::class, 'storePatient'])->name('admin.patients.store');
Route::get('/admin/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
Route::post('/admin/accounts', [AdminController::class, 'storeAccount'])->name('admin.accounts.store');
Route::patch('/admin/accounts/{user}', [AdminController::class, 'updateAccount'])->name('admin.accounts.update');
Route::delete('/admin/accounts/{user}', [AdminController::class, 'destroyAccount'])->name('admin.accounts.destroy');
Route::get('/admin/admin-accounts', [AdminController::class, 'adminAccounts'])->name('admin.admin-accounts.index');
Route::post('/admin/admin-accounts', [AdminController::class, 'storeAdminAccount'])->name('admin.admin-accounts.store');
Route::patch('/admin/admin-accounts/{user}', [AdminController::class, 'updateAdminAccount'])->name('admin.admin-accounts.update');
Route::get('/admin/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
Route::get('/admin/reports/{report}/attachment', [AdminController::class, 'downloadAttachment'])->name('admin.reports.attachment');
Route::get('/admin/reports/{report}/download', [AdminController::class, 'downloadReport'])->name('admin.reports.download');
