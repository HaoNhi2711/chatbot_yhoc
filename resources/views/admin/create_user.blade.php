<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng - Chatbot Y Tế</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts + Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            transition: border 0.3s ease, box-shadow 0.3s ease;
            font-size: 16px;
        }

        input:focus, select:focus {
            border-color: #0073e6;
            box-shadow: 0 0 10px rgba(0, 115, 230, 0.2);
            outline: none;
        }

        .btn {
            width: 100%;
            background-color: #0073e6;
            color: white;
            padding: 14px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #005bb5;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #0073e6;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .icon {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-user-plus icon"></i> Thêm Người Dùng Mới</h2>

        <form method="POST" action="{{ route('admin.store_user') }}">
            @csrf

            <div class="form-group">
                <label for="name">Họ và Tên</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nhập họ và tên">
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Nhập email">
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu">
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác nhận Mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Xác nhận mật khẩu">
            </div>

            <div class="form-group">
                <label for="role">Quyền</label>
                <select name="role" id="role">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Người dùng</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn">Thêm Người Dùng</button>
        </form>

        <a href="{{ route('admin.manage_users') }}" class="back-link"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
    </div>
</body>
</html>
