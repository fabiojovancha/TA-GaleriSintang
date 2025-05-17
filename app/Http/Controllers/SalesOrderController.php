<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SalesOrder;
use App\Models\Barang;
use App\Models\SalesOrderDetail;
use App\Models\Pembayaran;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class SalesOrderController extends Controller
{
    public function index()
    {
        $salesOrder = SalesOrder::with('pembayaran', 'customer')
        ->where('status', 'Process')
        ->get();

        return Inertia::render('SalesOrder/Index', [
            'salesOrder' => $salesOrder
        ]);
    }

    public function selesai()
    {
        $salesOrder = SalesOrder::with('pembayaran', 'customer')
        ->where('status', 'Selesai')
        ->get();

        return Inertia::render('SalesOrder/Index', [
            'salesOrder' => $salesOrder
        ]);
    }

    public function create()
    {
        $pembayaran = Pembayaran::all();
        $customer = Customer::all();
        $barang = Barang::all();

        return Inertia::render('SalesOrder/Create', [
            'pembayaran' => $pembayaran,
            'customer' => $customer,
            'barang' => $barang,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:supplier,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|max:10',
            'totalHarga' => 'required|integer|min:0',
            'pembayaran_id' => 'required|exists:pembayaran,id',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:barang,id',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.harga_jual' => 'required|integer|min:0',
        ]);
    
        DB::beginTransaction();
    
        try {
            $so = SalesOrder::create([
                'customer_id' => $validated['customer_id'],
                'tanggal' => $validated['tanggal'],
                'pembayaran_id' => $validated['pembayaran_id'],
                'status' => $validated['status'],
                'totalHarga' => $request->input('totalHarga'),
            ]);
            
            foreach ($validated['details'] as $detail) {
                $so->details()->create([
                    'barang_id' => $detail['barang_id'],
                    'jumlah' => $detail['jumlah'],
                    'harga_jual' => $detail['harga_jual'],
                ]);

                $barang = Barang::findOrFail($detail['barang_id']);
                $barang->update([
                    'jumlah' => $barang->jumlah - $detail['jumlah'],
                ]);
                
            }
    
            DB::commit();
    
            return redirect()->route('sales-order')
                ->with('success', 'Sales Order berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $salesOrder = SalesOrder::with(['pembayaran', 'customer', 'details.barang'])->findOrFail($id);
        
        return Inertia::render('SalesOrder/Show', [
            'salesOrder' => $salesOrder
        ]);
    }

    public function exportPdf($id)
    {
        $salesOrder = SalesOrder::with(['details.barang', 'pembayaran', 'customer'])->findOrFail($id);

        $pdf = Pdf::loadView('salesOrder.sales_order', compact('salesOrder'))
                ->setPaper('a4', 'portrait');
        return $pdf->stream('salesOrder_'.$id.'.pdf');
    }

    public function updateStatus(Request $request, $id)
    {
        $salesOrder = SalesOrder::findOrFail($id);

        if ($salesOrder->status === 'Process') {
            $salesOrder->status = 'Selesai';
            $salesOrder->save();
        }

        return redirect()->route('sales-order');
    }
    public function monthly()
    {
        $salesOrders = SalesOrder::with(['customer', 'pembayaran'])
            ->where('status', 'Selesai')
            ->get();

        return Inertia::render('PenjualanBulanan/Index', [
            'salesOrder' => $salesOrders,
        ]);
    }

    public function monthlyPdf($month)
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $start = $date->startOfMonth()->format('Y-m-d');
        $end = $date->endOfMonth()->format('Y-m-d');
    
        $orders = SalesOrder::with(['customer', 'pembayaran'])
            ->where('status', 'Selesai') 
            ->whereBetween('tanggal', [$start, $end])
            ->get();
    
        setlocale(LC_TIME, 'id_ID.utf8');
        \Carbon\Carbon::setLocale('id');
        $monthName = $date->translatedFormat('F Y');
    
        $pdf = Pdf::loadView('monthlyPdf.sales_order_perbulan', [
            'orders' => $orders,
            'month' => $monthName
        ]);
    
        return $pdf->stream("sales-order-$month.pdf");
    }
}
