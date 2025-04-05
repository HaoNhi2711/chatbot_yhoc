<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Chatbot Y Học</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Thêm ảnh nền cho toàn bộ trang */
        body {
            background-image: url('anh_nen.png'); /* Thay thế với URL ảnh nền của bạn */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif; /* Cải thiện font chữ */
            color: #333;
        }

        /* Cải thiện phần form đăng nhập */
        .form-container {
            background: rgba(255, 255, 255, 0.9); /* Làm nền trong suốt nhẹ để tạo độ mềm mại */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }

        /* Áp dụng hiệu ứng cho các liên kết */
        a {
            text-decoration: none;
            color: #1D4ED8;
            transition: color 0.3s ease, text-decoration 0.3s ease;
        }

        a:hover {
            text-decoration: underline;
            color: #0c3c7f;
        }

        /* Cải thiện hiệu ứng nút đăng nhập */
        button {
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #2563EB;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
        }

        /* Thiết lập các input field đẹp mắt */
        input[type="email"], input[type="password"] {
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            padding: 12px;
            width: 100%;
            margin-top: 6px;
            margin-bottom: 20px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #2563EB; /* Đổi màu border khi focus */
        }

        /* Cải thiện các liên kết bên dưới form */
        .forgot-password, .register-link {
            font-size: 14px;
            color: #1D4ED8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover, .register-link:hover {
            color: #0c3c7f;
            text-decoration: underline;
        }

        /* Cải thiện phần text phía dưới form */
        .footer-text {
            font-size: 14px;
            color: #6B7280;
        }

    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="form-container">
        <div class="text-center mb-6">
            <img src="logo.png" alt="Chatbot Y Học" class="w-16 mx-auto mb-4">
            <h2 class="text-3xl font-bold text-blue-700">Chatbot Y Học</h2>
            <p class="text-gray-600">Trợ lý sức khỏe thông minh của bạn</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full" placeholder="Nhập email của bạn" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Mật khẩu</label>
                <input type="password" id="password" name="password" class="w-full" placeholder="Nhập mật khẩu của bạn" required>
            </div>
            <div class="mb-4 flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2"> Nhớ mật khẩu
                </label>
                <a href="#" class="forgot-password">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg font-bold">Đăng nhập</button>
        </form>
        <p class="footer-text mt-4 text-center">Chưa có tài khoản? 
            <a href="{{ route('register') }}" class="register-link">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>
