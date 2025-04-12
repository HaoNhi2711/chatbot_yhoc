<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Gói VIP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5em;
        }
        .card-body {
            background-color: white;
            padding: 20px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Đăng ký Gói VIP</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($vipPackages as $package)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $package->name }}</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Giá:</strong> {{ number_format($package->price, 0, ',', '.') }} VND</p>
                        <p><strong>Thời gian:</strong> {{ $package->duration }} ngày</p>
                        <p>{{ $package->description }}</p>
                        
                        <form method="POST" action="{{ route('user.register_vip', ['id' => $package->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Đăng ký Gói VIP</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
