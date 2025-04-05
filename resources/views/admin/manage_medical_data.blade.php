<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dữ liệu Y Khoa - Chatbot Y Tế</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Định dạng tổng thể */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
            display: flex;
        }

        /* Sidebar */
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

        /* Nội dung chính */
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

        /* Bảng dữ liệu */
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
            word-wrap: break-word; /* Cho phép tự động xuống dòng nếu chữ quá dài */
        }
        th {
            background-color: #0073e6;
            color: white;
        }

        /* Các ô mô tả dài */
        td.description {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis; /* Hiển thị dấu ba chấm khi văn bản dài */
            cursor: pointer;
            position: relative;
        }

        /* Nút */
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            overflow: auto;
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 700px;
            max-height: 80vh; /* Chiều cao tối đa của modal */
            overflow-y: auto;  /* Cho phép cuộn dọc khi nội dung quá dài */
            word-wrap: break-word; /* Đảm bảo văn bản không tràn ra ngoài */
            height: auto; /* Cho phép chiều cao của modal thay đổi linh hoạt */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
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
            <h1>Danh sách Dữ liệu Y khoa</h1>
            <a href="{{ route('admin.create_medical_data') }}" class="btn btn-primary">Thêm Dữ liệu Y khoa</a>

            <!-- Bảng dữ liệu -->
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
                            <td class="description" onclick="showModal('{{ addslashes($data->description) }}')">{{ $data->description }}</td>
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

    <!-- Modal -->
    <div id="descriptionModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Mô tả chi tiết</h2>
            <p id="modalDescription"></p>
        </div>
    </div>

    <script>
        // Hiển thị modal với mô tả chi tiết
        function showModal(description) {
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('descriptionModal').style.display = "block";
        }

        // Đóng modal khi nhấn vào dấu "x"
        function closeModal() {
            document.getElementById('descriptionModal').style.display = "none";
        }

        // Đóng modal khi nhấn vào vùng ngoài modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('descriptionModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
