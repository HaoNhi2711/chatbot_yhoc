<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người Dùng - Admin Chatbot Y Tế</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
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

        /* Nút đăng xuất trong sidebar */
        .logout-btn {
            padding: 12px 10px;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            text-align: left;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            transition: background-color 0.3s;
            margin-top: 500px;
            margin-left: 10px;
            width: auto;
        }

        .logout-btn i {
            margin-right: 5px;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .content {
            margin-left: 260px;
            padding: 40px;
            flex-grow: 1;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #004080;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .table-container {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 8px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-add {
            margin-bottom: 15px;
            display: inline-block;
            background-color: #007bff;
        }

        .btn-add:hover {
            background-color: #0069d9;
        }

        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">Admin - Chatbot Y Tế</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.manage_users') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.manage_medical_data') }}"><i class="fas fa-notes-medical"></i> Quản lý Dữ liệu Y khoa</a></li>
            <li><a href="{{ route('admin.manage_vip_packages') }}"><i class="fas fa-money-check-alt"></i> Quản lý Gói VIP</a></li>
            <li><a href="{{ route('admin.statistics_reports') }}"><i class="fas fa-chart-bar"></i> Thống kê & Báo cáo</a></li>
        </ul>
        
        <!-- Nút đăng xuất trong sidebar -->
        <a href="{{ route('login') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>

    <!-- Nội dung chính -->
    <div class="content">
        <div class="container">
            <h1>Quản lý Người Dùng</h1>

            <!-- Thông báo thành công -->
            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <!-- Nút thêm -->
            <a href="{{ route('admin.create_user') }}" class="btn btn-add"><i class="fas fa-user-plus"></i> Thêm Người Dùng</a>

            <!-- Bảng danh sách người dùng -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role === 'admin' ? 'Admin' : 'Người dùng' }}</td>
                                <td>
                                    <a href="{{ route('admin.edit_user', $user->id) }}" class="btn">Chỉnh sửa</a>
                                    <form action="{{ route('admin.delete_user', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xoá người dùng này?')">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Không có người dùng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
