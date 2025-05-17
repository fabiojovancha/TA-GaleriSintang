<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderDetailController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalesOrderDetailController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TipeBarangController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', [DashboardController::class, 'index']);
Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

Route::get('karyawan',[KaryawanController::class, 'index'])->name('karyawan');

Route::get('/barang',[BarangController::class,'index'])->name('barang');
Route::get('/barang/create',[BarangController::class,'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{id}/edit',[BarangController::class,'edit'])->name('barang.edit');
Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}',[BarangController::class,'destroy'])->name('barang.destroy');

Route::get('/tipeBarang',[TipeBarangController::class,'index'])->name('tipeBarang');
Route::get('/tipeBarang/create',[TipeBarangController::class,'create'])->name('tipeBarang.create');
Route::post('/tipeBarang', [TipeBarangController::class, 'store'])->name('tipeBarang.store');
Route::get('/tipeBarang/{id}/edit',[TipeBarangController::class,'edit'])->name('tipeBarang.edit');
Route::put('/tipeBarang/{tipeBarang}', [TipeBarangController::class, 'update'])->name('tipeBarang.update');
Route::delete('/tipeBarang/{id}',[TipeBarangController::class,'destroy'])->name('tipeBarang.destroy');

Route::get('/supplier',[SupplierController::class,'index'])->name('supplier');
Route::get('/supplier/create',[SupplierController::class,'create'])->name('supplier.create');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/{id}/edit',[SupplierController::class,'edit'])->name('supplier.edit');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}',[SupplierController::class,'destroy'])->name('supplier.destroy');

Route::get('/customer',[CustomerController::class,'index'])->name('customer');
Route::get('/customer/create',[CustomerController::class,'create'])->name('customer.create');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/{id}/edit',[CustomerController::class,'edit'])->name('customer.edit');
Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}',[CustomerController::class,'destroy'])->name('customer.destroy');

Route::get('/pembayaran',[PembayaranController::class,'index'])->name('pembayaran');

// Route::get('/purchase',[PurchaseOrderController::class,'index'])->name('purchase');
Route::get('/purchase-order', [PurchaseOrderController::class, 'index'])->name('purchase-order');
Route::get('/purchase-order-done', [PurchaseOrderController::class, 'selesai'])->name('purchase-order-done');
Route::get('/purchase-order/create', [PurchaseOrderController::class, 'create'])->name('purchase-order.create');
Route::post('/purchase-order', [PurchaseOrderController::class, 'store'])->name('purchase-order.store');
Route::get('/purchase-order/{id}', [PurchaseOrderController::class, 'show'])->name('purchase-order.show');

Route::get('/purchase-order/{purchaseOrderId}/detail/create', [PurchaseOrderDetailController::class, 'create'])->name('purchase-order-detail.create');
Route::post('/purchase-order/{purchaseOrderId}/detail', [PurchaseOrderDetailController::class, 'store'])->name('purchase-order-detail.store');
Route::post('/purchase-order/{purchaseOrder}/details/store-multiple', [PurchaseOrderDetailController::class, 'storeMultiple'])->name('purchase-order-detail.store-multiple');
Route::delete('/purchase-order/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase-order.destroy');
Route::get('/purchase-order/{id}/pdf', [PurchaseOrderController::class, 'exportPdf'])->name('purchase-order.pdf');
Route::put('/purchase-order/{id}/update-status', [PurchaseOrderController::class, 'updateStatus'])->name('purchase-order.update-status');

Route::get('/sales-order', [SalesOrderController::class, 'index'])->name('sales-order');
Route::get('/sales-order/create', [SalesOrderController::class, 'create'])->name('sales-order.create');
Route::post('/sales-order', [SalesOrderController::class, 'store'])->name('sales-order.store');
Route::get('/sales-order/{id}', [SalesOrderController::class, 'show'])->name('sales-order.show');

Route::get('/sales-order/{salesOrderId}/detail/create', [SalesOrderDetailController::class, 'create'])->name('sales-order-detail.create');
Route::post('/sales-order/{salesOrderId}/detail', [SalesOrderDetailController::class, 'store'])->name('sales-order-detail.store');
Route::post('/sales-order/{salesOrder}/details/store-multiple', [SalesOrderDetailController::class, 'storeMultiple'])->name('sales-order-detail.store-multiple');
Route::get('/sales-order/{id}/pdf', [SalesOrderController::class, 'exportPdf'])->name('sales-order.pdf');
Route::put('/sales-order/{id}/update-status', [SalesOrderController::class, 'updateStatus'])->name('sales-order.update-status');
Route::get('/sales-order-done', [SalesOrderController::class, 'selesai'])->name('sales-order-done');
Route::get('/monthly-sales-order', [SalesOrderController::class, 'monthly'])->name('monthly-sales-order');
Route::get('/monthly-sales-order/export-pdf/{month}', [SalesOrderController::class, 'monthlyPdf'])->name('sales-order.monthly-pdf');



// Route::get('/',function(){return Inertia::render('Welcome',[
//     'canLogin' => Route::has('login'),
//     'canRegister' => Route::has('register'),
//     'laravelVersion' =>Application::VERSION,
//     'phpVersion' => PHP_VERSION,
// ]);
// });

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is OK!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
// Route::middleware(['auth', 'role:owner'])->group(function () {
//     Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
//     Route::post('/register', [RegisteredUserController::class, 'store']);
// });

require __DIR__.'/auth.php';
