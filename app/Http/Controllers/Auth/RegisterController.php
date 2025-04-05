<?php

// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Xử lý đăng ký người dùng
    public function register(Request $request)
    {
        // Validating input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Đăng nhập ngay sau khi đăng ký
        auth()->login($user);

        return redirect()->route('admin.dashboard');
    }
}

