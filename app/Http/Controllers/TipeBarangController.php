<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipeBarang;
use Inertia\Inertia;
use DB;

class TipeBarangController extends Controller
{   
    public function index(){

        $tipeBarang = TipeBarang::all();
    
        return inertia('TipeBarang/Index', [
            'tipeBarang' => $tipeBarang
        ]);
    }
    public function create()
    {
        return Inertia::render('TipeBarang/Create');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        tipeBarang::create($validated);

    return redirect()->route('tipeBarang')->with('success', 'Tipe Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $tipeBarang = TipeBarang::find($id);
        return inertia('TipeBarang/Edit', [
            'tipeBarang' => $tipeBarang,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $tipeBarang = TipeBarang::find($id);

        $tipeBarang->update([
            'nama' => $request->nama,
        ]);
    
        return redirect()->route('tipeBarang');
    }
    
    
    

    public function destroy($id)
    {
        $tipeBarang = TipeBarang::findOrFail($id);
        $tipeBarang->delete();

        return redirect()->route('tipeBarang')->with('success', 'TipeBarang berhasil dihapus.');
    }

}