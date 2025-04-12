<?php

namespace App\Http\Controllers;

use App\Models\VipSubscription;
use App\Models\User;
use App\Models\VipPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VipSubscriptionController extends Controller
{
    // ================================
    // ⚙️ ADMIN: Quản lý gói VIP
    // ================================

    // Hiển thị danh sách các đăng ký gói VIP
    public function index()
    {
        $subscriptions = VipSubscription::with(['user', 'vipPackage'])->get();
        return view('admin.manage_vip_packages', compact('subscriptions'));
    }

    // Thêm đăng ký gói VIP (thủ công cho admin)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vip_package_id' => 'required|exists:vip_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        VipSubscription::create($request->all());

        return redirect()->route('admin.manage_vip_packages')->with('success', 'Đăng ký gói VIP thành công!');
    }

    // Chỉnh sửa đăng ký VIP
    public function edit($id)
    {
        $subscription = VipSubscription::findOrFail($id);
        $users = User::all();
        $vipPackages = VipPackage::all();
        return view('admin.edit_vip_package', compact('subscription', 'users', 'vipPackages'));
    }

    // Cập nhật đăng ký VIP
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vip_package_id' => 'required|exists:vip_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $subscription = VipSubscription::findOrFail($id);
        $subscription->update($request->all());

        return redirect()->route('admin.manage_vip_packages')->with('success', 'Cập nhật gói VIP thành công!');
    }

    // Xoá đăng ký VIP
    public function destroy($id)
    {
        $subscription = VipSubscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.manage_vip_packages')->with('success', 'Đã xoá đăng ký VIP!');
    }

    // ================================
    // 👤 USER: Đăng ký gói VIP
    // ================================

    public function register($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đăng ký VIP.');
        }

        if ($user->isVip()) {
            return redirect()->back()->with('error', 'Bạn đã là thành viên VIP.');
        }

        $package = VipPackage::findOrFail($id);

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($package->duration);

        VipSubscription::create([
            'user_id' => $user->id,
            'vip_package_id' => $package->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()->back()->with('success', '🎉 Đăng ký gói VIP thành công!');
    }
}
