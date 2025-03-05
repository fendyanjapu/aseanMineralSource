@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Pengapalan</h1>

    </div>
    <form action="{{ route('pengapalan.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly value="{{ $kode }}">
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal Pengapalan</label>
                        <input type="text" class="form-control" name="tanggal_pengapalan" placeholder="Tanggal Pengapalan"
                            value="{{ old('tanggal_pengapalan') }}">
                        @error('tanggal_pengapalan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Tongkang</label>
                        <input type="text" class="form-control" name="nama_tongkang" placeholder="Nama Tongkang"
                            value="{{ old('nama_tongkang') }}">
                        @error('nama_tongkang')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Site</label>
                        <select name="site_id" id="site" class="form-control">
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}">{{ $site->nama_site }}</option>
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
                        <label>Pembelian Batu dari Site</label>
                        <select name="pembelian_batu_id" id="pembelian_batu" class="form-control">
                            <option value=""></option>
                        </select>
                        @error('pembelian_batu_id')
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
        document.getElementById('site').addEventListener('change', function () {
            let siteId = this.value;
            fetch(`/getPembelianBatu/${siteId}`)
                .then(response => response.json())
                .then(data => {
                    let pembelianDropdown = document.getElementById('pembelian_batu');
                    pembelianDropdown.innerHTML = '';
                    let option = document.createElement('option');
                    option.value = '';
                    option.textContent = '';
                    pembelianDropdown.appendChild(option);
                    data.forEach(function (pembelian) {
                        let option = document.createElement('option');
                        option.value = pembelian.id;
                        option.textContent = pembelian.kode_transaksi;
                        pembelianDropdown.appendChild(option);
                    });
                });
        });
    </script>

@endsection