<?php

namespace App\Http\Controllers;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Barang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseOrderDetailController extends Controller
{
    public function create($purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($purchaseOrderId);
        $barang = Barang::all(); 
        
        return Inertia::render('PurchaseOrder/DetailCreate', [
            'purchaseOrder' => $purchaseOrder,
            'barang' => $barang,
        ]);
    }

    public function store(Request $request, $purchaseOrderId)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        PurchaseOrderDetail::create([
            'purchase_order_id' => $purchaseOrderId,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
        ]);

        return redirect()->route('purchase-order.show', $purchaseOrderId)
                         ->with('success', 'Detail Purchase Order berhasil ditambahkan.');
    }

    public function storeMultiple(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|integer|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
        ]);

        foreach ($validated['items'] as $item) {
            PurchaseOrderDetail::create([
                'purchase_order_id' => $purchaseOrder->id,
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'harga_beli' => $item['harga_beli'],
            ]);
        }

        $barang = Barang::findOrFail($item['barang_id']);
        $barang->update([
            'jumlah' => $barang->jumlah + $item['jumlah'],
        ]);

        $totalHarga = PurchaseOrderDetail::join('barang', 'purchase_order_detail.barang_id', '=', 'barang.id')
        ->where('purchase_order_detail.purchase_order_id', $purchaseOrder->id)
        ->selectRaw('SUM(purchase_order_detail.jumlah * barang.harga_beli) as total')
        ->value('total');
        

        $purchaseOrder->update([
            'totalHarga' => $totalHarga,
        ]);

        return redirect()->route('purchase-order.show', $purchaseOrder->id)
                         ->with('success', 'Detail Purchase Order berhasil ditambahkan.');
    }
}