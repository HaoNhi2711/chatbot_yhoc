<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Y Học</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 260px;
        }
        .chat-header {
            background-color: #ffffff;
            padding: 20px 30px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 22px;
            font-weight: 600;
            color: #004080;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .chat-body {
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
        .chat-input {
            padding: 20px 30px;
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
        }
        .chat-input form {
            display: flex;
            gap: 16px;
            align-items: center;
        }
        .chat-input input[type="text"] {
            flex: 1;
            padding: 14px 20px;
            border: 1px solid #d0d0d0;
            border-radius: 12px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .chat-input input[type="text"]:focus {
            border-color: #0073e6;
            box-shadow: 0 0 8px rgba(0, 115, 230, 0.2);
            outline: none;
        }
        .chat-input button {
            padding: 14px 24px;
            background: linear-gradient(45deg, #0073e6, #0056b3);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .chat-input button:hover {
            background: linear-gradient(45deg, #005bb5, #003087);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .chat-input button:disabled {
            background: #b0bec5;
            cursor: not-allowed;
            box-shadow: none;
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
            .chat-body {
                padding: 20px;
            }
            .chat-input {
                padding: 16px 20px;
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
                <div class="message {{ $msg->sender === 'user' ? 'user-message' : 'bot-message' }}">
                    {{ $msg->message }}
                    <div class="time">{{ $msg->created_at->format('H:i d/m/Y') }}</div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="chat-input">
        @if (Auth::check())
            <form id="chat-form">
                <input type="text" name="message" id="message-input" placeholder="Nhập câu hỏi y học..." required autocomplete="off">
                <button type="submit" id="send-button"><i class="fas fa-paper-plane"></i> Gửi</button>
            </form>
        @else
            <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi câu hỏi.</p>
        @endif
    </div>
</div>

<script>
    const chatBody = document.getElementById('chat-body');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const sidebar = document.getElementById('sidebar');

    // Cuộn xuống cuối khi tải trang
    if (chatBody) {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Tự động focus vào input
    if (messageInput) {
        messageInput.focus();
    }

    // Toggle sidebar trên mobile
    function toggleSidebar() {
        sidebar.classList.toggle('active');
    }

    if (chatForm) {
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            if (!message) return;

            // Vô hiệu hóa nút gửi để tránh gửi liên tục
            sendButton.disabled = true;
            sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';

            // Hiển thị tin nhắn người dùng
            const userMessage = document.createElement('div');
            userMessage.className = 'message user-message';
            userMessage.innerHTML = `${message}<div class="time">${new Date().toLocaleString('vi-VN')}</div>`;
            chatBody.appendChild(userMessage);

            try {
                const response = await fetch('{{ route('user.chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ message }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    const botMessage = document.createElement('div');
                    botMessage.className = 'message bot-message';
                    botMessage.innerHTML = `${data.response}<div class="time">${new Date().toLocaleString('vi-VN')}</div>`;
                    chatBody.appendChild(botMessage);
                } else {
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'notification error';
                    errorMessage.textContent = data.error || 'Lỗi không xác định từ server';
                    if (response.status === 419) {
                        errorMessage.textContent = 'Phiên hết hạn. Vui lòng đăng nhập lại.';
                    } else if (response.status === 500) {
                        errorMessage.textContent = 'Lỗi server. Vui lòng thử lại sau.';
                    }
                    chatBody.appendChild(errorMessage);
                }
            } catch (error) {
                const errorMessage = document.createElement('div');
                errorMessage.className = 'notification error';
                errorMessage.textContent = 'Lỗi kết nối: ' + error.message;
                chatBody.appendChild(errorMessage);
            } finally {
                // Kích hoạt lại nút gửi
                messageInput.value = '';
                sendButton.disabled = false;
                sendButton.innerHTML = '<i class="fas fa-paper-plane"></i> Gửi';
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        });
    }
</script>
</body>
</html>