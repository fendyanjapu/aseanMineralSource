@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Operasional Site</h1>

    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('operasionalSite.update', ['operasionalSite' => $operasionalSite]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly value="{{ $operasionalSite->kode_transaksi }}">
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
                            value="{{ $operasionalSite->tanggal }}">
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
                        <input type="text" class="form-control" name="nama_transaksi" placeholder="Nama Transaksi" value="{{ $operasionalSite->nama_transaksi }}">
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
                            value="{{ $operasionalSite->biaya }}">
                        @error('biaya')
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
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $operasionalSite->site_id ? 'selected' : '' }}>
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

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="#" onclick="self.history.back()" class="btn btn-danger">Batal</a>
            </div>

        </div>
    </form>

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