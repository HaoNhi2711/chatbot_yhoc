<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MedicalDataController;

// Trang chủ - nếu chưa đăng nhập thì vào login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Route đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route đăng ký
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Các route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {

    // Dashboard chuyển hướng theo vai trò
    Route::get('/dashboard', function () {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('home');
    })->name('dashboard');

    // Trang dành cho Admin (chưa phân quyền ở đây)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Quản lý người dùng
    Route::get('/admin/manage_users', [UserController::class, 'index'])->name('admin.manage_users');
    Route::get('/admin/manage_users/create', [UserController::class, 'create'])->name('admin.create_user');
    Route::post('/admin/manage_users', [UserController::class, 'store'])->name('admin.store_user');
    Route::get('/admin/manage_users/{id}/edit', [UserController::class, 'edit'])->name('admin.edit_user');
    Route::post('/admin/manage_users/{id}/edit', [UserController::class, 'update']);
    Route::delete('/admin/manage_users/{id}', [UserController::class, 'destroy'])->name('admin.delete_user');

    // Route cho quản lý dữ liệu y khoa
    Route::get('/admin/manage_medical_data', [MedicalDataController::class, 'index'])->name('admin.manage_medical_data');
    Route::get('/admin/create_medical_data', [MedicalDataController::class, 'create'])->name('admin.create_medical_data');
    Route::post('/admin/manage_medical_data', [MedicalDataController::class, 'store'])->name('admin.store_medical_data');
    Route::get('/admin/manage_medical_data/{id}/edit', [MedicalDataController::class, 'edit'])->name('admin.edit_medical_data');
    Route::put('/admin/manage_medical_data/{id}', [MedicalDataController::class, 'update'])->name('admin.update_medical_data');
    Route::delete('/admin/manage_medical_data/{id}', [MedicalDataController::class, 'destroy'])->name('admin.destroy_medical_data');

    // Quản lý dữ liệu y tế, gói VIP, thống kê
    Route::get('/admin/manage_vip_packages', [AdminController::class, 'manageVipPackages'])->name('admin.manage_vip_packages');
    Route::get('/admin/statistics_reports', [AdminController::class, 'statisticsReports'])->name('admin.statistics_reports');

    // Trang dành cho người dùng thường
    Route::get('/home', function () {
        return view('home'); // Tạo view `home.blade.php`
    })->name('home');
});
