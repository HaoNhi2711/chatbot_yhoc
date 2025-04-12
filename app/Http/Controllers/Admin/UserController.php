<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::orderBy('order', 'asc')->get();
        return view('admin.manage_users', compact('users'));
    }

    // Hiển thị form thêm người dùng
    public function create()
    {
        return view('admin.create_user');
    }

    // Lưu thông tin người dùng mới
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin',
            'order' => 'nullable|integer',
        ]);

        $highestOrder = User::max('order');
        $newOrder = $highestOrder + 1;

        $newUser = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'order' => $newOrder,
        ]);

        // Ghi lịch sử thêm người dùng
        UserHistory::create([
            'admin_id' => Auth::id(),
            'user_id' => $newUser->id,
            'action' => 'add',
            'note' => 'Thêm người dùng mới: ' . $newUser->name,
        ]);

        return redirect()->route('admin.manage_users')->with('success', 'Thêm người dùng thành công.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
            'order' => 'nullable|integer',
        ]);

        $user = User::findOrFail($id);

        if ($request->has('order')) {
            $user->order = $validatedData['order'];
        }

        $user->update($validatedData);

        // Ghi lịch sử cập nhật người dùng
        UserHistory::create([
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'action' => 'edit',
            'note' => 'Cập nhật người dùng: ' . $user->name,
        ]);

        return redirect()->route('admin.manage_users')->with('success', 'Cập nhật người dùng thành công.');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Ghi lịch sử trước khi xóa
        UserHistory::create([
            'admin_id' => Auth::id(),
            'user_id' => $user->id,
            'action' => 'delete',
            'note' => 'Xóa người dùng: ' . $user->name,
        ]);

        $user->delete();

        return redirect()->route('admin.manage_users')->with('success', 'Xóa người dùng thành công.');
    }
}
