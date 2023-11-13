@extends('layouts.apps')

@section('custom-css')
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('container')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Jenis Barang</h6>
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah
                Jenis Barang</button>
            {{-- create table --}}
            <div class="table-responsive">
                <table class="table table-hover" id="stok">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Jenis Barang</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($jenisB as $jns)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jns->nama_jenis }}</td>
                            <td>{{ $jns->updated_at }}</td>
                            <td>
                                {{-- inline edit and delete button --}}
                                <div class="d-inline">
                                    <form action="{{ route('jenis.destroy', $jns->id) }}" method="POST" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            onclick="return confirm('Yakin Ingin Menghapus Data ini ? ')">Delete</button>
                                    </form>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $jns->id }}">Edit</button>
                                </div>


                            </td>
                        </tr>
                        <!-- Edit Jenis -->
                        <div class="modal fade" id="editModal{{ $jns->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-dark" id="editModalLabel">Tambah Jenis Barang</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('jenis.update' , $jns->id) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="modal-body">
                                            {{-- form --}}
                                            <div class="mb-3">
                                                <label for="jenis" class="form-label">Jenis Barang</label>
                                                <input type="text" class="form-control" id="jenis" name="jenis"
                                                    value="{{ $jns->nama_jenis }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create New Jenis -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark" id="exampleModalLabel">Tambah Jenis Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jenis.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- form --}}
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Barang</label>
                            <input type="text" class="form-control" id="jenis" name="jenis">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
