<?php

namespace App\Http\Controllers;
use App\Events\StokBarangMenipis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\TipeBarang;
use Inertia\Inertia;
use DB;

class BarangController extends Controller
{   
    public function index()
    {
        $startDate = now()->subDays(14)->startOfDay();
    
        $barangs = Barang::with('tipeBarang')->get()->map(function ($barang) use ($startDate) {    

            $totalQty = DB::table('sales_order_detail')
                ->join('sales_order', 'sales_order_detail.sales_order_id', '=', 'sales_order.id')
                ->where('sales_order_detail.barang_id', $barang->id)
                ->where('sales_order.tanggal', '>=', $startDate)
                ->sum('sales_order_detail.jumlah');
    
            $avgSales = $totalQty / 14;
    
            $rop = ($avgSales * $barang->lead_time) + $barang->safety_stock;
    
            $butuh_beli = $barang->jumlah <= $rop;
            $jumlah_beli = max(0, ceil(($avgSales * ($barang->lead_time + 7)) - $barang->jumlah));
    
            if ($butuh_beli) {
                $barangData = [
                    'id' => $barang->id,
                    'nama' => $barang->nama,
                    'jumlah' => $barang->jumlah,
                    'jumlah_beli' => max($jumlah_beli, 1),
                ];
                broadcast(new StokBarangMenipis($barangData));
            }
    
            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'jumlah' => $barang->jumlah,
                'harga_beli' => $barang->harga_beli,
                'harga_jual' => $barang->harga_jual,            
                'deskripsi' => $barang->deskripsi,
                'tipeBarang' => $barang->tipeBarang,
                'lead_time' => $barang->lead_time,
                'rop' => round($rop),                   
                'butuh_beli' => $butuh_beli,
                'jumlah_beli' => $butuh_beli ? max($jumlah_beli, 1) : 0,
            ];
        });
    
        return Inertia::render('Barang/Index', ['barang' => $barangs]);
    }
    
    

    public function create()
    {
        $tipeBarangs = TipeBarang::all();

        return Inertia::render('Barang/Create', [
            'tipeBarangs' => $tipeBarangs,
        ]);
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:100',
            'harga_beli'=> 'required|integer|min:0',
            'harga_jual'=> 'required|integer|min:0',
            'jumlah' => 'required|integer|min:0',
            'safety_stok' => 'required|integer|min:0',
            'lead_time' => 'required|integer|min:0',
            'tipe_barang_id' => 'required|int|min:0',
        ]);

        Barang::create($validated);

    return redirect()->route('barang')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        $tipeBarangs = TipeBarang::all();
        return inertia('Barang/Edit', [
            'barang' => $barang,
            'tipeBarang' => $tipeBarangs,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_beli'=> 'required|integer|min:0',
            'harga_jual'=> 'required|integer|min:0',
            'jumlah' => 'required|integer',
            'tipe_barang_id' => 'required|integer',
        ]);

        $barang = Barang::find($id);

        $barang->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'jumlah' => $request->jumlah,
            'tipe_barang_id' => $request->tipe_barang_id
        ]);
    
        return redirect()->route('barang')->with('success', 'Barang berhasil diupdate.');
    }
    
    

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang')->with('success', 'Barang berhasil dihapus.');
    }

}