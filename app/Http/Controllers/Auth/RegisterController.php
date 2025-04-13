<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        Log::info('Truy cập showRegistrationForm, Auth: ' . (auth()->check() ? auth()->id() : 'guest'));
        return view('register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        try {
            // Tạo người dùng mới
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'user', // Mặc định là user
                'order' => User::max('order') + 1,
            ]);

            // Ghi lịch sử
            UserHistory::create([
                'admin_id' => null,
                'user_id' => $user->id,
                'action' => 'register',
                'note' => 'Người dùng tự đăng ký: ' . $user->name,
            ]);

            Log::info('Đăng ký thành công: User ID ' . $user->id . ', Email ' . $user->email);

            // Chuyển hướng về login
            return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi đăng ký: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.');
        }
    }
}