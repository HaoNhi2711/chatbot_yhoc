<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipPackage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'duration'];

    public function subscriptions()
    {
        return $this->hasMany(VipSubscription::class, 'vip_package_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'vip_subscriptions', 'vip_package_id', 'user_id');
    }
}