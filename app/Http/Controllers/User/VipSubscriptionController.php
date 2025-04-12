<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VipPackage;
use App\Models\VipSubscription;

class VipSubscriptionController extends Controller
{
    public function registerDefault(Request $request)
    {
        \Log::info('Register VIP Request:', [
            'method' => $request->method(),
            'url' => $request->url(),
            'user_id' => Auth::id(),
        ]);

        try {
            // Kiểm tra người dùng đã đăng nhập chưa
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước.');
            }

            $user = Auth::user();
            $defaultVipPackageId = 1;

            // Lấy thông tin gói VIP mặc định
            $package = VipPackage::find($defaultVipPackageId);

            // Kiểm tra nếu gói VIP không tồn tại
            if (!$package) {
                return redirect()->back()->with('error', 'Gói VIP không tồn tại.');
            }

            // Tạo subscription cho người dùng
            $startDate = now();
            $endDate = $startDate->copy()->addDays($package->duration);

            // Tạo bản ghi đăng ký VIP
            VipSubscription::create([
                'user_id' => $user->id,
                'vip_package_id' => $package->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            return redirect()->route('user.chat')->with('success', 'Đăng ký VIP thành công!');
        } catch (\Exception $e) {
            // Ghi lại lỗi vào log
            \Log::error('Register VIP Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->back()->with('error', 'Không thể đăng ký VIP: ' . $e->getMessage());
        }
    }
}
