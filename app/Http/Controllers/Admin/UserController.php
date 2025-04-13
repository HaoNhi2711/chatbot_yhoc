<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        Log::info('Truy cập manage_users, User ID: ' . (Auth::id() ?? 'null'));
        $users = User::orderBy('order', 'asc')->get();
        return view('admin.manage_users', compact('users'));
    }

    public function create()
    {
        Log::info('Truy cập create_user, User ID: ' . (Auth::id() ?? 'null'));
        return view('admin.create_user');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin',
            'order' => 'nullable|integer',
        ]);

        try {
            $highestOrder = User::max('order');
            $newOrder = $highestOrder ? $highestOrder + 1 : 1;

            $newUser = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'order' => $validatedData['order'] ?? $newOrder,
            ]);

            if (Auth::check()) {
                UserHistory::create([
                    'admin_id' => Auth::id(),
                    'user_id' => $newUser->id,
                    'action' => 'add',
                    'note' => 'Thêm người dùng mới: ' . $newUser->name,
                ]);
            }

            return redirect()->route('admin.manage_users')->with('success', 'Thêm người dùng thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm người dùng: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ' | Line: ' . $e->getLine());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm người dùng: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
            'order' => 'nullable|integer',
        ]);

        try {
            $user = User::findOrFail($id);

            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'],
                'order' => $validatedData['order'] ?? $user->order,
            ]);

            if (Auth::check()) {
                UserHistory::create([
                    'admin_id' => Auth::id(),
                    'user_id' => $user->id,
                    'action' => 'edit',
                    'note' => 'Cập nhật người dùng: ' . $user->name,
                ]);
            }

            return redirect()->route('admin.manage_users')->with('success', 'Cập nhật người dùng thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật người dùng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật người dùng.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if (Auth::check()) {
                UserHistory::create([
                    'admin_id' => Auth::id(),
                    'user_id' => $user->id,
                    'action' => 'delete',
                    'note' => 'Xóa người dùng: ' . $user->name,
                ]);
            }

            $user->delete();

            return redirect()->route('admin.manage_users')->with('success', 'Xóa người dùng thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa người dùng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa người dùng.');
        }
    }
}