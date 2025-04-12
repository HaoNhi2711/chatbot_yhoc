<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVipSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'vip_package_id', 'start_date', 'end_date'
    ];

    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng VipPackage
    public function vipPackage()
    {
        return $this->belongsTo(VipPackage::class);
    }
}
