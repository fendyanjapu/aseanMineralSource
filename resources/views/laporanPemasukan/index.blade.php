@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Laporan Pemasukan</h1>

    </div>

    <form action="{{ route('laporanPemasukan.print') }}" method="POST" target="_blank">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Bulan</label>
                        <select class="form-control" name="bulan">
                            <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tahun</label>
                        <input type="number" class="form-control" name="tahun" value="{{ $tahun }}" required>
                    </div>
                </div>

                <button class="btn btn-success" type="submit">Print</button>
                <a href="#" onclick="self.history.back()" class="btn btn-danger">Batal</a>
            </div>

        </div>
    </form>
@endsection