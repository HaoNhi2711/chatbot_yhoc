<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalData extends Model
{
    use HasFactory;

    // Thêm các trường cần mass assign vào mảng $fillable
    protected $fillable = [
        'title', 
        'description',
        // Các trường khác bạn muốn cho phép mass assignment
    ];
}

