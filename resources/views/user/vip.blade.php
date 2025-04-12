<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Gói VIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: #3f51b5; /* Màu xanh dương nhẹ */
            color: white;
            display: flex;
            flex-direction: column;
            padding: 24px 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
            position: relative;
            height: 100vh;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 30px;
            font-weight: 700;
            line-height: 1.4;
            color: #ffffff;
        }

        .sidebar .vip-label {
            background-color: #ffeb3b; /* Màu vàng nổi bật */
            color: #000;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a,
        .sidebar form button {
            display: block;
            background-color: #ffffff10;
            color: white;
            text-decoration: none;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            text-align: left;
            transition: background 0.3s ease, color 0.3s ease;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar form button:hover {
            background-color: #ffffff20;
            color: #2196f3;
        }

        .sidebar form button {
            background-color: #e74c3c;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans h-screen overflow-hidden flex">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <h2>🩺 Chatbot Y Học</h2>

        @if (Auth::check() && Auth::user()->isVip())
            <div class="vip-label">👑 Thành viên VIP</div>
        @endif

        {{-- Quay lại trang Chatbot --}}
        <a href="{{ route('user.chat') }}">⬅️ Quay lại hỏi Chatbot</a>

        @if (Auth::check())
            <form method="POST" action="{{ route('user.register_vip', ['id' => $userId ?? 0]) }}">
                @csrf
                <button type="submit">🌟 Mua gói VIP</button>
            </form>
        @else
            <a href="{{ route('login') }}">🔐 Đăng nhập để mua VIP</a>
        @endif

        <a href="{{ route('user.history') }}">📜 Lịch sử hỏi đáp</a>

        @if (Auth::check())
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">🚪 Đăng xuất</button>
            </form>
        @else
            <a href="{{ route('login') }}">🔑 Đăng nhập</a>
        @endif
    </div>

    {{-- NỘI DUNG GÓI VIP --}}
    <div class="flex-1 p-10 overflow-y-auto">
        <h1 class="text-4xl font-semibold text-indigo-700 text-center mb-10">Các Gói VIP</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($vipPackages as $package)
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <h2 class="text-xl font-bold text-indigo-600 text-center mb-2">{{ $package->name }}</h2>
                    <p class="text-gray-700 text-center">{{ $package->description }}</p>
                    <p class="text-center text-gray-600 mt-2">⏳ Thời gian: <strong>{{ $package->duration }} ngày</strong></p>

                    {{-- Ảnh thanh toán --}}
                    <div class="mt-4">
                        <img src="{{ asset('qr_.png') }}" alt="Thanh toán" class="rounded-lg mx-auto w-52 shadow">
                        <p class="text-center text-sm text-gray-600 mt-2">💳 Thanh toán tại đây</p>
                    </div>

                    <div class="mt-4 flex justify-center">
                    <form method="POST" action="{{ route('user.register_vip', ['id' => $package->id]) }}">
                        @csrf
                        <button type="submit"
                            class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Đăng ký gói này
                        </button>
                    </form>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
