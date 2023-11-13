<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index()
    {
        $Barangs = Barang::all();

        return view('Stok.index', [
            'barangs' => $Barangs
        ]);
    }
}
