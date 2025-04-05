<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Chatbot Y Học</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('anh_nen.png'); /* Thêm ảnh nền cho trang */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9); /* Nền trong suốt nhẹ */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 120px;
        }

        h2 {
            color: #1D4ED8;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            color: #555;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            font-size: 16px;
            background-color: #f7f7f7;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #2563EB;
            outline: none;
        }

        button {
            width: 100%;
            background-color: #1D4ED8;
            color: white;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        button:hover {
            background-color: #2563EB;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: #1D4ED8;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Logo -->
        <img src="logo.png" alt="Logo Chatbot Y Học" class="logo">
        
        <!-- Tiêu đề và mô tả -->
        <h2 class="text-3xl font-bold text-blue-700 text-center mb-6">Đăng Ký Tài Khoản</h2>
        <p>Trở thành người dùng Chatbot Y Học để truy cập vào trợ lý sức khỏe thông minh</p>

        <!-- Form đăng ký -->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" required placeholder="Nhập họ và tên">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Nhập email">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Xác nhận mật khẩu">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg font-bold">Đăng Ký</button>
        </form>

        <!-- Liên kết đến trang đăng nhập -->
        <div class="form-footer">
            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
        </div>
    </div>
</body>
</html>
