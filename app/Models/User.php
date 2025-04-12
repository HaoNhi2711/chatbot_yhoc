<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $dates = ['email_verified_at', 'vip_expires_at'];

    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'vip_package_id', 'vip_expires_at'
    ];

    // Quan hệ với gói VIP
    public function vipPackage()
    {
        return $this->belongsTo(VipPackage::class, 'vip_package_id');
    }

    // Quan hệ với bảng UserVipSubscription
    public function subscriptions()
    {
        return $this->hasMany(UserVipSubscription::class, 'user_id');
    }

    /**
     * Kiểm tra nếu người dùng đã đăng ký gói VIP hợp lệ.
     *
     * @return bool
     */
    public function isVip()
    {
        // Kiểm tra nếu người dùng có bất kỳ đăng ký VIP nào có ngày kết thúc còn lại và hợp lệ
        $latestSubscription = $this->subscriptions()->where('end_date', '>=', now())->latest()->first();
        
        return $latestSubscription ? true : false;
    }
}
