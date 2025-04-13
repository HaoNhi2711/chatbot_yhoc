<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Hỏi Đáp - Chatbot Y Học</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #eef2f7;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 260px;
            background-color: #004080;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 24px 20px;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100%;
            transition: transform 0.3s ease;
        }
        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 30px;
            font-weight: 700;
            line-height: 1.4;
            color: #ffffff;
            text-align: center;
        }
        .sidebar .vip-label {
            background: linear-gradient(45deg, #ffd700, #ffb300);
            color: #000;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .sidebar a,
        .sidebar form button {
            display: flex;
            align-items: center;
            background: linear-gradient(45deg, #0073e6, #0056b3);
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            margin-bottom: 16px;
            border-radius: 12px;
            border: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar a:hover,
        .sidebar form button:hover {
            background: linear-gradient(45deg, #005bb5, #003087);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .sidebar form button.logout {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
        }
        .sidebar form button.logout:hover {
            background: linear-gradient(45deg, #c0392b, #a5281a);
        }
        .sidebar a.back-button {
            display: flex;
            align-items: center;
            background: linear-gradient(45deg, #00c4b4, #009688);
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            margin-bottom: 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }
        .sidebar a.back-button i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        .sidebar a.back-button:hover {
            background: linear-gradient(45deg, #009688, #00796b);
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        }
        .sidebar a.back-button:hover i {
            transform: translateX(-5px);
        }
        .sidebar a.back-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        .sidebar a.back-button:hover::before {
            left: 100%;
        }
        .sidebar a.back-button:active {
            transform: scale(0.95);
        }
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 260px;
        }
        .history-header {
            background-color: #ffffff;
            padding: 20px 30px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 22px;
            font-weight: 600;
            color: #004080;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .history-body {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            background-color: #f8fafc;
        }
        .message {
            max-width: 70%;
            padding: 14px 20px;
            margin-bottom: 16px;
            border-radius: 12px;
            line-height: 1.6;
            white-space: pre-line;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }
        .message:hover {
            transform: translateY(-2px);
        }
        .user-message {
            background: linear-gradient(45deg, #28a745, #218838);
            color: white;
            align-self: flex-end;
            margin-left: auto;
        }
        .bot-message {
            background-color: #ffffff;
            align-self: flex-start;
            margin-right: auto;
            border: 1px solid #e0e0e0;
            color: #333;
        }
        .time {
            font-size: 12px;
            color: #777;
            margin-top: 8px;
            opacity: 0.8;
        }
        .notification {
            padding: 12px 20px;
            margin: 10px 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
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
                transform: translateX(-260px);
                position: fixed;
                z-index: 1000;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main {
                margin-left: 0;
            }
            .history-body {
                padding: 20px;
            }
            .toggle-sidebar {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                background: #004080;
                color: white;
                border: none;
                padding: 10px;
                border-radius: 8px;
                cursor: pointer;
                z-index: 1001;
            }
        }
    </style>
</head>
<body>
@php use Illuminate\Support\Facades\Auth; @endphp

<button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>

<div class="sidebar" id="sidebar">
    <h2>🩺 Chatbot Y Học</h2>
    <a href="{{ route('user.chat') }}" class="back-button"><i class="fas fa-arrow-left"></i> Quay lại Chatbot</a>

    @if (Auth::check() && $isVip)
        <div class="vip-label">👑 Thành viên VIP</div>
    @endif

    @if (Auth::check() && !$isVip)
        <a href="{{ route('user.show_vip_packages') }}"><i class="fas fa-star"></i> Chọn gói VIP</a>
    @else
        <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Đăng nhập để mua VIP</a>
    @endif

    <a href="{{ route('user.history') }}"><i class="fas fa-history"></i> Lịch sử hỏi đáp</a>

    @if (Auth::check())
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
        </form>
    @else
        <a href="{{ route('login') }}"><i class="fas fa-key"></i> Đăng nhập</a>
    @endif
</div>

<div class="main">
    <div class="history-header">
        Lịch Sử Hỏi Đáp của {{ Auth::user()->name ?? 'người dùng' }}
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

    <div class="history-body" id="history-body">
        @if (empty($messages) || count($messages) === 0)
            <p class="notification">Bạn chưa có lịch sử hỏi đáp.</p>
        @else
            @foreach ($messages as $msg)
                <!-- Hiển thị câu hỏi của người dùng -->
                <div class="message user-message">
                    {{ $msg->question }}
                    <div class="time">{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i d/m/Y') }}</div>
                </div>
                <!-- Hiển thị trả lời của bot (nếu có) -->
                @if ($msg->response)
                    <div class="message bot-message">
                        {{ $msg->response }}
                        <div class="time">{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i d/m/Y') }}</div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<script>
    const historyBody = document.getElementById('history-body');
    const sidebar = document.getElementById('sidebar');

    // Cuộn xuống cuối khi tải trang
    if (historyBody) {
        historyBody.scrollTop = historyBody.scrollHeight;
    }

    // Toggle sidebar trên mobile
    function toggleSidebar() {
        sidebar.classList.toggle('active');
    }
</script>
</body>
</html>