<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tipe Barang
        $tipeBarangIds = [];
        $tipeBarang = ['Gelang', 'Kalung', 'Cincin', 'Anting', 'Jam Tangan', 'Kacamata', 'Topi', 'Tas Kecil', 'Dompet', 'Pin Bros'];
        foreach ($tipeBarang as $nama) {
            $tipeBarangIds[] = DB::table('tipe_barang')->insertGetId([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Barang
        $barangIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $barangIds[] = DB::table('barang')->insertGetId([
                'nama' => "Barang $i",
                'deskripsi' => "Deskripsi $i",
                'harga_beli' => rand(10000, 50000),
                'harga_jual' => rand(60000, 100000),
                'jumlah' => rand(10, 100),
                'tipe_barang_id' => $tipeBarangIds[array_rand($tipeBarangIds)],
                'safety_stok' =>10,
                'lead_time' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Customer
        $customerIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $customerIds[] = DB::table('customer')->insertGetId([
                'nama' => "Customer $i",
                'alamat' => "Alamat $i",
                'noTelp' => '08' . rand(1000000000, 9999999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Supplier
        $supplierIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $supplierIds[] = DB::table('supplier')->insertGetId([
                'nama' => "Supplier $i",
                'alamat' => "Alamat Supplier $i",
                'noTelp' => '021' . rand(1000000, 9999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Purchase Order & Detail
        for ($i = 1; $i <= 10; $i++) {
            $purchaseOrderId = DB::table('purchase_order')->insertGetId([
                'po_id' => "PO00$i",
                'tanggal' => now()->subDays(rand(1, 30)),
                'status' => 'Proses',
                'totalHarga' => rand(200000, 500000),
                'supplier_id' => $supplierIds[array_rand($supplierIds)],
                'pembayaran_id' => rand(1,3), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($j = 0; $j < rand(1, 3); $j++) {
                DB::table('purchase_order_detail')->insert([
                    'jumlah' => rand(1, 10),
                    'harga' => rand(10000, 90000),
                    'barang_id' => $barangIds[array_rand($barangIds)],
                    'purchase_order_id' => $purchaseOrderId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 6. Sales Order & Detail
        for ($i = 1; $i <= 10; $i++) {
            $salesOrderId = DB::table('sales_order')->insertGetId([
                'so_id' => "SO00$i",
                'tanggal' => now()->subDays(rand(1, 30)),
                'status' => 'Selesai',
                'totalHarga' => rand(150000, 400000),
                'customer_id' => $customerIds[array_rand($customerIds)],
                'pembayaran_id' => rand(1,3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($j = 0; $j < rand(1, 3); $j++) {
                DB::table('sales_order_detail')->insert([
                    'jumlah' => rand(1, 5),
                    'harga' => rand(30000, 100000),
                    'barang_id' => $barangIds[array_rand($barangIds)],
                    'sales_order_id' => $salesOrderId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
