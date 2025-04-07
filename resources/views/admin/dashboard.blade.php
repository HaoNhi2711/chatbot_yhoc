<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Chatbot Y Tế</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
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
            border: none;
            cursor: pointer;
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
            color: #004080;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .stats .card {
            background: white;
            padding: 20px;
            flex: 1 1 30%;
            margin: 10px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .stats .card:hover {
            transform: translateY(-5px);
        }
        .stats .card h3 {
            color: #0073e6;
            font-size: 26px;
        }
        .stats .card p {
            color: #333;
            margin-top: 10px;
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

        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
                padding: 20px;
            }
            .stats {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">Admin - Chatbot Y Tế</div>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.manage_users') }}"><i class="fas fa-users"></i> Quản lý người dùng</a></li>
            <li><a href="{{ route('admin.manage_medical_data') }}"><i class="fas fa-notes-medical"></i> Quản lý Dữ liệu Y khoa</a></li>
            <li><a href="{{ route('admin.manage_vip_packages') }}"><i class="fas fa-gift"></i> Quản lý Gói VIP</a></li>
            <li><a href="{{ route('admin.manage_question_history') }}"><i class="fas fa-history"></i> Lịch sử câu hỏi</a></li> <!-- Thêm mục lịch sử câu hỏi -->
        </ul>
        <form action="{{ route('logout') }}" method="POST" style="margin:1px;">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
        </form>
    </div>

    <!-- Nội dung -->
    <div class="content">
        <div class="container">
            <h1>📊 Báo cáo Thống Kê Hệ Thống</h1>

            @if(session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="stats">
                <div class="card">
                    <h3>{{ $usersCount }}</h3>
                    <p>Người dùng</p>
                </div>
                <div class="card">
                    <h3>{{ $vipCount }}</h3>
                    <p>Người dùng VIP</p>
                </div>
                <div class="card">
                    <h3>{{ $adminCount }}</h3>
                    <p>Quản trị viên</p>
                </div>
                <div class="card">
                    <h3>{{ $medicalDataCount }}</h3>
                    <p>Dữ liệu Y khoa</p>
                </div>
                <div class="card">
                    <h3>{{ $vipPackages }}</h3>
                    <p>Gói VIP</p>
                </div>
            </div>

            <!-- Người dùng mới -->
            <h2>🆕 Người dùng mới nhất</h2>
            <table>
                <tr>
                    <th>Người dùng</th>
                    <th>Email</th>
                    <th>Thời gian tạo</th>
                </tr>
                @foreach($latestUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
                @endforeach
            </table>

            <!-- Dữ liệu y khoa mới -->
            <h2>🧬 Dữ liệu y khoa mới nhất</h2>
            <table>
                <tr>
                    <th>Tựa đề</th>
                    <th>Ngày tạo</th>
                </tr>
                @foreach($latestMedicalData as $data)
                <tr>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

</body>
</html>
