<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        Log::info('Truy cập showLoginForm, Auth: ' . (Auth::check() ? Auth::id() : 'guest'));
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Thử đăng nhập với email: ' . $request->email);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('Đăng nhập thành công: User ID ' . $user->id . ', Role ' . ($user->role ?? 'null'));

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Chào mừng quản trị viên!');
            } elseif ($user->role === 'user') {
                return redirect()->route('user.chat')->with('success', 'Chào mừng bạn đến với chatbot!');
            }

            // Role không hợp lệ
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::warning('Role không hợp lệ: User ID ' . $user->id . ', Role ' . ($user->role ?? 'null'));
            return redirect()->route('home')->with('error', 'Vai trò tài khoản không được hỗ trợ. Vui lòng liên hệ quản trị viên.');
        }

        Log::error('Đăng nhập thất bại: Email ' . $request->email);
        return back()->with('error', 'Email hoặc mật khẩu không đúng!')->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Log::info('Đăng xuất: User ID ' . (Auth::id() ?? 'null'));
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}