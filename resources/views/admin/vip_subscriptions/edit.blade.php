<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sửa Đăng ký VIP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
            display: flex;
            overflow-x: hidden;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #004080;
            color: white;
            padding: 24px 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .sidebar .brand {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #ffffff;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar ul li {
            margin: 8px 0;
        }
        .sidebar ul li a {
            color: white;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            background: linear-gradient(45deg, #0073e6, #0056b3);
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .sidebar ul li a i {
            margin-right: 12px;
            transition: transform 0.3s ease;
        }
        .sidebar ul li a:hover {
            background: linear-gradient(45deg, #005bb5, #003087);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .sidebar ul li a:hover i {
            transform: translateX(5px);
        }
        .sidebar ul li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        .sidebar ul li a:hover::before {
            left: 100%;
        }
        .logout-btn {
            padding: 14px 20px;
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
            font-weight: 500;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .logout-btn i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        .logout-btn:hover {
            background: linear-gradient(45deg, #c0392b, #a5281a);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .logout-btn:hover i {
            transform: translateX(5px);
        }
        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        .logout-btn:hover::before {
            left: 100%;
        }
        .content {
            margin-left: 260px;
            padding: 40px;
            flex-grow: 1;
            min-height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #004080;
            font-size: 28px;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        input[type="date"],
        select {
            width: 100%;
            padding: 14px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
            background-color: #f8fafc;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input:focus,
        select:focus {
            border-color: #0073e6;
            box-shadow: 0 0 8px rgba(0, 115, 230, 0.2);
            outline: none;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .btn-submit {
            background: linear-gradient(45deg, #28a745, #218838);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            background: linear-gradient(45deg, #0073e6, #0056b3);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .btn-submit:hover {
            background: linear-gradient(45deg, #218838, #1e7e34);
        }
        .btn-back:hover {
            background: linear-gradient(45deg, #005bb5, #003087);
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        .btn:hover::before {
            left: 100%;
        }
        .toggle-sidebar {
            display: none;
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
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
                position: fixed;
                z-index: 1000;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                padding: 20px;
            }
            .container {
                margin: 0 10px;
            }
            .button-group {
                flex-direction: column;
                width: 100%;
            }
            .btn {
                width: 100%;
            }
            .toggle-sidebar {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Nút toggle sidebar cho mobile -->
    <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="brand">🩺 Admin - Chatbot Y Tế</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.manage_users') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.manage_medical_data') }}"><i class="fas fa-notes-medical"></i> Dữ liệu Y khoa</a></li>
            <li><a href="{{ route('admin.vip_subscriptions.index') }}"><i class="fas fa-star"></i> Đăng ký VIP</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
        </form>
    </div>

    <!-- Nội dung -->
    <div class="content">
        <div class="container">
            <h1>✏️ Sửa Đăng ký VIP</h1>

            <form action="{{ route('admin.vip_subscriptions.update', $subscription->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="user_id">Người dùng</label>
                    <select name="user_id" id="user_id" required>
                        <option value="">Chọn người dùng</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $subscription->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="vip_package_id">Gói VIP</label>
                    <select name="vip_package_id" id="vip_package_id" required>
                        <option value="">Chọn gói VIP</option>
                        @foreach($vipPackages as $package)
                            <option value="{{ $package->id }}" {{ old('vip_package_id', $subscription->vip_package_id) == $package->id ? 'selected' : '' }}>
                                {{ $package->name }} ({{ $package->duration }} ngày)
                            </option>
                        @endforeach
                    </select>
                    @error('vip_package_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($subscription->start_date)->format('Y-m-d')) }}" required>
                    @error('start_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($subscription->end_date)->format('Y-m-d')) }}" required>
                    @error('end_date')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <a href="{{ route('admin.vip_subscriptions.index') }}" class="btn btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-submit"><i class="fas fa-save"></i> Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>