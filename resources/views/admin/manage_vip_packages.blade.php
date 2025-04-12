<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đăng ký Gói VIP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #eef2f7;
            display: flex;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #004080;
            color: white;
            padding-top: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar .brand {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a i {
            margin-right: 12px;
        }

        .sidebar ul li a:hover {
            background-color: #0073e6;
            border-left: 5px solid white;
        }

        .logout-btn {
            margin: 20px;
            padding: 12px 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .content {
            margin-left: 260px;
            padding: 40px;
            width: 100%;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        h1 {
            text-align: center;
            color: #004080;
        }

        .btn {
            padding: 10px 18px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #333;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #0073e6;
            color: white;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-error {
            background-color: #dc3545;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">Admin - Chatbot Y Tế</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.manage_users') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.manage_medical_data') }}"><i class="fas fa-notes-medical"></i> Dữ liệu Y khoa</a></li>
            <li><a href="{{ route('admin.manage_vip_packages') }}"><i class="fas fa-gift"></i> Quản Lý Gói Vip</a></li>
            <li><a href="{{ route('admin.admin.user_histories') }}"><i class="fas fa-history"></i> Lịch sử hỏi đáp</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
        </form>
    </div>

    <div class="content">
        <div class="container">
            <h1>Danh sách Người Dùng Đã Đăng Ký Gói VIP</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <div style="text-align: right; margin-bottom: 20px;">
                <a href="{{ route('admin.create_vip_package') }}" class="btn btn-primary">+ Thêm đăng ký VIP</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người dùng</th>
                        <th>Email</th>
                        <th>Gói VIP</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $index => $sub)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sub->user->name }}</td>
                            <td>{{ $sub->user->email }}</td>
                            <td>{{ $sub->vipPackage->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($sub->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($sub->end_date)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.edit_vip_package', $sub->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('admin.delete_vip_package', $sub->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xoá đăng ký của {{ $sub->user->name }} không?')">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Chưa có đăng ký nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
