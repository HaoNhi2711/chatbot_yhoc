<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipPackage;
use App\Models\UserVipSubscription;
use Illuminate\Http\Request;

class VipPackageController extends Controller
{
    // Hiển thị danh sách gói VIP kèm danh sách user đã đăng ký
    public function index()
    {
        $subscriptions = UserVipSubscription::with('user', 'vipPackage')->get();
        return view('admin.manage_vip_packages', compact('subscriptions'));
    }

    // Hiển thị form thêm mới gói VIP
    public function create()
    {
        return view('admin.create_vip_package');
    }

    // Lưu gói VIP mới
    public function store(Request $request)
    {
        // Validation dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        // Lưu gói VIP mới
        VipPackage::create($request->only(['name', 'description', 'price', 'duration']));

        // Chuyển hướng về danh sách gói VIP với thông báo thành công
        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa gói VIP và user đã đăng ký
    public function edit(VipPackage $vipPackage)
    {
        // Tải thông tin người dùng đã đăng ký cho gói VIP
        $vipPackage->load('subscriptions.user');
        
        // Trả về view chỉnh sửa gói VIP
        return view('admin.edit_vip_package', compact('vipPackage'));
    }

    // Cập nhật gói VIP
    public function update(Request $request, VipPackage $vipPackage)
    {
        // Validation dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        // Cập nhật gói VIP
        $vipPackage->update($request->only(['name', 'description', 'price', 'duration']));

        // Chuyển hướng về danh sách gói VIP với thông báo thành công
        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được cập nhật!');
    }

    // Xóa gói VIP và các đăng ký liên quan
    public function destroy(VipPackage $vipPackage)
    {
        // Xóa các đăng ký VIP liên quan đến gói này
        UserVipSubscription::where('vip_package_id', $vipPackage->id)->delete();

        // Xóa gói VIP
        $vipPackage->delete();

        // Chuyển hướng về danh sách gói VIP với thông báo thành công
        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP và các đăng ký liên quan đã được xóa!');
    }
}

