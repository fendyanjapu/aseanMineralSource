@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Operasional Asean Mineral Source</h1>

    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('operasional.update', ['operasional' => $operasional]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly value="{{ $operasional->kode_transaksi }}">
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal</label><br>
                        <input type="date" class="form-control col-lg-3" name="tanggal" id="tanggal"
                            value="{{ $operasional->tanggal }}">
                        @error('tanggal')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Transaksi</label>
                        <input type="text" class="form-control" name="nama_transaksi" placeholder="Nama Transaksi" value="{{ $operasional->nama_transaksi }}">
                        @error('nama_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Biaya</label>
                        <input type="text" class="form-control" name="biaya" id="biaya" placeholder="Biaya"
                            value="{{ $operasional->biaya }}">
                        @error('biaya')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Bukti Transaksi</label><br>
                        @include('layouts.buktiTransaksiEdit', [
                            'id' => $operasional->id,
                            'tabel' => 'operasional'
                        ])
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tambah Bukti Transaksi</label>
                        <input type="number" name="jumlah_bukti_transaksi" id="jumlah_bukti_transaksi" class="form-control" value="0">
                    </div>
                </div>

                <div class="card" id="bukti_transaksis">
                    
                </div>

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="#" onclick="window.location.replace(document.referrer)" class="btn btn-danger">Kembali</a>
            </div>

        </div>
    </form>

    @include('layouts.buktiTransaksiJS')

    <script>
        $(document).ready(function(){
            biaya();
        });

        $("#biaya").keyup(function (event) {
            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            biaya();
        });

        function biaya() {
            $("#biaya").val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection