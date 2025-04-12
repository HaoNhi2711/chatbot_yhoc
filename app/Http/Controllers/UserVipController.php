<?php

namespace App\Http\Controllers;

use App\Models\VipPackage;
use App\Models\VipSubscription; // Import thêm model VipSubscription
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVipController extends Controller
{
    // Hiển thị các gói VIP
    public function showVipPackages()
    {
        $vipPackages = VipPackage::all();  // Lấy danh sách gói VIP từ database
        return view('user.vip', compact('vipPackages')); // Hiển thị ra giao diện cho người dùng chọn gói
    }

    // Đăng ký gói VIP
    public function register(Request $request, $id)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đăng ký gói VIP.');
        }

        // Kiểm tra xem gói VIP có tồn tại không
        $vipPackage = VipPackage::find($id);
        if (!$vipPackage) {
            return redirect()->route('user.show_vip_packages')->with('error', 'Gói VIP không tồn tại.');
        }

        // Lưu thông tin đăng ký gói VIP
        $user = Auth::user();
        $subscription = new VipSubscription();
        $subscription->user_id = $user->id;
        $subscription->vip_package_id = $vipPackage->id;
        $subscription->start_date = now();
        $subscription->end_date = now()->addDays($vipPackage->duration); // Tính ngày hết hạn dựa trên gói VIP
        $subscription->save();

        // Cập nhật trạng thái VIP cho người dùng
        $user->is_vip = true;
        $user->save();

        return redirect()->route('user.chat')->with('success', 'Bạn đã đăng ký thành công gói VIP!');
    }
}





