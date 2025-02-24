@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Perbaikan Unit</h1>

    </div>

    <form action="{{ route('perbaikanUnit.update', ['perbaikanUnit' => $perbaikanUnit]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" placeholder="Kode Transaksi"
                            value="{{ $perbaikanUnit->kode_transaksi }}">
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Unit</label>
                        <select class="form-control" name="unit_id">
                            <option value=""></option>
                            @foreach ($units as $item)
                                <option value="{{ $item->id }}" {{ $perbaikanUnit->unit_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->no_identitas_unit }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Detail Perbaikan</label>
                        <textarea class="form-control" name="detail_perbaikan">{{ $perbaikanUnit->detail_perbaikan }}</textarea>
                        @error('detail_perbaikan')
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
                            placeholder="Total Harga" value="{{ $perbaikanUnit->total_harga }}">
                        @error('total_harga')
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
                            value="{{ $perbaikanUnit->tanggal }}">
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
        $('#total_harga').keyup(function (event) {

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