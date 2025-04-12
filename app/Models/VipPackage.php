<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipPackage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'duration'];

    // Quan hệ với bảng UserVipSubscription
    public function subscriptions()
    {
        return $this->hasMany(UserVipSubscription::class, 'vip_package_id');
    }

    // Quan hệ với bảng users thông qua bảng UserVipSubscription
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vip_subscriptions', 'vip_package_id', 'user_id');
    }
}

