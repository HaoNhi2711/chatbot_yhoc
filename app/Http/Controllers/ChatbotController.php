<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\VipPackage;
use App\Models\VipSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ChatbotController extends Controller
{
    // Hiển thị trang chat
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để sử dụng chatbot.');
        }

        $user = Auth::user();
        $userId = $user->id;

        // Lấy lịch sử tin nhắn, giới hạn số lượng để tránh tải quá nhiều
        $messages = Message::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Lấy danh sách gói VIP
        $vipPackages = VipPackage::all();

        // Kiểm tra trạng thái VIP
        $isVip = $this->isUserVip($userId);

        return view('user.chat', compact('messages', 'vipPackages', 'userId', 'isVip'));
    }

    // Xử lý gửi tin nhắn
    public function sendMessage(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'error' => 'Vui lòng đăng nhập để gửi tin nhắn.'], 401);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $userId = $user->id;
        $userMessage = $request->input('message');

        $isVip = $this->isUserVip($userId);

        try {
            // Lưu tin nhắn người dùng
            $this->saveMessage($userId, 'user', $userMessage);

            // Gọi FastAPI chatbot với timeout tăng lên để tránh lỗi mạng
            $botReply = $this->callChatbot($userMessage, $isVip);

            // Lưu phản hồi của bot
            $this->saveMessage($userId, 'bot', $botReply);

            return response()->json(['success' => true, 'response' => $botReply]);
        } catch (\Exception $e) {
            Log::error('Send message failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Không thể xử lý tin nhắn. Vui lòng thử lại sau.',
                'details' => $e->getMessage() // Thêm chi tiết lỗi để debug
            ], 500);
        }
    }

    // Trang lịch sử chat
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem lịch sử.');
        }

        $user = Auth::user();
        $userId = $user->id;

        $messages = Message::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return view('user.history', compact('messages'));
    }

    // Kiểm tra user có đang là VIP hay không
    private function isUserVip($userId): bool
    {
        return VipSubscription::where('user_id', $userId)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->exists();
    }

    // Gọi FastAPI endpoint
    private function callChatbot(string $message, bool $isVip): string
    {
        $enhancedMessage = $isVip
            ? "Trả lời chuyên sâu, có dẫn chứng y khoa nếu cần, trình bày rõ ràng: $message"
            : $message;

        Log::info("Calling FastAPI with message: " . $enhancedMessage);

        try {
            $response = Http::timeout(45)->post('http://127.0.0.1:8000/chatbot', [ // Tăng timeout lên 45 giây
                'message' => $enhancedMessage,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('FastAPI response: ' . json_encode($data));
                return $data['response'] ?? 'Chatbot không phản hồi. Vui lòng thử lại.';
            }

            Log::warning('FastAPI response error: Status ' . $response->status() . ', Body: ' . $response->body());
            return 'Xin lỗi, chatbot đang gặp sự cố khi trả lời. Vui lòng thử lại sau.';
        } catch (\Exception $e) {
            Log::error('FastAPI Exception: ' . $e->getMessage() . ' - Request: ' . $enhancedMessage);
            return 'Xin lỗi, hiện tại không thể kết nối tới hệ thống chatbot. Vui lòng thử lại sau.';
        }
    }

    // Lưu tin nhắn
    private function saveMessage($userId, $sender, $message): void
    {
        try {
            Message::create([
                'user_id' => $userId,
                'sender' => $sender,
                'message' => $message,
            ]);
            Log::info("Saved message from $sender for user $userId");
        } catch (\Exception $e) {
            Log::error('Failed to save message: ' . $e->getMessage());
            throw new \Exception('Lỗi khi lưu tin nhắn: ' . $e->getMessage());
        }
    }
}