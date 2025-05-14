<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Inertia\Inertia;
use DB;

class SupplierController extends Controller
{   
    public function index(){

        $supplier = Supplier::all();
    
        return inertia('Supplier/Index', [
            'supplier' => $supplier
        ]);
    }
    public function create()
    {
        return Inertia::render('Supplier/Create');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat'=> 'required|string|max:255',
            'noTelp' => 'required|string|max:15',

        ]);

        Supplier::create($validated);

    return redirect()->route('supplier')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return inertia('Supplier/Edit', [
            'supplier' => $supplier,
        ]);
    }


    public function update(Request $request, $id)
    {
        \Log::info('Updating supplier: ' . json_encode($request->all()));
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat'=> 'required|string|max:255',
            'noTelp' => 'required|string|max:15',
        ]);

        $supplier = Supplier::find($id);

        $supplier->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'noTelp' => $request->noTelp,
        ]);
    
        return redirect()->route('supplier');
    }
    
    
    

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier')->with('success', 'Supplier berhasil dihapus.');
    }

}