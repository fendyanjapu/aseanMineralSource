@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		
	</div>

	<div class="card">
        <div class="card-body">
            <label>Bukti Foto Biaya Jetty</label>
            <br><br>
            <img src="{{ env('APP_URL') . '/upload/pengapalan/' . $pengapalan->bukti_biaya_jetty }}" alt="" width="500px">
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <label>Bukti Foto Biaya Dokumen</label>
            <br><br>
            <img src="{{ env('APP_URL') . '/upload/pengapalan/' . $pengapalan->bukti_biaya_dokumen }}" alt="" width="500px">
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <label>Bukti Foto Biaya Operasional dll</label>
            <br><br>
            <img src="{{ env('APP_URL') . '/upload/pengapalan/' . $pengapalan->bukti_biaya_operasional_dll }}" alt="" width="500px">
        </div>
    </div>
    <br>
    <a href="#" onclick="self.history.back()" class="btn btn-danger">Kembali</a>
</div>
@endsection