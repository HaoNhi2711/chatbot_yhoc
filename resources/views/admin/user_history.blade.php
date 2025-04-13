<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Hỏi Đáp - {{ $user->name }}</title>
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
            display: flex;
            align-items: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .logout-btn:hover {
            background: linear-gradient(45deg, #c0392b, #a5281a);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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
            text-align: left;
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
        .no-response {
            color: #e74c3c; /* Màu đỏ cho "Chưa có trả lời" */
            font-style: italic;
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
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
    <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
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
    <div class="content">
        <div class="container">
            <h1>Lịch Sử Hỏi Đáp của {{ $user->name }}</h1>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (empty($messages) || count($messages) === 0)
                <div class="alert">
                    Người dùng này chưa có lịch sử hỏi đáp.
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Câu hỏi</th>
                            <th>Trả lời</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td>{{ $message->question ?? 'Không có câu hỏi' }}</td>
                                <td>
                                    @if ($message->response)
                                        {{ $message->response }}
                                    @else
                                        <span class="no-response">Chưa có trả lời</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($message->created_at)->format('H:i d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
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