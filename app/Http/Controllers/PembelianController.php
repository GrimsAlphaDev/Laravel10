<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
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

        if ($transaksi->isEmpty()) {
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

        if ($request->jenis_transaksi == 'Pembelian') {
            if ($request->isNewData) {
                $request->validate([
                    'jenis_transaksi' => 'required',
                    'id_jenis' => 'required',
                    'nama_barang' => 'required',
                    'jumlah_stok' => 'required',
                    'harga_satuan' => 'required',
                    'total_harga' => 'required',
                    'kode_transaksi' => 'required',
                ], [
                    'id_jenis.required' => 'Jenis Barang harus diisi',
                    'nama_barang.required' => 'Nama Barang harus diisi',
                    'jumlah_stok.required' => 'Jumlah Stok harus diisi',
                    'harga_satuan.required' => 'Harga Satuan harus diisi',
                    'total_harga.required' => 'Total Harga harus diisi',
                    'kode_transaksi.required' => 'Kode Transaksi harus diisi',
                ]);


                if (!isset($request->catatan)) {
                    $catatan = '';
                } else {
                    $catatan = $request->catatan;
                }

                $storedBarang = [];

                // decode all array send from form
                $request['id_jenis'] = json_decode($request['id_jenis']);
                $request['nama_barang'] = json_decode($request['nama_barang']);
                $request['jumlah_stok'] = json_decode($request['jumlah_stok']);
                $request['harga_satuan'] = json_decode($request['harga_satuan']);

                foreach ($request['nama_barang'] as $key => $value) {
                    // insert new barang to database and store the id   
                    $barang = Barang::create([
                        'nama_barang' => $request['nama_barang'][$key],
                        'id_jenis' => $request['id_jenis'][$key],
                        'jumlah_stok' => $request['jumlah_stok'][$key],
                        'harga_satuan' => $request['harga_satuan'][$key],
                        'status' => 'aktif',
                    ]);

                    $storedBarang[] = $barang->id;
                }

                // insert new transaksi to database
                $transaksi = Transaksi::create([
                    'kode_transaksi' => $request['kode_transaksi'],
                    'jenis_transaksi' => $request['jenis_transaksi'],
                    'catatan' => $catatan,
                ]);

                // get the id of $transaksi
                $idTransaksi = $transaksi->id;

                foreach ($storedBarang as $key => $value) {
                    $detailTrx = DetailTransaksi::create([
                        'id_transaksi' => $idTransaksi,
                        'id_barang' => $value,
                        'jumlah' => $request['jumlah_stok'][$key],
                    ]);
                }

                if (!$detailTrx) {
                    return json_encode([
                        'status' => 'error',
                        'message' => 'Data gagal disimpan'
                    ]);
                }

                return json_encode([
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan'
                ]);
            } else {
                $request->validate([
                    'jenis_transaksi' => 'required',
                    'tanggal' => 'required',
                    'id_barang' => 'required',
                    'jumlah' => 'required',
                    'harga' => 'required',
                    'total' => 'required',
                    'bayar' => 'required',
                    'kembalian' => 'required',
                    'id_pelanggan' => 'required',
                ]);
            }
        } else {
            $request->validate([
                'kode_transaksi' => 'required',
                'jenis_transaksi' => 'required',
                'id_barang' => 'required',
                'jumlah_stok' => 'required',
            ], [
                'id_jenis.required' => 'Jenis Barang harus diisi',
                'id_barang.required' => 'Nama Barang harus diisi',
                'jumlah_stok.required' => 'Jumlah Stok harus diisi',
                'kode_transaksi.required' => 'Kode Transaksi harus diisi',
            ]);

            // decode id_barang
            $request['id_barang'] = json_decode($request['id_barang']);

            if (!isset($request->catatan)) {
                $catatan = '';
            } else {
                $catatan = $request->catatan;
            }

            

            $insertTrx = Transaksi::create([
                'kode_transaksi' => $request->kode_transaksi,
                'jenis_transaksi' => $request->jenis_transaksi,
                'catatan' => $catatan,
            ]);

            // get id of transaksi
            $idTransaksi = $insertTrx->id;

            foreach ($request['id_barang'] as $key => $value) {
                // get stok barang from database
                $stokBarang = Barang::where('id', $value)->first();

                // update stok barang
                $updateStokBarang = Barang::where('id', $value)->update([
                    'jumlah_stok' => $stokBarang->jumlah_stok + $request['jumlah_stok'][$key],
                ]);

                if (!$updateStokBarang) {
                    return json_encode([
                        'status' => 'error',
                        'message' => 'Data gagal disimpan'
                    ]);
                }

                $insertDetailTrx = DetailTransaksi::create([
                    'id_transaksi' => $idTransaksi,
                    'id_barang' => $value,
                    'jumlah' => $request['jumlah_stok'][$key],
                ]);
            }

            if (!$insertDetailTrx) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Data gagal disimpan'
                ]);
            }

            return json_encode([
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ]);
        }
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
