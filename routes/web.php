<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MedicalDataController;
use App\Http\Controllers\Admin\VipPackageController;
use App\Http\Controllers\Admin\VipSubscriptionController; // Đảm bảo rằng đây là đúng tên
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\UserVipController;
use App\Http\Controllers\Admin\UserHistoryController;
use App\Http\Controllers\User\UserHistoryController as UserUserHistoryController;

// Trang mặc định chuyển về login
Route::get('/', function () {
    return redirect()->route('login');
});

// ========== AUTH ========== 
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ========== ADMIN ========== 
Route::prefix('admin')->name('admin.')->group(function () {
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
        Route::get('/{vipPackage}/edit', [VipPackageController::class, 'edit'])->name('edit_vip_package');
        Route::put('/{vipPackage}', [VipPackageController::class, 'update'])->name('update_vip_package');
        Route::delete('/{vipPackage}', [VipPackageController::class, 'destroy'])->name('delete_vip_package');
    });
    // Lịch sử câu hỏi người dùng
    Route::get('/admin/user-histories', [AdminController::class, 'userHistories'])->name('admin.user_histories');
});

// ========== USER ========== 
Route::prefix('user')->name('user.')->group(function () {
    // Trang chat
    Route::get('/chat', [ChatbotController::class, 'index'])->name('chat');
    Route::post('/chat/send', [ChatbotController::class, 'sendMessage'])->name('chat.send');

    // Hiển thị các gói VIP
    Route::get('/vip', [UserVipController::class, 'showVipPackages'])->name('show_vip_packages');

    // Đăng ký gói VIP
    Route::post('/register_vip/{id}', [UserVipController::class, 'register'])->name('register_vip');

    // Lịch sử người dùng
    Route::get('/history', [UserUserHistoryController::class, 'history'])->name('history');
});
