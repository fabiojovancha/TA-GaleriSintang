<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sales Order Bulan {{ $month }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Sales Order - {{ $month }}</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Customer</th>
                <th>Tipe Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->locale('id')->isoFormat('MMMM YYYY') }}</td>
                    <td>Rp. {{ number_format($order->totalHarga, 0, ',', '.') }}</td>
                    <td>{{ $order->customer->nama ?? 'N/A' }}</td>
                    <td>{{ $order->pembayaran->tipePembayaran ?? 'N/A' }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px; font-size: 14px;">
        <strong>Total Penjualan: </strong> 
        Rp. {{ number_format($orders->sum('totalHarga'), 0, ',', '.') }}
    </div>

</body>
</html>
