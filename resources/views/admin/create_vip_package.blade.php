<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Gói VIP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #0066cc;
            --primary-dark: #004c99;
            --gray-bg: #f4f6f8;
            --card-bg: #fff;
            --text-color: #333;
            --border-color: #ddd;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--gray-bg);
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--primary);
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .brand {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 40px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar ul li a:hover {
            background-color: #0052a3;
        }

        .logout-btn {
            margin-top: auto;
            padding: 12px 20px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .logout-btn i {
            margin-right: 8px;
        }

        /* Nội dung */
        .content {
            margin-left: 260px;
            padding: 50px;
            flex-grow: 1;
        }

        .container {
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 16px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: var(--primary-dark);
            margin-bottom: 30px;
            font-size: 26px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-size: 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus,
        textarea:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 5px rgba(0, 102, 204, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
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
            <li><a href="{{ route('admin.user_histories') }}"><i class="fas fa-history"></i> Lịch sử câu hỏi</a></li> <!-- Thêm mục lịch sử câu hỏi -->
        </ul>
        <a href="{{ route('login') }}" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <h1>Thêm Gói VIP</h1>
            <form action="{{ route('admin.store_vip_package') }}" method="POST">
                @csrf

                <label for="name">Tên Khách Hàng</label>
                <input type="text" name="name" id="name" placeholder="Nhập tên khách hàng..." required>

                <label for="description">Mô Tả</label>
                <textarea name="description" id="description" placeholder="Mô tả chi tiết..." required></textarea>

                <label for="price">Giá (VNĐ)</label>
                <input type="number" name="price" id="price" placeholder="Nhập giá..." required min="0">

                <label for="duration">Thời gian (ngày)</label>
                <input type="number" name="duration" id="duration" placeholder="Số ngày..." required min="1">

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('admin.manage_vip_packages') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
