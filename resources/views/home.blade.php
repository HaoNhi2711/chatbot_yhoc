<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chatbot Y Học</h1>
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif
        <p>{{ $message ?? 'Chào mừng bạn đến với hệ thống!' }}</p>
        @if (auth()->check())
            <p>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <p><a href="{{ route('login') }}">Đăng nhập</a> | <a href="{{ route('register') }}">Đăng ký</a></p>
        @endif
    </div>
</body>
</html>