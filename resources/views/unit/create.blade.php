@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Unit</h1>

    </div>

    <form action="{{ route('unit.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode</label>
                        <input type="text" class="form-control" name="kode" placeholder="Kode" value="{{ old('kode') }}">
                        @error('kode')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>No Identitas Unit</label>
                        <input type="text" class="form-control" name="no_identitas_unit" placeholder="No Identitas Unit" value="{{ old('no_identitas_unit') }}">
                        @error('no_identitas_unit')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Spesifikasi</label>
                        <input type="text" class="form-control" name="spesifikasi" placeholder="Spesifikasi" value="{{ old('spesifikasi') }}">
                        @error('spesifikasi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Merk</label>
                        <input type="text" class="form-control" name="merk" placeholder="Merk" value="{{ old('merk') }}">
                        @error('merk')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Tanggal Pembelian</label>
                        <input type="date" class="form-control" name="tanggal_pembelian" placeholder="Tanggal Pembelian" value="{{ old('tanggal_pembelian') }}">
                        @error('tanggal_pembelian')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="{{ old('harga') }}">
                        @error('harga')
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
        $('#harga').keyup(function (event) {

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