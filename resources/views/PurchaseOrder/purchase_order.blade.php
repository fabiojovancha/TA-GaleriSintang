<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Order #{{ $purchaseOrder->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Purchase Order #{{ $purchaseOrder->id }}</h2>
    <p><strong>Tanggal:</strong> {{ $purchaseOrder->tanggal }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($purchaseOrder->totalHarga, 0, ',', '.') }}</p>
    <p><strong>Tipe Pembayaran:</strong> {{ $purchaseOrder->pembayaran->tipePembayaran ?? 'N/A' }}</p>
    <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->nama ?? 'N/A' }}</p>

    <h4>Detail:</h4>
    <table>
        <thead>
            <tr>
                <th>ID Detail</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrder->details as $detail)
                <tr>
                    <td>{{ $detail->id }}</td>
                    <td>{{ $detail->barang->nama ?? 'N/A' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->barang->harga ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($detail->barang->harga ?? 0) * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
