<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #f4f6f8;
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
            margin: 30px 20px 0;
            padding: 12px;
            background-color: #e11d48;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            flex: 1;
        }

        h1 {
            margin-bottom: 20px;
            color: #1e293b;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-add {
            background-color: #22c55e;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f9fafb;
            font-weight: 500;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        .btn {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
        }

        .btn-history {
            background-color: #3b82f6;
            color: white;
        }

        .btn-edit {
            background-color: #f59e0b;
            color: white;
        }

        .btn-delete {
            background-color: #ef4444;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .vip-label {
            padding: 5px 10px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
        }

        .vip-yes {
            background-color: #10b981;
        }

        .vip-no {
            background-color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">Admin - Chatbot Y Tế</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a class="active" href="{{ route('admin.manage_users') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.manage_medical_data') }}"><i class="fas fa-notes-medical"></i> Quản lý Dữ liệu Y khoa</a></li>
            <li><a href="{{ route('admin.manage_vip_packages') }}"><i class="fas fa-gift"></i> Quản lý Gói VIP</a></li>
            <li><a href="{{ route('admin.admin.user_histories') }}"><i class="fas fa-history"></i> Lịch sử hỏi đáp</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
        </form>
    </div>

    <div class="main-content">
        <div class="top-actions">
            <h1>Danh sách người dùng</h1>
            <a class="btn-add" href="{{ route('admin.create_user') }}"><i class="fas fa-plus"></i> Thêm người dùng</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>VIP</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            @if ($user->is_vip)
                                <span class="vip-label vip-yes">VIP</span>
                            @else
                                <span class="vip-label vip-no">Thường</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-history" href="{{ route('admin.admin.user_histories', ['id' => $user->id]) }}">Lịch sử</a>
                            <a class="btn btn-edit" href="{{ route('admin.edit_user', ['id' => $user->id]) }}">Sửa</a>
                            <form action="{{ route('admin.delete_user', ['id' => $user->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete" onclick="return confirm('Xác nhận xoá người dùng này?')">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
