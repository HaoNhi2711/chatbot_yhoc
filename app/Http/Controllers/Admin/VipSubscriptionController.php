<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipSubscription;
use App\Models\VipPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VipSubscriptionController extends Controller
{
    // --- Quản lý gói VIP ---

    public function indexPackages()
    {
        $this->checkExpiredVip(); // Tự động kiểm tra hết hạn VIP

        $vipPackages = VipPackage::withCount('subscriptions')->get();
        return view('admin.vip_subscriptions.index', compact('vipPackages'));
    }

    public function createPackage()
    {
        return view('admin.vip_subscriptions.create');
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);

        VipPackage::create($request->only(['name', 'description', 'price', 'duration']));

        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được thêm thành công!');
    }

    public function editPackage($id)
    {
        $vipPackage = VipPackage::findOrFail($id);
        $vipPackage->load('subscriptions.user');
        return view('admin.vip_subscriptions.edit', compact('vipPackage'));
    }

    public function updatePackage(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);

        $vipPackage = VipPackage::findOrFail($id);
        $vipPackage->update($request->only(['name', 'description', 'price', 'duration']));

        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được cập nhật!');
    }

    public function destroyPackage($id)
    {
        $vipPackage = VipPackage::findOrFail($id);
        if ($vipPackage->subscriptions()->exists()) {
            return redirect()->route('admin.manage_vip_packages')->with('error', 'Không thể xóa gói VIP vì có người dùng đã đăng ký!');
        }

        $vipPackage->delete();

        return redirect()->route('admin.manage_vip_packages')->with('success', 'Gói VIP đã được xóa!');
    }

    // --- Quản lý đăng ký VIP ---

    public function index()
    {
        $this->checkExpiredVip(); // Kiểm tra hết hạn VIP khi vào trang này

        $subscriptions = VipSubscription::with(['user', 'vipPackage'])->get();
        return view('admin.vip_subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $users = User::all();
        $vipPackages = VipPackage::all();
        return view('admin.vip_subscriptions.create', compact('users', 'vipPackages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vip_package_id' => 'required|exists:vip_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        VipSubscription::create([
            'user_id' => $request->user_id,
            'vip_package_id' => $request->vip_package_id,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
        ]);

        return redirect()->route('admin.vip_subscriptions.index')->with('success', 'Đăng ký gói VIP thành công!');
    }

    public function edit($id)
    {
        $subscription = VipSubscription::findOrFail($id);
        $users = User::all();
        $vipPackages = VipPackage::all();
        return view('admin.vip_subscriptions.edit', compact('subscription', 'users', 'vipPackages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vip_package_id' => 'required|exists:vip_packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $subscription = VipSubscription::findOrFail($id);
        $subscription->update([
            'user_id' => $request->user_id,
            'vip_package_id' => $request->vip_package_id,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
        ]);

        return redirect()->route('admin.vip_subscriptions.index')->with('success', 'Cập nhật gói VIP thành công!');
    }

    public function destroy($id)
    {
        $subscription = VipSubscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.vip_subscriptions.index')->with('success', 'Đã xoá đăng ký VIP!');
    }

    // Người dùng đăng ký gói VIP
    public function register(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đăng ký VIP.');
        }

        if ($user->isVip()) {
            return redirect()->back()->with('error', 'Bạn đã là thành viên VIP.');
        }

        $package = VipPackage::find($id);
        if (!$package) {
            return redirect()->back()->with('error', 'Gói VIP không tồn tại.');
        }

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($package->duration);

        VipSubscription::create([
            'user_id' => $user->id,
            'vip_package_id' => $package->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $user->is_vip = 1;
        $user->save();

        return redirect()->back()->with('success', '🎉 Đăng ký gói ' . $package->name . ' thành công!');
    }

    // Kiểm tra và hạ cấp user hết hạn VIP
    public function checkExpiredVip()
    {
        $today = Carbon::now();

        $expiredSubscriptions = VipSubscription::where('end_date', '<', $today)->get();

        foreach ($expiredSubscriptions as $subscription) {
            $user = $subscription->user;
            if ($user && $user->is_vip == 1) {
                $user->is_vip = 0;
                $user->save();
            }
        }
    }
}