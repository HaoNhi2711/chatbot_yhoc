<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipSubscription extends Model
{
    use HasFactory;

    // Định nghĩa bảng nếu tên bảng không phải theo quy tắc số ít
    protected $table = 'vip_subscriptions'; 

    // Các cột có thể được gán đại diện cho thuộc tính của model
    protected $fillable = [
        'user_id',
        'vip_package_id',
        'start_date',
        'end_date',
    ];

    // Quan hệ với User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với VipPackage model
    public function vipPackage()
    {
        return $this->belongsTo(VipPackage::class);
    }
}
