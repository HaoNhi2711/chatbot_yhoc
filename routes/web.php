<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MedicalDataController;
use App\Http\Controllers\Admin\VipPackageController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

/*
|---------------------------------------------------------------------------
| Đăng nhập / Đăng ký 
|---------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/*
|---------------------------------------------------------------------------
| Các route cần đăng nhập 
|---------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Điều hướng dashboard theo vai trò
    Route::get('/dashboard', function () {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('home');
    })->name('dashboard');

    /*
    |---------------------------------------------------------------------------
    | Route Admin 
    |---------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Quản lý người dùng
        Route::prefix('manage_users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('manage_users');
            Route::get('/create', [UserController::class, 'create'])->name('create_user');
            Route::post('/', [UserController::class, 'store'])->name('store_user');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit_user');
            Route::put('/{id}/edit', [UserController::class, 'update'])->name('update_user');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete_user');
        });

        // Quản lý dữ liệu y khoa
        Route::prefix('manage_medical_data')->group(function () {
            Route::get('/', [MedicalDataController::class, 'index'])->name('manage_medical_data');
            Route::get('/create', [MedicalDataController::class, 'create'])->name('create_medical_data');
            Route::post('/', [MedicalDataController::class, 'store'])->name('store_medical_data');
            Route::get('/{id}/edit', [MedicalDataController::class, 'edit'])->name('edit_medical_data');
            Route::put('/{id}', [MedicalDataController::class, 'update'])->name('update_medical_data');
            Route::delete('/{id}', [MedicalDataController::class, 'destroy'])->name('destroy_medical_data');
        });

        // Quản lý gói VIP
        Route::prefix('vip_packages')->group(function () {
            Route::get('/', [VipPackageController::class, 'index'])->name('manage_vip_packages');
            Route::get('/create', [VipPackageController::class, 'create'])->name('create_vip_package');
            Route::post('/', [VipPackageController::class, 'store'])->name('store_vip_package');
            Route::delete('/{vipPackage}', [VipPackageController::class, 'destroy'])->name('delete_vip_package');
            Route::get('/{vipPackage}/edit', [VipPackageController::class, 'edit'])->name('edit_vip_package');
            Route::put('/{vipPackage}', [VipPackageController::class, 'update'])->name('update_vip_package');
        });

        // Quản lý báo cáo thống kê
        Route::get('/statistics_reports', [AdminController::class, 'statisticsReports'])->name('statistics_reports');
    });

    /*
    |---------------------------------------------------------------------------
    | Trang người dùng thường 
    |---------------------------------------------------------------------------
    */
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
