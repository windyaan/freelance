<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Freelancer & Profit</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: left; }
        th { background: #f2f2f2; }

        .profit-box {
            border: 2px solid #333;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Laporan Freelancer & Profit</h2>

    {{-- Daftar semua user --}}
    <h3>Daftar Users</h3>
    <table>
        <thead>
            <tr>
                <th>Role</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Terdaftar</th>
                </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Rekap order yang sudah lunas --}}
    <h3>Order Lunas</h3>
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($paidOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>Rp{{ number_format($order->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada data order lunas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Order Belum Lunas (DP) --}}
    <h3>Order Belum Lunas / DP</h3>
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unpaidOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>Rp{{ number_format($order->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada data order DP.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Total profit semua order lunas --}}
    <h3>Total Profit (Order Lunas)</h3>
    <div class="profit-box">
        Rp{{ number_format($totalProfit, 0, ',', '.') }}
    </div>
</body>
</html>
