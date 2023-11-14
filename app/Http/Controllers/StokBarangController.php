<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index()
    {
        $Barangs = Barang::where('status', 'aktif')->orderBy('nama_barang')->get();

        $totalAsset = 0;
        $test[] = [];

        // convert hargasatuan to regular number
        foreach ($Barangs as $key => $Barang) {
            // delete "." and all the numbers after it
            $Barang->harga_satuan = preg_replace('/\..*/', '', $Barang->harga_satuan);
            $test[$key] = ($Barang->harga_satuan * $Barang->jumlah_stok);
            $totalAsset = $totalAsset + ($Barang->harga_satuan * $Barang->jumlah_stok);
        }


        return view('Stok.index', [
            'barangs' => $Barangs,
            'totalAsset' => $totalAsset
        ]);
    }
}
