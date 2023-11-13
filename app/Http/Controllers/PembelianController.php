<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi_pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $transaksi = Transaksi::where('jenis_transaksi', 'Pembelian')->get();

        // nowdate ddmmyyyy
        $nowDate = date('dmY');

        if($transaksi->isEmpty()){
            $kdTrans = 'TRXB0001' . $nowDate;
        } else {
            // get the last row of the table
            $lastRow = $transaksi->last();
    
            $kdTrans = 'TRXB' . sprintf("%04d", substr($lastRow->id, -4) + 1) . $nowDate;
        }

        $barangs = Barang::where('status', 'aktif')->get();

        $jenisBarangs = JenisBarang::where('status', 'aktif')->get();

        return view('transaksi_pembelian.create', [
            'kdTrans' => $kdTrans,
            'barangs' => $barangs,
            'jenisBarangs' => $jenisBarangs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
