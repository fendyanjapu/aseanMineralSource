@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Barang</h1>

    </div>

    <form action="{{ route('barang.update', ['barang' => $barang]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Barang</label>
                        <input type="text" class="form-control" name="kode" placeholder="Kode" value="{{ $barang->kode }}" readonly>
                        @error('kode')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ $barang->nama }}">
                        @error('nama')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Merk</label>
                        <input type="text" class="form-control" name="merk" placeholder="Merk" value="{{ $barang->merk }}">
                        @error('merk')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Spesifikasi</label>
                        <input type="text" class="form-control" name="spesifikasi" placeholder="Spesifikasi" value="{{ $barang->spesifikasi }}">
                        @error('spesifikasi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Kisaran Harga</label>
                        <input type="text" class="form-control" name="kisaran_harga" id="kisaran_harga" placeholder="Kisaran Harga" value="{{ $barang->kisaran_harga }}">
                        @error('kisaran_harga')
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
        $('#kisaran_harga').keyup(function (event) {

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