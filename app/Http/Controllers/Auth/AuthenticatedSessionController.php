<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // Hiển thị form đăng nhập
    public function create()
    {
        return view('login');  // Chỉ ra view đăng nhập
    }

    // Xử lý đăng nhập
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');  // Chuyển hướng đến trang dashboard
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    // Đăng xuất
    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect('/');  // Chuyển hướng về trang chủ
    }
}



