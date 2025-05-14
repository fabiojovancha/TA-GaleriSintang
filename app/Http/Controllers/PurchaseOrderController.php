<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PurchaseOrder;
use App\Models\Barang;
use App\Models\PurchaseOrderDetail;
use App\Models\Pembayaran;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrder = PurchaseOrder::with('pembayaran', 'supplier')
        ->where('status', 'Process')
        ->get();

        return Inertia::render('PurchaseOrder/Index', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function selesai()
    {
        $purchaseOrder = PurchaseOrder::with('pembayaran', 'supplier')
        ->where('status', 'Selesai')
        ->get();

        return Inertia::render('PurchaseOrder/Done', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }


    public function create()
    {
        $pembayaran = Pembayaran::all();
        $supplier = Supplier::all();
        $barang = Barang::all();
        return Inertia::render('PurchaseOrder/Create', [
            'pembayaran' => $pembayaran,
            'supplier' => $supplier,
            'barang' => $barang,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|max:10',
            'totalHarga' => 'required|integer|min:0',
            'pembayaran_id' => 'required|exists:pembayaran,id',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:barang,id',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.harga_beli' => 'required|integer|min:0',
        ]);
    
        DB::beginTransaction();
    
        try {
            $po = PurchaseOrder::create([
                'supplier_id' => $validated['supplier_id'],
                'tanggal' => $validated['tanggal'],
                'pembayaran_id' => $validated['pembayaran_id'],
                'status' => $validated['status'],
                'totalHarga' => $request->input('totalHarga'),
            ]);
            
            foreach ($validated['details'] as $detail) {
                $po->details()->create([
                    'barang_id' => $detail['barang_id'],
                    'jumlah' => $detail['jumlah'],
                    'harga_beli' => $detail['harga_beli'],
                ]);

                $barang = Barang::findOrFail($detail['barang_id']);
                $barang->update([
                    'jumlah' => $barang->jumlah + $detail['jumlah'],
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('purchase-order')
                ->with('success', 'Purchase Order berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['pembayaran', 'supplier', 'details.barang'])->findOrFail($id);
        
        return Inertia::render('PurchaseOrder/Show', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function exportPdf($id)
    {
        $purchaseOrder = PurchaseOrder::with(['details.barang', 'pembayaran', 'supplier'])->findOrFail($id);

        $pdf = Pdf::loadView('PurchaseOrder.purchase_order', compact('purchaseOrder'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('purchaseOrder_'.$id.'.pdf');
    }

    public function updateStatus(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        if ($purchaseOrder->status === 'Process') {
            $purchaseOrder->status = 'Selesai';
            $purchaseOrder->save();
        }

        return redirect()->route('purchase-order');
    }

}
