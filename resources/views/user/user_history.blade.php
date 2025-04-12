<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Lịch sử hoạt động của bạn</h2>

    @if ($histories->isEmpty())
        <div class="alert alert-info">Chưa có hoạt động nào được ghi nhận.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Bạn là</th>
                    <th>Hành động</th>
                    <th>Chi tiết</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
                        <td>{{ $history->id }}</td>
                        <td>
                            @if ($history->performed_by == auth()->id())
                                Người thực hiện
                            @elseif ($history->target_user_id == auth()->id())
                                Người bị tác động
                            @endif
                        </td>
                        <td>{{ ucfirst($history->action) }}</td>
                        <td>{{ $history->details }}</td>
                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
