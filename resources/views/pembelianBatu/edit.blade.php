@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pembelian Batu Dari Site</h1>

    </div>

    <form action="{{ route('pembelianBatu.update', ['pembelianBatu' => $pembelianBatu]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly
                            value="{{ $pembelianBatu->kode_transaksi }}">
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Site</label>
                        <select name="site_id" id="" class="form-control">
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $pembelianBatu->site_id ? 'selected' : '' }}>
                                    {{ $site->nama_site }}
                                </option>
                            @endforeach
                        </select>
                        @error('site_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Jetty</label>
                        <input type="text" class="form-control" name="nama_jetty" placeholder="Nama Jetty"
                            value="{{ $pembelianBatu->nama_jetty }}">
                        @error('nama_jetty')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal Rotasi</label><br>
                        <label>Dari</label>
                        <input type="date" class="form-control col-lg-3" name="tgl_rotasi_dari"
                            value="{{ $pembelianBatu->tgl_rotasi_dari }}">
                        @error('tgl_rotasi_dari')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <label>Sampai</label>
                        <input type="date" class="form-control col-lg-3" name="tgl_rotasi_sampai"
                            value="{{ $pembelianBatu->tgl_rotasi_sampai }}">
                        @error('tgl_rotasi_sampai')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jumlah Tonase</label>
                        <input type="text" class="form-control" name="jumlah_tonase" id="jumlah_tonase" placeholder="Jumlah Tonase"
                            value="{{ $pembelianBatu->jumlah_tonase }}">
                        @error('jumlah_tonase')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga"
                            value="{{ $pembelianBatu->harga }}">
                        @error('harga')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jetty</label>
                        <input type="text" class="form-control" name="jetty" id="jetty" placeholder="Jetty"
                            value="{{ $pembelianBatu->jetty }}">
                        @error('jetty')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Document dll</label>
                        <input type="text" class="form-control" name="document_dll" id="document_dll" placeholder="Document dll"
                            value="{{ $pembelianBatu->document_dll }}">
                        @error('document_dll')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Total Penjualan</label>
                        <input type="text" class="form-control" name="total_penjualan" id="total_penjualan" placeholder="Total Penjualan"
                            value="{{ $pembelianBatu->total_penjualan }}" readonly>
                        @error('total_penjualan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="#" onclick="self.history.back()" class="btn btn-danger">Batal</a>
            </div>

        </div>
    </form>

    <script>
        $("#jumlah_tonase").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });
        $("#harga").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });
        $("#jetty").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });
        $("#document_dll").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });

        function totalPenjualan() {
            let harga = $("#harga").val();
            let jetty = $("#jetty").val();
            let document_dll = $("#document_dll").val();
            let jumlah_tonase = $("#jumlah_tonase").val();
            let int_harga = harga.replace(/,/g, "");
            let int_jetty = jetty.replace(/,/g, "");
            let int_document_dll = document_dll.replace(/,/g, "");
            let int_jumlah_tonase = jumlah_tonase.replace(/,/g, "");

            let total_penjualan = (int_harga * int_jumlah_tonase) +
                                (int_jetty * int_jumlah_tonase) +
                                (int_document_dll * int_jumlah_tonase);

            $('#total_penjualan').val(total_penjualan);
            $('#total_penjualan').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection