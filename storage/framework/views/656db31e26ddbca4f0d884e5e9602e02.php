<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sales Order Bulan <?php echo e($month); ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Sales Order - <?php echo e($month); ?></h2>

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
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($order->tanggal)->locale('id')->isoFormat('MMMM YYYY')); ?></td>
                    <td>Rp. <?php echo e(number_format($order->totalHarga, 0, ',', '.')); ?></td>
                    <td><?php echo e($order->customer->nama ?? 'N/A'); ?></td>
                    <td><?php echo e($order->pembayaran->tipePembayaran ?? 'N/A'); ?></td>
                    <td><?php echo e($order->status); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="margin-top: 20px; font-size: 14px;">
        <strong>Total Penjualan: </strong> 
        Rp. <?php echo e(number_format($orders->sum('totalHarga'), 0, ',', '.')); ?>

    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\galeri_sintang_new\resources\views/monthlyPdf/sales_order_perbulan.blade.php ENDPATH**/ ?>