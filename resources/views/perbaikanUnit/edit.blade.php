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
                        <input type="text" class="form-control" name="kode_transaksi" readonly
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

                <div class="card">
                    <div class="card-body">
                        <label>Bukti Transaksi</label><br>
                        @include('layouts.buktiTransaksiEdit', [
                            'id' => $perbaikanUnit->id,
                            'tabel' => 'perbaikanUnit'
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
            total_harga();
        });
        
        $('#total_harga').keyup(function (event) {

            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            total_harga();
        });

        function total_harga() {
            // format number
            $('#total_harga').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection