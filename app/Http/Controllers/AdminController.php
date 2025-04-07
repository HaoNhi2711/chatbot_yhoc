<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MedicalData; // Nếu có mô hình MedicalData
use App\Models\VipPackage; // Nếu có mô hình VipPackage
use App\Models\Question; // Nếu có mô hình Question
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Lấy tổng số người dùng
        $usersCount = User::count();

        // Lấy số người dùng VIP
        $vipCount = User::where('role', 'vip')->count();

        // Lấy số quản trị viên
        $adminCount = User::where('role', 'admin')->count();

        // Lấy số lượng dữ liệu y khoa (Giả sử bạn có một mô hình MedicalData)
        $medicalDataCount = MedicalData::count();

        // Lấy số gói VIP (Giả sử bạn có một bảng vip_packages)
        $vipPackages = VipPackage::count();

        // Lấy 5 người dùng mới nhất
        $latestUsers = User::latest()->take(5)->get();

        // Lấy 5 dữ liệu y khoa mới nhất
        $latestMedicalData = MedicalData::latest()->take(5)->get();

        // Truyền các biến vào view
        return view('admin.dashboard', compact(
            'usersCount', 
            'vipCount', 
            'adminCount', 
            'medicalDataCount', 
            'vipPackages', 
            'latestUsers', 
            'latestMedicalData'
        ));
    }

    public function manageUsers()
    {
        // Lấy tất cả người dùng
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }

    public function editUser($id)
    {
        // Lấy thông tin người dùng theo ID
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        // Cập nhật thông tin người dùng
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.manage_users');
    }

    public function deleteUser($id)
    {
        // Xóa người dùng
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.manage_users');
    }

    public function manageMedicalData()
    {
        // Quản lý dữ liệu y khoa
        $medicalData = MedicalData::all();
        return view('admin.manage_medical_data', compact('medicalData'));
    }

    public function createMedicalData()
    {
        // Tạo mới dữ liệu y khoa
        return view('admin.create_medical_data');
    }

    public function storeMedicalData(Request $request)
    {
        // Lưu dữ liệu y khoa mới
        MedicalData::create($request->all());
        return redirect()->route('admin.manage_medical_data');
    }

    public function editMedicalData($id)
    {
        // Chỉnh sửa dữ liệu y khoa
        $medicalData = MedicalData::findOrFail($id);
        return view('admin.edit_medical_data', compact('medicalData'));
    }

    public function updateMedicalData(Request $request, $id)
    {
        // Cập nhật dữ liệu y khoa
        $medicalData = MedicalData::findOrFail($id);
        $medicalData->update($request->all());
        return redirect()->route('admin.manage_medical_data');
    }

    public function deleteMedicalData($id)
    {
        // Xóa dữ liệu y khoa
        $medicalData = MedicalData::findOrFail($id);
        $medicalData->delete();
        return redirect()->route('admin.manage_medical_data');
    }

    public function manageVipPackages()
    {
        // Quản lý gói VIP
        $vipPackages = VipPackage::all();
        return view('admin.manage_vip_packages', compact('vipPackages'));
    }

    public function createVipPackage()
    {
        // Tạo mới gói VIP
        return view('admin.create_vip_package');
    }

    public function storeVipPackage(Request $request)
    {
        // Lưu gói VIP mới
        VipPackage::create($request->all());
        return redirect()->route('admin.manage_vip_packages');
    }

    public function editVipPackage($id)
    {
        // Chỉnh sửa gói VIP
        $vipPackage = VipPackage::findOrFail($id);
        return view('admin.edit_vip_package', compact('vipPackage'));
    }

    public function updateVipPackage(Request $request, $id)
    {
        // Cập nhật gói VIP
        $vipPackage = VipPackage::findOrFail($id);
        $vipPackage->update($request->all());
        return redirect()->route('admin.manage_vip_packages');
    }

    public function deleteVipPackage($id)
    {
        // Xóa gói VIP
        $vipPackage = VipPackage::findOrFail($id);
        $vipPackage->delete();
        return redirect()->route('admin.manage_vip_packages');
    }

    public function manageQuestionHistory()
    {
        // Giả sử bạn có một model gọi là Question để lấy dữ liệu lịch sử câu hỏi
        $questions = Question::orderBy('created_at', 'desc')->get();
        return view('admin.manage_question_history', compact('questions'));
    }
}
