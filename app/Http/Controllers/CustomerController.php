<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Inertia\Inertia;
use DB;

class CustomerController extends Controller
{   
    public function index(){

        $customer = Customer::all();
    
        return inertia('Customer/Index', [
            'customer' => $customer
        ]);
    }
    public function create()
    {
        return Inertia::render('Customer/Create');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat'=> 'required|string|max:255',
            'noTelp' => 'required|string|max:15',

        ]);

        customer::create($validated);

    return redirect()->route('customer')->with('success', 'Customer berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $customer = customer::find($id);
        return inertia('Customer/Edit', [
            'customer' => $customer,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat'=> 'required|string|max:255',
            'noTelp' => 'required|string|max:15',
        ]);

        $customer = Customer::find($id);

        $customer->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'noTelp' => $request->noTelp,
        ]);
    
        return redirect()->route('customer');
    }
    
    
    

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer')->with('success', 'Customer berhasil dihapus.');
    }

}