<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MedicalData;
use App\Models\VipPackage;
use App\Models\UserHistory;
use App\Models\VipSubscription;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Trang dashboard chính
    public function dashboard()
    {
        try {
            // Thống kê
            $totalUsers = User::count();
            $vipUsers = User::whereHas('subscriptions', function ($query) {
                $query->where('end_date', '>=', now());
            })->count();
            $adminCount = Schema::hasColumn('users', 'role')
                ? User::where('role', 'admin')->count()
                : 0;
            $medicalDataCount = MedicalData::count();
            $totalVipPackages = VipPackage::count();

            // Người dùng mới nhất
            $recentUsers = User::with('subscriptions.vipPackage')
                ->latest()
                ->take(5)
                ->get();

            // Dữ liệu y khoa mới nhất
            $recentMedicalData = MedicalData::latest()
                ->take(5)
                ->get();

            // Ghi log để debug
            Log::info('AdminController@dashboard variables', [
                'totalUsers' => $totalUsers,
                'vipUsers' => $vipUsers,
                'adminCount' => $adminCount,
                'medicalDataCount' => $medicalDataCount,
                'totalVipPackages' => $totalVipPackages,
                'recentUsers_count' => $recentUsers->count(),
                'recentMedicalData_count' => $recentMedicalData->count(),
            ]);

            return view('admin.dashboard', compact(
                'totalUsers',
                'vipUsers',
                'adminCount',
                'medicalDataCount',
                'totalVipPackages',
                'recentUsers',
                'recentMedicalData'
            ));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@dashboard: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải dashboard: ' . $e->getMessage());
        }
    }

    // Hiển thị lịch sử hỏi đáp của tất cả người dùng
    public function userHistories()
    {
        try {
            $histories = UserHistory::with('user')->latest()->get();
            return view('admin.user_histories', compact('histories'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@userHistories: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải lịch sử hỏi đáp: ' . $e->getMessage());
        }
    }

    // Hiển thị lịch sử sử dụng của một user cụ thể
    public function showUserHistories($id)
    {
        try {
            $user = User::findOrFail($id);
            $histories = UserHistory::where('user_id', $id)->latest()->get();
            return view('admin.user_histories', compact('user', 'histories'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@showUserHistories: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải lịch sử người dùng: ' . $e->getMessage());
        }
    }

    // Quản lý người dùng
    public function manageUsers()
    {
        try {
            $users = User::all();
            return view('admin.manage_users', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@manageUsers: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải danh sách người dùng: ' . $e->getMessage());
        }
    }

    public function editUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.edit_user', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@editUser: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải form chỉnh sửa: ' . $e->getMessage());
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
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
            return redirect()->route('admin.manage_users')->with('success', 'Cập nhật người dùng thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@updateUser: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi cập nhật người dùng: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'admin') {
                return redirect()->route('admin.manage_users')->withErrors('Không thể xóa tài khoản admin');
            }

            $user->delete();
            return redirect()->route('admin.manage_users')->with('success', 'Xóa người dùng thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@deleteUser: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi xóa người dùng: ' . $e->getMessage());
        }
    }

    // Quản lý dữ liệu y tế
    public function manageMedicalData()
    {
        try {
            $medicalData = MedicalData::all();
            return view('admin.manage_medical_data', compact('medicalData'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@manageMedicalData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải dữ liệu y tế: ' . $e->getMessage());
        }
    }

    public function createMedicalData()
    {
        try {
            return view('admin.create_medical_data');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@createMedicalData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải form tạo dữ liệu y tế: ' . $e->getMessage());
        }
    }

    public function storeMedicalData(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            MedicalData::create($request->all());
            return redirect()->route('admin.manage_medical_data')->with('success', 'Thêm dữ liệu y tế thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@storeMedicalData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi lưu dữ liệu y tế: ' . $e->getMessage());
        }
    }

    public function editMedicalData($id)
    {
        try {
            $medicalData = MedicalData::findOrFail($id);
            return view('admin.edit_medical_data', compact('medicalData'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@editMedicalData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải form chỉnh sửa dữ liệu y tế: ' . $e->getMessage());
        }
    }

    public function updateMedicalData(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $medicalData = MedicalData::findOrFail($id);
            $medicalData->update($request->only('title', 'content'));
            return redirect()->route('admin.manage_medical_data')->with('success', 'Cập nhật dữ liệu y tế thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@updateMedicalData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi cập nhật dữ liệu y tế: ' . $e->getMessage());
        }
    }

    public function deleteMedicalData($id)
    {
        try {
            $medicalData = MedicalData::findOrFail($id);
            $medicalData->delete();
            return redirect()->route('admin.manage_medical_data')->with('success', 'Xóa dữ liệu y tế thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@deleteMedicalData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi xóa dữ liệu y tế: ' . $e->getMessage());
        }
    }

    // Quản lý gói VIP
    public function manageVipPackages()
    {
        try {
            $vipPackages = VipPackage::all();
            return view('admin.manage_vip_packages', compact('vipPackages'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@manageVipPackages: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải danh sách gói VIP: ' . $e->getMessage());
        }
    }

    public function createVipPackage()
    {
        try {
            return view('admin.create_vip_package');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@createVipPackage: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải form tạo gói VIP: ' . $e->getMessage());
        }
    }

    public function storeVipPackage(Request $request)
    {
        try {
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
            return redirect()->route('admin.manage_vip_packages')->with('success', 'Thêm gói VIP thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@storeVipPackage: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi lưu gói VIP: ' . $e->getMessage());
        }
    }

    public function editVipPackage($id)
    {
        try {
            $vipPackage = VipPackage::findOrFail($id);
            return view('admin.edit_vip_package', compact('vipPackage'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@editVipPackage: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải form chỉnh sửa gói VIP: ' . $e->getMessage());
        }
    }

    public function updateVipPackage(Request $request, $id)
    {
        try {
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
            return redirect()->route('admin.manage_vip_packages')->with('success', 'Cập nhật gói VIP thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@updateVipPackage: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi cập nhật gói VIP: ' . $e->getMessage());
        }
    }

    public function deleteVipPackage($id)
    {
        try {
            $vipPackage = VipPackage::findOrFail($id);
            $vipPackage->delete();
            return redirect()->route('admin.manage_vip_packages')->with('success', 'Xóa gói VIP thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@deleteVipPackage: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi xóa gói VIP: ' . $e->getMessage());
        }
    }

    // Quản lý lịch sử câu hỏi
    public function manageQuestionHistory()
    {
        try {
            $questions = Question::orderBy('created_at', 'desc')->get();
            return view('admin.manage_question_history', compact('questions'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@manageQuestionHistory: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải lịch sử câu hỏi: ' . $e->getMessage());
        }
    }

    // Quản lý gói VIP của người dùng
    public function manageUserVipPackages($id)
    {
        try {
            $user = User::findOrFail($id);
            $vipPackages = VipSubscription::where('user_id', $id)->with('vipPackage')->get();
            return view('admin.manage_vip_packages', compact('user', 'vipPackages'));
        } catch (\Exception $e) {
            Log::error('Error in AdminController@manageUserVipPackages: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi tải gói VIP của người dùng: ' . $e->getMessage());
        }
    }

    // Gán gói VIP cho người dùng
    public function assignVipPackage(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vip_package_id' => 'required|exists:vip_packages,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            VipSubscription::create([
                'user_id' => $id,
                'vip_package_id' => $request->vip_package_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return redirect()->route('admin.manage_vip_packages', $id)->with('success', 'Gán gói VIP thành công');
        } catch (\Exception $e) {
            Log::error('Error in AdminController@assignVipPackage: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Đã xảy ra lỗi khi gán gói VIP: ' . $e->getMessage());
        }
    }
}