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
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang['nama_barang'] }}</td>
                        <td>JNS</td>
                        <td>{{ $barang['jumlah_stok'] }}</td>
                        <td>{{ $barang['harga_satuan'] }}</td>
                        <td>{{ $barang['updated_at'] }}</td>
                    @endforeach
                </tbody>
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
