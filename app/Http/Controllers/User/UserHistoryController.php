<?php

namespace App\Http\Controllers\User;

use App\Models\UserHistory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserHistoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Lấy các lịch sử mà user là người thực hiện hoặc bị tác động
        $histories = UserHistory::with(['performedByUser', 'targetUser'])
            ->where('performed_by', $userId)
            ->orWhere('target_user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.user_history', compact('histories'));
    }
}
