<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class KaryawanController extends Controller{
    public function index(){
        $karyawan = User::all();
    
        return inertia('Karyawan/Index', [
            'karyawan' => $karyawan
        ]);    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan')->with('success', 'Karyawan berhasil dihapus.');
    }
}