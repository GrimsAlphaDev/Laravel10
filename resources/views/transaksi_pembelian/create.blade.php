@extends('layouts.apps')

@section('container')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Buat Transaksi Pembelian</h6>

            <div class="bg-secondary rounded h-100 p-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" readonly value="{{ $kdTrans }}">
                    <label for="floatingInput">Kode Transaksi</label>
                </div>

                {{-- table with insert for adding new barang --}}

                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Tambah
                    Barang</button>
                {{-- create table --}}

                <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover" id="stok">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <footer>
                                <td colspan="4" class="text-end fw-bold">
                                    Total Harga</td>
                                <td colspan="2" class="fw-bold"> 
                                    Rp.
                                </td>
                            </footer>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- add barang modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark" id="exampleModalLabel">Tambah Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body" >

                    {{-- checkbox --}}
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck" checked="true">
                        <label class="form-check-label" for="flexSwitchCheck">Gunakan Data Barang Yang Ada</label>
                    </div>

                    <div id="modalBodyBarang">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option selected>Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang['id'] }}">{{ $barang['nama_barang'] }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Barang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Barang">
                            <label for="floatingInput">Jumlah Barang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="floatingInput" placeholder="Harga Satuan">
                            <label for="floatingInput">Harga Satuan</label>
                        </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        const barangs = @json($barangs);
        const jenisBarangs = @json($jenisBarangs);
        const modalBodyBarang = document.getElementById('modalBodyBarang');
        const flexSwitchCheck = document.getElementById('flexSwitchCheck');

        flexSwitchCheck.addEventListener('click', function() {
            if (flexSwitchCheck.checked) {
                modalBodyBarang.innerHTML = `
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                            <option selected>Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang['id'] }}">{{ $barang['nama_barang'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Barang">
                        <label for="floatingInput">Jumlah Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Harga Satuan">
                        <label for="floatingInput">Harga Satuan</label>
                    </div>
                `;
            } else {
                modalBodyBarang.innerHTML = `
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Nama Barang">
                        <label for="floatingInput">Nama Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                            <option selected>Pilih Jenis Barang</option>
                            @foreach ($jenisBarangs as $jenisBarang)
                                <option value="{{ $jenisBarang['id'] }}">{{ $jenisBarang['nama_jenis'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Jenis Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Barang">
                        <label for="floatingInput">Jumlah Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Harga Satuan">
                        <label for="floatingInput">Harga Satuan</label>
                    </div>
                `;
            }
        });



    </script>
@endsection
