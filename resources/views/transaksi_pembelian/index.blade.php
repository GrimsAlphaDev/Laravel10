@extends('layouts.apps')

@section('custom-css')
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('container')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Transaksi Pembelian</h6>
            {{-- create insert new transaction button --}}
            <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-4">Tambah Transaksi</a>
            {{-- create table --}}
            <div class="table-responsive"> 
            <table class="table table-hover" id="stok">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Kode Transaksi</th>
                        <th>Jenis Transaksi</th>
                        <th>Biaya Jasa</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
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
