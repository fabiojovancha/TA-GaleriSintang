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
}