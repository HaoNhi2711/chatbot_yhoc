<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Dữ liệu Y khoa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: 600;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            color: #555;
            font-weight: 500;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: border-color 0.3s ease-in-out;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: #6c63ff;
            outline: none;
        }
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #6c63ff;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            font-weight: 600;
        }
        button:hover {
            background-color: #5a54d9;
        }
        .button-back {
            width: auto;
            background-color: transparent;
            color: #6c63ff;
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid #6c63ff;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
            font-weight: 500;
        }
        .button-back:hover {
            background-color: #6c63ff;
            color: #fff;
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group:last-child {
            margin-bottom: 0;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        .back-btn {
            font-size: 16px;
            text-decoration: none;
            color: #6c63ff;
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
        }
        .back-btn i {
            margin-right: 8px;
        }
        .back-btn:hover {
            text-decoration: underline;
            color: #5a54d9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sửa Dữ liệu Y khoa</h1>

        <form action="{{ route('admin.update_medical_data', $medicalData->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ $medicalData->title }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" required>{{ $medicalData->description }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Cập nhật</button>
        </form>

        <!-- Nút quay lại -->
        <a href="{{ route('admin.manage_medical_data') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
</body>
</html>
