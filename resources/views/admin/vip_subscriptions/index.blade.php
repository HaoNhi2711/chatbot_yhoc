<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đăng Ký VIP - Chatbot Y Tế</title>
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
        }
        h1 {
            text-align: center;
            color: #004080;
            font-size: 28px;
            margin-bottom: 30px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-create {
            background: linear-gradient(45deg, #28a745, #218838);
            color: white;
            margin-bottom: 20px;
        }
        .btn-create:hover {
            background: linear-gradient(45deg, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .btn-edit {
            background: linear-gradient(45deg, #0073e6, #0056b3);
            color: white;
        }
        .btn-edit:hover {
            background: linear-gradient(45deg, #005bb5, #003087);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .btn-delete {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
        }
        .btn-delete:hover {
            background: linear-gradient(45deg, #c0392b, #a5281a);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #e0e0e0;
        }
        th, td {
            padding: 14px;
            text-align: center;
        }
        th {
            background: linear-gradient(45deg, #0073e6, #0056b3);
            color: white;
            font-weight: 600;
        }
        td {
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
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
            <h1>🌟 Quản Lý Đăng Ký VIP</h1>

            @if(session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif

            <a href="{{ route('admin.vip_subscriptions.create') }}" class="btn btn-create"><i class="fas fa-plus"></i> Thêm Đăng ký</a>

            <table>
                <thead>
                    <tr>
                        <th>Người dùng</th>
                        <th>Gói VIP</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->user->name ?? 'N/A' }}</td>
                            <td>{{ $subscription->vipPackage->name ?? 'N/A' }}</td>
                            <td>{{ $subscription->start_date }}</td>
                            <td>{{ $subscription->end_date }}</td>
                            <td>
                                <a href="{{ route('admin.vip_subscriptions.edit', $subscription->id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Sửa</a>
                                <form action="{{ route('admin.vip_subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa đăng ký này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete"><i class="fas fa-trash"></i> Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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