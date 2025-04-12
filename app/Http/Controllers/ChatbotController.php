<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\VipPackage;
use App\Models\VipSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    // Hiển thị trang chat
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để sử dụng chatbot.');
        }

        $user = Auth::user();
        $userId = $user->id; // Lấy user ID

        // Lấy lịch sử tin nhắn
        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at')
            ->get();

        // Lấy danh sách gói VIP
        $vipPackages = VipPackage::all();

        return view('user.chat', compact('messages', 'vipPackages', 'userId')); // Truyền userId vào view
    }

    // Xử lý gửi tin nhắn
    public function sendMessage(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để gửi tin nhắn.');
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $userId = $user->id; // Lấy user ID
        $userMessage = $request->input('message');

        $isVip = $this->isUserVip($userId);

        // Lưu tin nhắn người dùng
        $this->saveMessage($userId, 'user', $userMessage);

        // Gọi chatbot
        $botReply = $this->callChatbot($userMessage, $isVip);

        // Lưu phản hồi của bot
        $this->saveMessage($userId, 'bot', $botReply);

        return redirect()->route('user.chat');
    }

    // Trang lịch sử chat
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem lịch sử.');
        }

        $user = Auth::user();
        $userId = $user->id; // Lấy user ID

        $messages = ChatMessage::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return view('user.history', compact('messages'));
    }

    // Kiểm tra user có đang là VIP hay không
    private function isUserVip($userId): bool
    {
        return VipSubscription::where('user_id', $userId)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->exists();
    }

    // Gọi OpenAI tạo phản hồi
    private function callChatbot(string $message, bool $isVip): string
    {
        $systemPrompt = $isVip
            ? 'Bạn là bác sĩ AI. Trả lời chuyên sâu, có dẫn chứng y khoa nếu cần, trình bày rõ ràng cho người có kiến thức cơ bản đến trung bình.'
            : 'Bạn là chatbot y học. Trả lời ngắn gọn, dễ hiểu, chính xác và phù hợp cho người dùng phổ thông.';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens' => $isVip ? 1000 : 400,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?? 'Chatbot không phản hồi.';
            }

            Log::warning('OpenAI API response error: ' . $response->body());
            return 'Xin lỗi, chatbot đang gặp sự cố khi trả lời.';

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return 'Xin lỗi, hiện tại không thể kết nối tới hệ thống chatbot.';
        }
    }

    // Lưu tin nhắn
    private function saveMessage($userId, $sender, $message): void
    {
        ChatMessage::create([
            'user_id' => $userId,
            'sender' => $sender,
            'message' => $message,
        ]);
    }
}
