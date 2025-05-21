<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Sales Order Bulan {{ $month }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 10px;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
        }
        td.text-right {
            text-align: right;
        }
        td.text-center {
            text-align: center;
        }
        .summary {
            margin-top: 25px;
            font-size: 14px;
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PENJUALAN - BULAN {{ strtoupper($month) }}</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Customer</th>
                <th>Tipe Pembayaran</th>
                <!-- <th>Status</th> -->
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="text-center">{{ $order->so_id }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($order->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td class="text-right">Rp. {{ number_format($order->totalHarga, 0, ',', '.') }}</td>
                    <td>{{ $order->customer->nama ?? 'N/A' }}</td>
                    <td>{{ $order->pembayaran->tipePembayaran ?? 'N/A' }}</td>
                    <!-- <td class="text-center">{{ $order->status }}</td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data sales order untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Penjualan:</strong> 
        Rp. {{ number_format($orders->sum('totalHarga'), 0, ',', '.') }}
    </div>

</body>
</html>
