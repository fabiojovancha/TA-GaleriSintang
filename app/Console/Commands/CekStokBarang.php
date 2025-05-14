<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CekStokBarang extends Command
{
    protected $signature = 'stok:cek';
    protected $description = 'Cek stok barang dan kirim notifikasi jika perlu restock';

    public function handle()
    {
        $admin = User::where('email', 'admin@example.com')->first(); // ganti sesuai admin

        Barang::all()->each(function ($barang) use ($admin) {
            $startDate = now()->subDays(14)->startOfDay();
            $totalQty = DB::table('sales_order_details')
                ->join('sales_orders', 'sales_order_details.sales_order_id', '=', 'sales_orders.id')
                ->where('sales_order_details.barang_id', $barang->id)
                ->where('sales_orders.created_at', '>=', $startDate)
                ->sum('sales_order_details.qty');

            $avgSales = $totalQty / 14;
            $rop = ($avgSales * $barang->lead_time) + $barang->safety_stock;
            $butuh_beli = $barang->stok <= $rop;

            if ($butuh_beli) {
                $jumlah_beli = ceil(($avgSales * ($barang->lead_time + 7)) - $barang->stok);
                $admin->notify(new StokBarangMenipis([
                    'nama' => $barang->nama_barang,
                    'stok' => $barang->stok,
                    'jumlah_beli' => max($jumlah_beli, 1)
                ]));

                $this->info("Notifikasi dikirim untuk: {$barang->nama_barang}");
            }
        });
    }
}
