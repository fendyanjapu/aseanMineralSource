@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Site</h1>

    </div>

    <form action="{{ route('site.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Nama Site</label>
                        <input type="text" class="form-control" name="nama_site" placeholder="Nama Site" value="{{ old('nama_site') }}">
                        @error('nama_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Lokasi</label>
                        <input type="text" class="form-control" name="lokasi" placeholder="Lokasi" value="{{ old('lokasi') }}">
                        @error('lokasi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Penanggung Jawab</label>
                        <input type="text" class="form-control" name="penanggung_jawab" placeholder="Penanggung Jawab" value="{{ old('penanggung_jawab') }}">
                        @error('penanggung_jawab')
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


@endsection