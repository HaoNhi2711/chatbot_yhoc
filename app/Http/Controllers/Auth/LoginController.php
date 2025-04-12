<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Thử đăng nhập
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Bảo mật session
            $user = Auth::user();

            // Điều hướng theo vai trò
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Mặc định mọi user thường (kể cả VIP) đều vào chat
            if ($user->role === 'user') {
                return redirect()->route('user.chat');
            }

            // Nếu role không xác định
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'message' => 'Tài khoản không hợp lệ. Vui lòng liên hệ quản trị viên.',
            ]);
        }

        // Đăng nhập thất bại
        return back()->withErrors([
            'message' => 'Sai email hoặc mật khẩu!',
        ]);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
