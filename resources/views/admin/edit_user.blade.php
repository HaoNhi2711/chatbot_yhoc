<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Người Dùng - Chatbot Y Tế</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts + Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        h2 {
            color: #0073e6;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #0073e6;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 115, 230, 0.2);
        }

        .btn-save {
            background-color: #0073e6;
            color: white;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-save:hover {
            background-color: #005bb5;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
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
            margin-top: -10px;
            margin-bottom: 15px;
            font-size: 14px;
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
        <h2><i class="fas fa-user-edit icon"></i> Chỉnh Sửa Người Dùng</h2>

        <form method="POST" action="{{ url('/admin/manage_users/' . $user->id . '/edit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Họ Tên</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Vai trò</label>
                <select name="role" id="role" required>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Người dùng</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                </select>
                @error('role')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Lưu Thay Đổi
            </button>
        </form>

        <a href="{{ route('admin.manage_users') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách người dùng
        </a>
    </div>
</body>
</html>
