<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    // Hiển thị form đăng ký
    public function create()
    {
        return view('register');  // Chỉ ra view đăng ký
    }

    // Xử lý đăng ký người dùng mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Đăng nhập người dùng ngay sau khi đăng ký
        auth()->login($user);

        return redirect()->route('dashboard');  // Chuyển hướng đến trang dashboard
    }
}




