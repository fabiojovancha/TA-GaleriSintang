<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pembayaran;

class PembayaranController extends Controller{
    public function index(){
        $pembayaran = Pembayaran::all();
    
        return inertia('Pembayaran/Index', [
            'pembayaran' => $pembayaran
        ]);    }
}