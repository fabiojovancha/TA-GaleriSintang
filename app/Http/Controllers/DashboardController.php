<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use App\Models\Barang;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $salesData = SalesOrder::select(
            DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as month'),
            DB::raw('SUM(totalHarga) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $totalBarang = Barang::count();

        $totalPO = PurchaseOrder::count();

        $totalSO = SalesOrder::count();

        $barangHampirHabis = Barang::where('jumlah', '<=', 5)->get(['id', 'nama', 'jumlah']);

        // Recent Purchase Order + supplier name via join
        $recentPO = PurchaseOrder::select('purchase_order.id','purchase_order.po_id', 'supplier.nama as supplier', 'purchase_order.status')
            ->join('supplier', 'purchase_order.supplier_id', '=', 'supplier.id')
            ->orderBy('purchase_order.created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent Sales Order + customer nama via join
        $recentSO = SalesOrder::select('sales_order.id','sales_order.so_id', 'customer.nama as customer', 'sales_order.status')
            ->join('customer', 'sales_order.customer_id', '=', 'customer.id')
            ->orderBy('sales_order.created_at', 'desc')
            ->limit(5)
            ->get();

        $topSelling = DB::table('sales_order_detail')
            ->join('barang', 'sales_order_detail.barang_id', '=', 'barang.id')
            ->select('barang.nama', DB::raw('SUM(sales_order_detail.jumlah) as total_terjual'))
            ->groupBy('barang.nama')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard/Home', [
            'salesData' => $salesData,
            'totalBarang' => $totalBarang,
            'totalPO' => $totalPO,
            'totalSO' => $totalSO,
            'barangHampirHabis' => $barangHampirHabis,
            'recentPO' => $recentPO,
            'recentSO' => $recentSO,
            'topSelling' => $topSelling,
        ]);
    }
}
