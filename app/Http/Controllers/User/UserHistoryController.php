<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHistoryController extends Controller
{
    public function index($id = null)
    {
        try {
            // Trường hợp admin xem lịch sử của người dùng cụ thể
            if (Auth::user()->role === 'admin' && $id) {
                $user = User::findOrFail($id);

                // Lấy tất cả tin nhắn của người dùng với sender = 'user'
                $userMessages = Message::where('user_id', $id)
                    ->where('sender', 'user')
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Ghép câu hỏi và trả lời thành cặp
                $messages = [];
                foreach ($userMessages as $userMessage) {
                    // Tìm tin nhắn trả lời của bot (nếu có) dựa trên thời gian
                    $botResponse = Message::where('user_id', $id)
                        ->where('sender', 'bot')
                        ->where('created_at', '>=', $userMessage->created_at)
                        ->orderBy('created_at', 'asc')
                        ->first();

                    // Tạo object để truyền vào view
                    $messages[] = (object)[
                        'question' => $userMessage->message,
                        'response' => $botResponse ? $botResponse->message : null,
                        'created_at' => $userMessage->created_at,
                    ];
                }

                return view('admin.user_history', compact('user', 'messages'));
            }

            // Trường hợp người dùng xem lịch sử của chính mình
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử.');
            }

            // Lấy tất cả tin nhắn của người dùng với sender = 'user'
            $userMessages = Message::where('user_id', $user->id)
                ->where('sender', 'user')
                ->orderBy('created_at', 'asc')
                ->get();

            // Ghép câu hỏi và trả lời thành cặp
            $messages = [];
            foreach ($userMessages as $userMessage) {
                $botResponse = Message::where('user_id', $user->id)
                    ->where('sender', 'bot')
                    ->where('created_at', '>=', $userMessage->created_at)
                    ->orderBy('created_at', 'asc')
                    ->first();

                $messages[] = (object)[
                    'question' => $userMessage->message,
                    'response' => $botResponse ? $botResponse->message : null,
                    'created_at' => $userMessage->created_at,
                ];
            }

            $isVip = $user->isVip();

            return view('user.history', compact('messages', 'isVip'));
        } catch (\Exception $e) {
            \Log::error('Error in UserHistoryController@index: ' . $e->getMessage(), [
                'user_id' => $id ?? Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.dashboard')->with('error', 'Không thể tải lịch sử hỏi đáp.');
        }
    }
}