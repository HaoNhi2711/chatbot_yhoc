<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipPackage;
use Illuminate\Http\Request;

class VipPackageController extends Controller
{
    // Hiển thị danh sách gói VIP
    public function index()
    {
        $vipPackages = VipPackage::all();
        return view('admin.manage_vip_packages', compact('vipPackages'));
    }

    // Hiển thị form thêm mới gói VIP
    public function create()
    {
        return view('admin.create_vip_package');
    }

    // Lưu gói VIP mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        // Lấy dữ liệu từ request và tạo mới gói VIP
        $data = $request->only(['name', 'description', 'price', 'duration']);

        // Tạo gói VIP mới
        VipPackage::create($data);

        // Redirect về trang quản lý gói VIP với thông báo thành công
        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa gói VIP
    public function edit(VipPackage $vipPackage)
    {
        return view('admin.edit_vip_package', compact('vipPackage'));
    }

    // Cập nhật gói VIP
    public function update(Request $request, VipPackage $vipPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        // Lấy dữ liệu từ request và cập nhật gói VIP
        $data = $request->only(['name', 'description', 'price', 'duration']);

        // Cập nhật gói VIP
        $vipPackage->update($data);

        // Redirect về trang quản lý gói VIP với thông báo thành công
        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được cập nhật!');
    }

    // Xóa gói VIP
    public function destroy(VipPackage $vipPackage)
    {
        // Xóa gói VIP
        $vipPackage->delete();

        // Redirect về trang quản lý gói VIP với thông báo thành công
        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được xóa!');
    }
}

