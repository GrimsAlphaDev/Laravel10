@extends('layouts.apps')

@section('custom-css')
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('container')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Stok Barang</h6>
            <table class="table table-hover" id="stok">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Jumlah Stok</th>
                        <th>Harga Satuan</th>
                        <th>Sub Total</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang['nama_barang'] }}</td>
                            <td>{{ $barangs[0]->jenis->nama_jenis }}</td>
                            <td>{{ $barang['jumlah_stok'] }}</td>
                            <td>Rp. {{ number_format($barang['harga_satuan'], 2, ',', '.') }}</td>
                            <td class="text-end">Rp. {{ number_format($barang['jumlah_stok'] * $barang['harga_satuan'], 2, ',', '.') }}</td>
                            <td>{{ $barang['updated_at'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-center fw-bold">TOTAL ASET</th>
                        <th colspan="2">
                            {{ 
                                // currency
                                'Rp. ' . number_format($totalAsset, 2, ',', '.')
                                }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#spinner').hide();
            new DataTable('#stok');
        });
    </script>
@endsection
