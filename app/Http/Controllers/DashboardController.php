<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SalesOrder;
use DB;

class DashboardController extends Controller{
    public function index(){
        $salesData = SalesOrder::select(
            DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as month'),
            DB::raw('SUM(totalHarga) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    return Inertia::render('Dashboard/Home', [
        'salesData' => $salesData
    ]);
}
}