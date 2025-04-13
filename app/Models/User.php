<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $dates = ['email_verified_at'];

    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at'
    ];

    /**
     * Quan hệ với bảng vip_subscriptions.
     */
    public function subscriptions()
    {
        return $this->hasMany(VipSubscription::class, 'user_id');
    }

    /**
     * Quan hệ với bảng messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Kiểm tra xem người dùng có phải là VIP không.
     *
     * @return bool
     */
    public function isVip()
    {
        return $this->subscriptions()->where('end_date', '>=', now())->exists();
    }

    /**
     * Lấy gói VIP hiện tại của người dùng (nếu còn hạn).
     *
     * @return \App\Models\VipPackage|null
     */
    public function currentVipPackage()
    {
        $subscription = $this->subscriptions()
            ->where('end_date', '>=', Carbon::now())
            ->latest()
            ->first();
        return $subscription ? $subscription->vipPackage : null;
    }
}