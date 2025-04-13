<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipSubscription extends Model
{
    use HasFactory;

    protected $table = 'vip_subscriptions';

    protected $fillable = [
        'user_id', 'vip_package_id', 'start_date', 'end_date'
    ];

    /**
     * Các trường được tự động chuyển đổi thành đối tượng Carbon.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Quan hệ với model User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với model VipPackage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vipPackage()
    {
        return $this->belongsTo(VipPackage::class);
    }
}