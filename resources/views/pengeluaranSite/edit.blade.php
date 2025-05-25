@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pengeluaran Asean Untuk Site</h1>

    </div>

    <form action="{{ route('pengeluaranSite.update', ['pengeluaranSite' => $pengeluaranSite]) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" value="{{ $pengeluaranSite->kode_transaksi }}" readonly>
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
                                <option value="{{ $site->id }}" {{ $site->id == $pengeluaranSite->site_id ? 'selected' : '' }}>
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
                        <label>Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="{{ $pengeluaranSite->jumlah }}">
                        @error('jumlah')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Sumber Dana</label>
                        <input type="text" class="form-control" name="sumber_dana" placeholder="Sumber Dana" value="{{ $pengeluaranSite->sumber_dana }}">
                        @error('sumber_dana')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Metode Transaksi</label>
                        <input type="text" class="form-control" name="metode_transaksi" placeholder="Metode Transaksi" value="{{ $pengeluaranSite->metode_transaksi }}">
                        @error('metode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Tanggal" value="{{ $pengeluaranSite->tanggal }}">
                        @error('tanggal')
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
                            'id' => $pengeluaranSite->id,
                            'tabel' => 'pengeluaranSite'
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
            jumlah();
        });
        
        $('#jumlah').keyup(function (event) {

            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            jumlah();
        });

        function jumlah() {
            // format number
            $('#jumlah').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection