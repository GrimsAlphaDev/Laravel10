@extends('layouts.apps')

@section('container')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">Buat Transaksi Pembelian</h6>

            <div class="bg-secondary rounded h-100 p-4">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="kode_transaksi" readonly
                        value="{{ $kdTrans }}">
                    <label for="floatingInput">Kode Transaksi</label>
                </div>

                {{-- table with insert for adding new barang --}}

                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Tambah
                    Barang</button>

                {{-- create table --}}

                <div class="table-responsive">
                    <table class="table table-hover" id="tableBarang">
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
                        <tbody id="tableBody"></tbody>
                        <footer>
                            <td colspan="4" class="text-end fw-bold">
                                Total Harga</td>
                            <td id="total_harga" class="fw-bold text-end">
                                Rp.
                            </td>
                        </footer>
                    </table>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Catatan" id="floatingTextarea2" style="height: 100px" name="catatan"></textarea>
                    <label for="floatingTextarea2">Catatan</label>
                </div>

                <div class="d-flex justify-content-end">
                    <button disabled id="submitButton" onclick="submitTrx()" type="submit"
                        class="btn btn-primary">Submit</button>
                </div>
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
                <div class="modal-body">

                    {{-- checkbox --}}
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck" checked="true">
                        <label class="form-check-label" for="flexSwitchCheck">Tambah Stok Barang</label>
                    </div>

                    <div id="modalBodyBarang">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="chooseBarang" name="nama_barang"
                                aria-label="Floating label select example">
                                <option selected>Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang['id'] }}">{{ $barang['nama_barang'] }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Barang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="jumlah_barang" id="floatingInput"
                                placeholder="Jumlah Barang" min="1">
                            <label for="floatingInput">Jumlah Barang</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="harga_satuan" id="floatingInput"
                                placeholder="Harga Satuan" min="1">
                            <label for="floatingInput">Harga Satuan</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="addMoreBarang" onclick="addBarang()" class="btn btn-primary">Save
                        changes</button>
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
                        <select class="form-select" id="floatingSelect" name="nama_barang" aria-label="Floating label select example">
                            <option selected>Pilih Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang['id'] }}">{{ $barang['nama_barang'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="jumlah_barang" id="floatingInput" placeholder="Jumlah Barang" min="1">
                        <label for="floatingInput">Jumlah Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="harga_satuan" id="floatingInput" placeholder="Harga Satuan" min="1">
                        <label for="floatingInput">Harga Satuan</label>
                    </div>
                `;
            } else {
                modalBodyBarang.innerHTML = `
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="nama_barang" id="floatingInput" placeholder="Nama Barang">
                        <label for="floatingInput">Nama Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="chooseBarang" name="jenis_barang" aria-label="Floating label select example">
                            <option selected>Pilih Jenis Barang</option>
                            @foreach ($jenisBarangs as $jenisBarang)
                                <option value="{{ $jenisBarang['id'] }}">{{ $jenisBarang['nama_jenis'] }}</option>
                            @endforeach
                        </select>
                        <label for="chooseBarang">Jenis Barang</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="jumlah_barang" id="floatingInput" placeholder="Jumlah Barang" min="1">
                        <label for="floatingInput">Jumlah Barang</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="harga_satuan" id="floatingInput" placeholder="Harga Satuan" min="1">
                        <label for="floatingInput">Harga Satuan</label>
                    </div>
                `;
            }
        });
    </script>


    <script>
        const tableBarang = document.getElementById('tableBarang');
        let subtotal = 0;
        let total = 0;
        let no = 1;
        let rowsCount = 0;
        let namaBarangArr = [];
        let idJenisArr = [];
        let jumlahStokArr = [];
        let hargaSatuanArr = [];
        let barangArr = [];
        let isNewData = false;

        function addBarang() {
            // get all the form value
            const nama_barang = document.getElementsByName('nama_barang')[0];
            const jenis_barang = document.getElementsByName('jenis_barang')[0];
            const jumlah_barang = document.getElementsByName('jumlah_barang')[0];
            const harga_satuan = document.getElementsByName('harga_satuan')[0];
            const chooseBarang = document.getElementById('chooseBarang');
            const tbody = document.querySelector('tbody');
            const kdTrans = document.getElementById('floatingInput').value;
            const totalHarga = document.getElementById('total_harga');
            // log all the value

            // add new row to table
            if (flexSwitchCheck.checked) {
                isNewData = false;

                // append to array
                barangArr.push({
                    id: chooseBarang.value,
                    // jumlah: jumlah_barang.value,
                    // harga: harga_satuan.value
                });

                const namaBarang = barangs.find(barang => barang.id == nama_barang.value);
                subtotal = jumlah_barang.value * harga_satuan.value;
                total = total + subtotal;
                totalHarga.innerHTML = `Rp. ${total}`;
                tbody.innerHTML += `
                    <tr>
                        <td>${no++}</td>
                        <td>${namaBarang.nama_barang}</td>
                        <td>${jumlah_barang.value}</td>
                        <td>${harga_satuan.value}</td>
                        <td>${subtotal}</td>
                        <td>
                            <button type="button" onclick="deleteRow()" class="btn btn-danger">Hapus</button>
                        </td>
                    </tr>
                `;
            } else {
                isNewData = true;
                // push nama barang to array
                namaBarangArr.push(nama_barang.value);
                // push id jenis to array
                idJenisArr.push(jenis_barang.value);
                // push jumlah stok to array
                jumlahStokArr.push(jumlah_barang.value);
                // push harga satuan to array
                hargaSatuanArr.push(harga_satuan.value);

                const jenisBarang = jenisBarangs.find(jenisBarang => jenisBarang.id == jenis_barang.value);
                subtotal = jumlah_barang.value * harga_satuan.value;
                console.log("subtotal:" + subtotal);
                total = total + subtotal;
                console.log("total: " + total);

                totalMoneyFormat = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(total);

                totalHarga.innerHTML = `Rp. ${totalMoneyFormat}`;

                subtotalMoneyFormat = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(subtotal);
                harga_satuanMoneyFormat = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(harga_satuan.value);

                tbody.innerHTML += `
                    <tr>
                        <td>${no++}</td>
                        <td>${nama_barang.value}</td>
                        <td>${jumlah_barang.value}</td>
                        <td>${harga_satuanMoneyFormat}</td>
                        <td
                            data-subtotal="${subtotal}" class = "text-end"
                        >${subtotalMoneyFormat}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="deleteRow()">Hapus</button>
                        </td>
                    </tr>
                `;
            }

            rowsCount++;
            clearForm();
            checkTable();

        }

        function clearForm() {
            const nama_barang = document.getElementsByName('nama_barang')[0];
            const jenis_barang = document.getElementsByName('jenis_barang')[0];
            const jumlah_barang = document.getElementsByName('jumlah_barang')[0];
            const harga_satuan = document.getElementsByName('harga_satuan')[0];

            nama_barang.value = '';
            jenis_barang.value = '';
            jumlah_barang.value = '';
            harga_satuan.value = '';

            // close the modal
            var myModalEl = document.getElementById('exampleModal');
            var modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();

        }

        function checkTable() {
            // check if table is empty
            const tbody = document.getElementById('tableBody');
            if (rowsCount > 0) {
                console.log('not empty');
                document.getElementById('submitButton').disabled = false;
            } else {
                console.log('empty');
                document.getElementById('submitButton').disabled = true;
            }
        }

        async function deleteRow() {
            // delete selected row
            const row = event.target.parentNode.parentNode;
            const tbody = document.querySelector('tbody');
            const totalHarga = document.getElementById('total_harga');
            const subtotal = row.children[4].getAttribute('data-subtotal');
            total = total - subtotal;
            totalMoneyFormat = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(total);
            totalHarga.innerHTML = `Rp. ${totalMoneyFormat}`;
            tbody.removeChild(row);
            no--;
            rowsCount--;
            checkTable();

        }
    </script>

    <script>
        function submitTrx() {
            // get all the table value 
            const tbody = document.querySelector('tbody');
            const jumlah_barang = document.getElementsByName('jumlah_barang[]');
            const harga_satuan = document.getElementsByName('harga_satuan');
            const total_harga = document.getElementById('total_harga');
            const catatan = document.getElementsByName('catatan')[0];
            const jenis_transaksi = document.getElementsByName('jenis_transaksi')[0];
            const kode_transaksi = document.getElementsByName('kode_transaksi')[0];

            if (isNewData) {

                // change data from stringify to formdata
                const formData = new FormData();
                formData.append('isnewdata', isNewData);
                formData.append('nama_barang', JSON.stringify(namaBarangArr));
                formData.append('id_jenis', JSON.stringify(idJenisArr));
                formData.append('jumlah_stok', JSON.stringify(jumlahStokArr));
                formData.append('harga_satuan', JSON.stringify(hargaSatuanArr));
                formData.append('total_harga', total_harga.innerHTML);
                formData.append('catatan', catatan.value);
                formData.append('jenis_transaksi', 'Pembelian');
                formData.append('kode_transaksi', kode_transaksi.value);


                // fetch
                $.ajax({
                    url: "{{ route('pembelian.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        // sweet alert 2
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil ditambahkan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "{{ route('pembelian.index') }}";
                        });

                        // redirect to index
                        window.location.href = "{{ route('pembelian.index') }}";
                    },
                    error: function(data) {
                        console.log(data);
                        alert('error');
                    }
                });
            } else {
                const formData = new FormData();
                formData.append('isnewdata', isNewData);
                formData.append('barang', JSON.stringify(barangArr));
                formData.append('total_harga', total_harga.innerHTML);
                formData.append('catatan', catatan.value);
                formData.append('jenis_transaksi', 'Pembelian');
                formData.append('kode_transaksi', kode_transaksi.value);


                $.ajax({
                    url: "{{ route('pembelian.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        // sweet alert 2
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil ditambahkan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "{{ route('pembelian.index') }}";
                        });

                        // redirect to index
                        window.location.href = "{{ route('pembelian.index') }}";
                    },
                    error: function(data) {
                        console.log(data);
                        alert('error');
                    }
                });
            }



        }

        //     const data = {
        //         id_barang: [],
        //         jumlah_barang: [],
        //         harga_satuan: [],
        //         total_harga: total_harga.innerHTML,
        //         catatan: catatan.value,
        //         jenis_transaksi: jenis_transaksi.value,
        //         kode_transaksi: kode_transaksi.value,
        //         _token: csrf
        //     };

        //     // get all the table value
        //     for (let i = 0; i < tbody.children.length; i++) {
        //         const row = tbody.children[i];
        //         data.id_barang.push(row.children[1].getAttribute('data-subtotal')); // Use getAttribute here
        //         data.jumlah_barang.push(row.children[2].getAttribute('data-subtotal')); // Use getAttribute here
        //         data.harga_satuan.push(row.children[3].innerHTML);
        //     }
    </script>
@endsection
