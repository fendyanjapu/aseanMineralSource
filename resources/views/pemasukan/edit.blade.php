@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pemasukan</h1>

    </div>

    <form action="{{ route('pemasukan.update', ['pemasukan' => $pemasukan]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" value="{{ $pemasukan->kode_transaksi }}" readonly>
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="{{ $pemasukan->jumlah }}">
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
                        <input type="text" class="form-control" name="sumber_dana" placeholder="Sumber Dana" value="{{ $pemasukan->sumber_dana }}">
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
                        <input type="text" class="form-control" name="metode_transaksi" placeholder="Metode Transaksi" value="{{ $pemasukan->metode_transaksi }}">
                        @error('metode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" placeholder="Keterangan">{{ $pemasukan->keterangan }}</textarea>
                        @error('keterangan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Tanggal" value="{{ $pemasukan->tanggal }}">
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