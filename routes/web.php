<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MedicalDataController;
use App\Http\Controllers\Admin\VipSubscriptionController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\UserVipController;
use App\Http\Controllers\User\UserHistoryController as UserHistoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Trang mặc định chuyển về login
Route::get('/', function () {
    Log::info('Truy cập route gốc, Auth: ' . (Auth::check() ? Auth::id() . ', Role: ' . (Auth::user()->role ?? 'null') : 'guest'));
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'user') {
            return redirect()->route('user.chat');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// Trang home cho người dùng không có quyền
Route::get('/home', function () {
    Log::info('Truy cập home, User ID: ' . (Auth::id() ?? 'null') . ', Role: ' . (Auth::user()->role ?? 'null'));
    $message = Auth::check() ? 'Vui lòng liên hệ quản trị viên để được cấp quyền.' : 'Chào mừng bạn đến với hệ thống!';
    return view('home', ['message' => $message]);
})->name('home');

// ========== AUTH ROUTES ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::group([
        'middleware' => function ($request, $next) {
            Log::info('Kiểm tra quyền admin, User ID: ' . (Auth::id() ?? 'null') . ', Role: ' . (Auth::user()->role ?? 'null'));
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang admin.');
        }
    ], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Quản lý người dùng
        Route::prefix('manage_users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('manage_users');
            Route::get('/create', [UserController::class, 'create'])->name('create_user');
            Route::post('/', [UserController::class, 'store'])->name('store_user');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit_user');
            Route::put('/{id}', [UserController::class, 'update'])->name('update_user');
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
            Route::get('/', [VipSubscriptionController::class, 'indexPackages'])->name('manage_vip_packages');
            Route::get('/create', [VipSubscriptionController::class, 'createPackage'])->name('create_vip_package');
            Route::post('/', [VipSubscriptionController::class, 'storePackage'])->name('store_vip_package');
            Route::get('/{id}/edit', [VipSubscriptionController::class, 'editPackage'])->name('edit_vip_package');
            Route::put('/{id}', [VipSubscriptionController::class, 'updatePackage'])->name('update_vip_package');
            Route::delete('/{id}', [VipSubscriptionController::class, 'destroyPackage'])->name('delete_vip_package');
        });

        // Quản lý đăng ký VIP
        Route::prefix('vip_subscriptions')->group(function () {
            Route::get('/', [VipSubscriptionController::class, 'index'])->name('vip_subscriptions.index');
            Route::get('/create', [VipSubscriptionController::class, 'create'])->name('vip_subscriptions.create');
            Route::post('/', [VipSubscriptionController::class, 'store'])->name('vip_subscriptions.store');
            Route::get('/{id}/edit', [VipSubscriptionController::class, 'edit'])->name('vip_subscriptions.edit');
            Route::put('/{id}', [VipSubscriptionController::class, 'update'])->name('vip_subscriptions.update');
            Route::delete('/{id}', [VipSubscriptionController::class, 'destroy'])->name('vip_subscriptions.destroy');
        });

        // Lịch sử hỏi đáp
        Route::get('/user_history/{id}', [UserHistoryController::class, 'index'])->name('user_history');
    });
});

// ========== USER ROUTES ==========
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::group([
        'middleware' => function ($request, $next) {
            Log::info('Kiểm tra quyền user, User ID: ' . (Auth::id() ?? 'null') . ', Role: ' . (Auth::user()->role ?? 'null'));
            if (Auth::check() && Auth::user()->role === 'user') {
                return $next($request);
            }
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang người dùng.');
        }
    ], function () {
        Route::get('/chat', [ChatbotController::class, 'index'])->name('chat');
        Route::post('/chat/send', [ChatbotController::class, 'sendMessage'])->name('chat.send');
        Route::get('/vip', [UserVipController::class, 'showVipPackages'])->name('show_vip_packages');
        Route::post('/register_vip/{id}', [VipSubscriptionController::class, 'register'])->name('register_vip');
        Route::get('/history', [UserHistoryController::class, 'index'])->name('history');
    });
});