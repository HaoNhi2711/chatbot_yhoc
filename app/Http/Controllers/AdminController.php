<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MedicalData;
use App\Models\VipPackage;
use App\Models\Question;
use App\Models\UserHistory;
use App\Models\VipSubscription;  // Sửa lại tên lớp đúng với model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Trang dashboard chính
    public function dashboard()
    {
        $usersCount = User::count();
        $vipCount = User::where('role', 'vip')->count();
        $adminCount = User::where('role', 'admin')->count();
        $medicalDataCount = MedicalData::count();
        $vipPackages = VipPackage::has('users')->count();
        $latestUsers = User::latest()->take(5)->get();
        $latestMedicalData = MedicalData::latest()->take(5)->get();

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

    // Quản lý người dùng
    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:admin,vip,user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'role'));
        return redirect()->route('admin.manage_users');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('admin.manage_users')->withErrors('Không thể xóa tài khoản admin');
        }

        $user->delete();
        return redirect()->route('admin.manage_users');
    }

    // Quản lý dữ liệu y tế
    public function manageMedicalData()
    {
        $medicalData = MedicalData::all();
        return view('admin.manage_medical_data', compact('medicalData'));
    }

    public function createMedicalData()
    {
        return view('admin.create_medical_data');
    }

    public function storeMedicalData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        MedicalData::create($request->all());
        return redirect()->route('admin.manage_medical_data');
    }

    public function editMedicalData($id)
    {
        $medicalData = MedicalData::findOrFail($id);
        return view('admin.edit_medical_data', compact('medicalData'));
    }

    public function updateMedicalData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medicalData = MedicalData::findOrFail($id);
        $medicalData->update($request->only('title', 'content'));
        return redirect()->route('admin.manage_medical_data');
    }

    public function deleteMedicalData($id)
    {
        $medicalData = MedicalData::findOrFail($id);
        $medicalData->delete();
        return redirect()->route('admin.manage_medical_data');
    }

    // Quản lý gói VIP
    public function manageVipPackages()
    {
        $vipPackages = VipPackage::all();
        return view('admin.manage_vip_packages', compact('vipPackages'));
    }

    public function createVipPackage()
    {
        return view('admin.create_vip_package');
    }

    public function storeVipPackage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        VipPackage::create($request->all());
        return redirect()->route('admin.manage_vip_packages');
    }

    public function editVipPackage($id)
    {
        $vipPackage = VipPackage::findOrFail($id);
        return view('admin.edit_vip_package', compact('vipPackage'));
    }

    public function updateVipPackage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $vipPackage = VipPackage::findOrFail($id);
        $vipPackage->update($request->only('name', 'description', 'price', 'duration'));
        return redirect()->route('admin.manage_vip_packages');
    }

    public function deleteVipPackage($id)
    {
        $vipPackage = VipPackage::findOrFail($id);
        $vipPackage->delete();
        return redirect()->route('admin.manage_vip_packages');
    }

    // Quản lý lịch sử câu hỏi
    public function manageQuestionHistory()
    {
        $questions = Question::orderBy('created_at', 'desc')->get();
        return view('admin.manage_question_history', compact('questions'));
    }

    // Hiển thị lịch sử sử dụng của một user cụ thể
    public function showUserHistories($id)
    {
        $user = User::findOrFail($id);
        $histories = UserHistory::where('user_id', $id)->latest()->get();
        return view('admin.user_histories', compact('user', 'histories'));
    }

    // Quản lý gói VIP của người dùng
    public function manageUserVipPackages($id)
    {
        $user = User::findOrFail($id);
        $vipPackages = VipSubscription::where('user_id', $id)->with('vipPackage')->get();  // Sử dụng VipSubscription
        return view('admin.manage_user_vip_packages', compact('user', 'vipPackages'));
    }

    // Gán gói VIP cho người dùng
    public function assignVipPackage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'vip_package_id' => 'required|exists:vip_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        VipSubscription::create([  // Sử dụng VipSubscription
            'user_id' => $id,
            'vip_package_id' => $request->vip_package_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.manage_user_vip_packages', $id);
    }
}
