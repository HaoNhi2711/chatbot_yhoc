<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu không phải là dạng số nhiều của tên model
    protected $table = 'questions';

    // Các thuộc tính có thể gán hàng loạt (mass assignable)
    protected $fillable = [
        'user_id',
        'question_text',
        'answer_text',
        'created_at',
        'updated_at',
    ];

    // Nếu bạn có quan hệ với các model khác, bạn có thể thêm các phương thức quan hệ.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Nếu bạn có quan hệ với các câu trả lời hoặc các bảng khác
    // public function answers() {
    //     return $this->hasMany(Answer::class);
    // }
}
