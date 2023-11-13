<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;
use PDO;
use RealRashid\SweetAlert\Facades\Alert;

class JenisBarangController extends Controller
{
    public function index (){

        $jenisB = JenisBarang::where('status','aktif')->orderBy('updated_at', 'desc')->get();

        return view('jenis.index', [
            'jenisB' => $jenisB
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'jenis' => 'required'
        ]);

        $insertJenis = JenisBarang::create([
            'nama_jenis' => $request->jenis
        ]);

        if(!$insertJenis){
            return redirect()->back()->with('error', 'Jenis barang gagal ditambahkan');
        }

        return redirect()->back()->with('success', 'Jenis barang berhasil ditambahkan');
    }

    public function update ($id, Request $request){
        $request->validate([
            'jenis' => 'required'
        ]);

        $updateJenis = JenisBarang::where('id', $id)->update([
            'nama_jenis' => $request->jenis
        ]);

        if(!$updateJenis){
            return redirect()->route('jenis.index')->with('error', 'Jenis barang gagal diupdate');
        }

        return redirect()->route('jenis.index')->with('success', 'Jenis barang berhasil diupdate');
    }

    public function delete($id){
        
        $deleteJenis = JenisBarang::where('id', $id)->update([
            'status' => 'nonaktif'
        ]);

        if(!$deleteJenis){
            return redirect()->route('jenis.index')->with('error', 'Jenis barang gagal dihapus');
        }

        return redirect()->route('jenis.index')->with('success', 'Jenis barang berhasil dihapus');
    }
}
