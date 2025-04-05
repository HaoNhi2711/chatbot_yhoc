<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        // Lấy tất cả người dùng và sắp xếp theo thứ tự 'order'
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
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin',
            'order' => 'nullable|integer', // Thêm validation cho 'order'
        ]);

        // Lấy thứ tự cao nhất hiện tại và gán cho người dùng mới
        $highestOrder = User::max('order');
        $newOrder = $highestOrder + 1; // Thứ tự của người dùng mới

        // Tạo người dùng mới với giá trị 'order'
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'order' => $newOrder,
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
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
            'order' => 'nullable|integer', // Cập nhật validation cho 'order'
        ]);

        $user = User::findOrFail($id);

        // Nếu có thay đổi về thứ tự (order), cập nhật lại
        if ($request->has('order')) {
            $user->order = $validatedData['order'];
        }

        // Cập nhật thông tin người dùng
        $user->update($validatedData);

        return redirect()->route('admin.manage_users')->with('success', 'Cập nhật người dùng thành công.');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.manage_users')->with('success', 'Xóa người dùng thành công.');
    }
}
