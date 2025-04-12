<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'user_id',
        'action',
        'note',
    ];

    // Quan hệ với người dùng (người bị tác động)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với admin (người thực hiện)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
