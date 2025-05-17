<?php

namespace App\Http\Controllers;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\Barang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesOrderDetailController extends Controller
{
    public function create($salesOrderId)
    {
        $salesOrder = SalesOrder::findOrFail($salesOrderId);
        $barang = Barang::all(); 
        
        return Inertia::render('SalesOrder/DetailCreate', [
            'salesOrder' => $salesOrder,
            'barang' => $barang,
        ]);
    }

    public function store(Request $request, $salesOrderId)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        SalesOrderDetail::create([
            'sales_order_id' => $salesOrderId,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect()->route('sales-order.show', $salesOrderId)
                         ->with('success', 'Detail sales Order berhasil ditambahkan.');
    }

    public function storeMultiple(Request $request, SalesOrder $salesOrder)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|integer|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_jual' => 'required|numeric|min:0',
        ]);

        foreach ($validated['items'] as $item) {
            SalesOrderDetail::create([
                'sales_order_id' => $salesOrder->id,
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'harga_jual' => $item['harga_jual'],
            ]);
        }

        $barang = Barang::findOrFail($item['barang_id']);
        $barang->update([
            'jumlah' => $barang->jumlah - $item['jumlah'],
        ]);

        $totalHarga = SalesOrderDetail::join('barang', 'sales_order_detail.barang_id', '=', 'barang.id')
        ->where('sales_order_detail.sales_order_id', $salesOrder->id)
        ->selectRaw('SUM(sales_order_detail.jumlah * barang.harga_jual) as total')
        ->value('total');
        

        $salesOrder->update([
            'totalHarga' => $totalHarga,
        ]);

        return redirect()->route('sales-order.show', $salesOrder->id)
                         ->with('success', 'Detail sales Order berhasil ditambahkan.');
    }
}