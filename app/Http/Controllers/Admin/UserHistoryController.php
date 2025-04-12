<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserHistory;
use App\Http\Controllers\Controller;

class UserHistoryController extends Controller
{
    public function index()
    {
        $histories = UserHistory::with(['performedByUser', 'targetUser'])->orderBy('created_at', 'desc')->get();
        return view('admin.user_histories', compact('histories'));
    }
}
