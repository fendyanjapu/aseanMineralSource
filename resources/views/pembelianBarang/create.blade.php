@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Pembelian Barang</h1>

    </div>

    <form action="{{ route('pembelianBarang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" placeholder="Kode Transaksi"
                            value="{{ old('kode_transaksi') }}">
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Barang</label>
                        <select class="form-control" name="barang_id">
                            <option value=""></option>
                            @foreach ($barangs as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah"
                            value="{{ old('jumlah') }}">
                        @error('jumlah')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Harga Satuan</label>
                        <input type="text" class="form-control" name="harga_satuan" id="harga_satuan"
                            placeholder="Harga Satuan" value="{{ old('harga_satuan') }}">
                        @error('harga_satuan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Total Harga</label>
                        <input type="text" class="form-control" name="total_harga" id="total_harga"
                            placeholder="Total Harga" value="{{ old('total_harga') }}" readonly>
                        @error('total_harga')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Bukti Transaksi</label>
                        <input type="file" class="form-control" name="bukti_transaksi" accept="image/*,application/pdf">
                        @error('bukti_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Tanggal"
                            value="{{ old('tanggal') }}">
                        @error('tanggal')
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
        $("#jumlah").keyup(function (event) {
            let jumlah = $('#jumlah').val();
            let harga_satuan = $('#harga_satuan').val();
            let int_harga_satuan = harga_satuan.replace(/,/g, "");
            let total_harga = jumlah * int_harga_satuan;
            $('#total_harga').val(total_harga);
            $('#total_harga').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });

        $("#harga_satuan").keyup(function (event) {
            let jumlah = $('#jumlah').val();
            let harga_satuan = $('#harga_satuan').val();
            let int_harga_satuan = harga_satuan.replace(/,/g, "");
            let total_harga = jumlah * int_harga_satuan;
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            $('#total_harga').val(total_harga);
            $('#total_harga').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });
    </script>

@endsection