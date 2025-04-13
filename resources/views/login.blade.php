<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Chatbot Y Học</title>
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

        p.subtitle {
            text-align: center;
            color: #555;
            font-size: 14px;
            margin-bottom: 30px;
        }

        label {
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #111827;
            transition: all 0.2s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .success-message {
            color: #16a34a;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 1.5rem;
        }

        .forgot-password {
            color: #3b82f6;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        button {
            width: 100%;
            background: #2563eb;
            color: white;
            font-weight: bold;
            padding: 0.75rem;
            border-radius: 8px;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .form-footer {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 1.5rem;
        }

        .register-link {
            color: #3b82f6;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .register-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <img src="logo.png" alt="Chatbot Y Học" class="logo">
        <h2>Đăng Nhập</h2>
        <p class="subtitle">Trợ lý sức khỏe thông minh của bạn</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif
            @if ($errors->has('message'))
                <div class="error-message">{{ $errors->first('message') }}</div>
            @endif
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ email" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu của bạn" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="checkbox-container">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2 rounded text-blue-600 focus:ring-blue-500"> Nhớ mật khẩu
                </label>
                <a href="#" class="forgot-password">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300">
                Đăng nhập
            </button>
        </form>
        <div class="form-footer">
            <p>Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="register-link">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</body>
</html>