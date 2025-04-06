<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dữ liệu Y Khoa - Chatbot Y Tế</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
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
            margin-top: auto;
            margin: 20px;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
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
            vertical-align: top;
        }

        th {
            background-color: #0073e6;
            color: white;
        }

        td.description {
            white-space: pre-wrap;
            word-wrap: break-word;
            text-align: left;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box input {
            padding: 10px;
            width: 100%;
            max-width: 500px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-box button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-box button:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">Admin - Chatbot Y Tế</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.manage_users') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.manage_medical_data') }}"><i class="fas fa-notes-medical"></i> Quản lý Dữ liệu Y khoa</a></li>
            <li><a href="{{ route('admin.manage_vip_packages') }}"><i class="fas fa-money-check-alt"></i> Quản lý Gói VIP</a></li>
            <li><a href="{{ route('admin.statistics_reports') }}"><i class="fas fa-chart-bar"></i> Thống kê & Báo cáo</a></li>
        </ul>
        <a href="{{ route('login') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>

    <div class="content">
        <div class="container">
            <h1>Danh sách Dữ liệu Y khoa</h1>

            <div class="search-box">
                <form method="GET" action="{{ route('admin.manage_medical_data') }}">
                    <input type="text" name="search" placeholder="Tìm theo tiêu đề..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
            </div>

            <a href="{{ route('admin.create_medical_data') }}" class="btn btn-primary">Thêm Dữ liệu Y khoa</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalData as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->title }}</td>
                            <td class="description">{{ $data->description }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>{{ $data->updated_at }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('admin.edit_medical_data', $data->id) }}" class="btn">Sửa</a>
                                <form action="{{ route('admin.destroy_medical_data', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
