<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Order #{{ $salesOrder->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- Header seperti contoh gambar -->
    <div class="header">
        GALERI SINTANG.IND<br>
        KOMPLEKS PASAR RAYA BLOK B NO.23 KELURAHAN TANJUNG PURI SINTANG<br>
    </div>

    <div class="title">
        SALES ORDER #{{ $salesOrder->so_id }}
    </div>

    <!-- Informasi Umum -->
    <div class="info">
        <p><strong>Tanggal:</strong> {{ $salesOrder->tanggal }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($salesOrder->totalHarga, 0, ',', '.') }}</p>
        <p><strong>Tipe Pembayaran:</strong> {{ $salesOrder->pembayaran->tipePembayaran ?? 'N/A' }}</p>
        <p><strong>Customer:</strong> {{ $salesOrder->customer->nama ?? 'N/A' }}</p>
    </div>

    <!-- Tabel Detail Barang -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesOrder->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->barang->nama ?? 'N/A' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->barang->harga_jual ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($detail->barang->harga_jual ?? 0) * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Hormat Kami, Galeri Sintang<br><br><br>
        ____________________
    </div>

</body>
</html>
