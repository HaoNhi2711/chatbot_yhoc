<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Chatbot Y Học</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('anh_nen.png');
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
            background: rgba(255, 255, 255, 0.9);
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

            <!-- Tên -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700">Họ và tên</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mật khẩu -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700">Mật khẩu</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Xác nhận mật khẩu -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
            </div>

            <!-- Nút đăng ký -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300">
                Đăng Ký
            </button>
        </form>

        <!-- Liên kết đến trang đăng nhập -->
        <div class="form-footer mt-4 text-center">
            <p>Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Đăng nhập ngay</a></p>
        </div>
    </div>
</body>
</html>
