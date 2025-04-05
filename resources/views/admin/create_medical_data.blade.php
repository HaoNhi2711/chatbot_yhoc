<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Dữ liệu Y khoa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Định dạng tổng thể */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 30px;
            font-weight: 600;
        }

        label {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        input, textarea {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: all 0.3s ease-in-out;
        }

        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
            background-color: #f1f7ff;
        }

        textarea {
            height: 180px;
            resize: none;
        }

        /* Nút submit */
        button {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        button:focus {
            outline: none;
        }

        /* Nút quay lại */
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 0;
            background-color: transparent;
            color: #007bff;
            font-size: 16px;
            text-decoration: underline;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .back-btn:hover {
            color: #0056b3;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thêm Dữ liệu Y khoa</h1>

        <form action="{{ route('admin.store_medical_data') }}" method="POST">
            @csrf
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" id="title" required placeholder="Nhập tiêu đề">

            <label for="description">Mô tả</label>
            <textarea name="description" id="description" required placeholder="Nhập mô tả"></textarea>

            <button type="submit">Thêm</button>
        </form>

        <a href="{{ route('admin.manage_medical_data') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
    </div>
</body>
</html>
