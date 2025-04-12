<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Y Học</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: #2196f3;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 24px 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
            position: relative;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 30px;
            font-weight: 700;
            line-height: 1.4;
            color: #ffffff;
        }

        .sidebar .vip-label {
            background-color: #ffeb3b;
            color: #000;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a,
        .sidebar form button {
            display: block;
            background-color: #ffffff10;
            color: white;
            text-decoration: none;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            text-align: left;
            transition: background 0.3s ease, color 0.3s ease;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar form button:hover {
            background-color: #ffffff20;
            color: #2196f3;
        }

        .sidebar form button {
            background-color: #e74c3c;
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: #ffffff;
            padding: 16px 24px;
            border-bottom: 1px solid #ddd;
            font-size: 20px;
            font-weight: bold;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background-color: #f3f3f3;
        }

        .message {
            max-width: 70%;
            padding: 12px 16px;
            margin-bottom: 12px;
            border-radius: 16px;
            line-height: 1.5;
            white-space: pre-line;
        }

        .user-message {
            background-color: #dcf8c6;
            align-self: flex-end;
            margin-left: auto;
        }

        .bot-message {
            background-color: #ffffff;
            align-self: flex-start;
            margin-right: auto;
            border: 1px solid #ddd;
        }

        .chat-input {
            padding: 16px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }

        .chat-input form {
            display: flex;
            gap: 12px;
        }

        .chat-input input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
        }

        .chat-input button {
            padding: 12px 20px;
            background-color: #1976d2;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .chat-input button:hover {
            background-color: #0d47a1;
        }

        .time {
            font-size: 12px;
            color: #666;
            margin-top: 6px;
        }

        .notification {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .chat-body {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
@php use Illuminate\Support\Facades\Auth; @endphp

<div class="sidebar">
    <h2>🩺 Chatbot Y Học</h2>

    @if (Auth::check() && Auth::user()->isVip())
        <div class="vip-label">👑 Thành viên VIP</div>
    @endif

    @if (Auth::check())
        <form method="POST" action="{{ route('user.register_vip', ['id' => $userId ?? 0]) }}">
            @csrf
            <button type="submit">🌟 Mua gói VIP</button>
        </form>
    @else
        <a href="{{ route('login') }}">🔐 Đăng nhập để mua VIP</a>
    @endif

    <a href="{{ route('user.history') }}">📜 Lịch sử hỏi đáp</a>

    @if (Auth::check())
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">🚪 Đăng xuất</button>
        </form>
    @else
        <a href="{{ route('login') }}">🔑 Đăng nhập</a>
    @endif
</div>

<div class="main">
    <div class="chat-header">
        Xin chào {{ Auth::user()->name ?? 'người dùng' }} 👋
    </div>

    @if (session('success'))
        <div class="notification success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="notification error">
            {{ session('error') }}
        </div>
    @endif

    <div class="chat-body" id="chat-body">
        @if (!empty($messages))
            @foreach ($messages as $msg)
                <div class="message {{ $msg->is_user ? 'user-message' : 'bot-message' }}">
                    {{ $msg->content }}
                    <div class="time">{{ $msg->created_at->format('H:i d/m/Y') }}</div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="chat-input">
        @if (Auth::check())
            <form method="POST" action="{{ route('user.chat.send') }}">
                @csrf
                <input type="text" name="message" placeholder="Nhập tin nhắn..." required autocomplete="off" id="message-input">
                <button type="submit">Gửi</button>
            </form>
        @else
            <p>Đăng nhập để gửi tin nhắn.</p>
        @endif
    </div>
</div>

<script>
    const chatBody = document.getElementById('chat-body');
    if (chatBody) {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    document.getElementById('message-input')?.focus();
</script>
</body>
</html>
