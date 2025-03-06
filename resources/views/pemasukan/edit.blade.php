@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pengeluaran Site</h1>

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
                        <label>Site</label>
                        <select name="site_id" id="" class="form-control">
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $pemasukan->site_id ? 'selected' : '' }}>
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
        $('#jumlah').keyup(function (event) {

            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });
    </script>

@endsection