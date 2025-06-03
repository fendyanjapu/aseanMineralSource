@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Rotasi Unit Site</h1>

    </div>
    <div style="margin: 0px 20px">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <form action="{{ route('rotasiUnit.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label>Tanggal</label><br>
                        <input type="date" class="form-control col-lg-3" name="tanggal" id="tanggal"
                            value="{{ old('tanggal') }}">
                        @error('tanggal')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nopol</label>
                        <input type="text" class="form-control" name="nopol" id="nopol" placeholder="Nopol"
                            value="{{ old('nopol') }}">
                        @error('nopol')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Supir</label>
                        <input type="text" class="form-control" name="supir"
                            placeholder="Supir" value="{{ old('supir') }}">
                        @error('supir')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                

                <div class="card">
                    <div class="card-body">
                        <label>Berat Kendaraan</label>
                        <input type="number" class="form-control" name="berat_kendaraan" id="berat_kendaraan" placeholder="Berat Kendaraan"
                            value="{{ old('berat_kendaraan') }}" step=".001">
                        @error('berat_kendaraan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Berat Kotor</label>
                        <input type="number" class="form-control" name="berat_kotor" id="berat_kotor"
                            placeholder="Berat Kotor" value="{{ old('berat_kotor') }}" step=".001">
                        @error('berat_kotor')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Berat Bersih</label>
                        <input type="text" class="form-control" name="berat_bersih" id="berat_bersih"
                            placeholder="Berat Bersih" value="{{ old('berat_bersih') }}" readonly>
                        @error('berat_bersih')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                

                <div class="card">
                    <div class="card-body">
                        <label>Total Rotasi</label>
                        <input type="text" class="form-control" name="total_rotasi" id="total_rotasi"
                            placeholder="Total Rotasi" value="{{ old('total_rotasi') }}" readonly>
                        @error('total_rotasi')
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

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="{{ route('rotasiUnit.index') }}"  class="btn btn-danger">Kembali</a>
            </div>

        </div>
    </form>

    <script>
        $("#berat_kotor").keyup(function (event) {
            beratBersih();
            totalBiaya();
        });
        $("#berat_kendaraan").keyup(function (event) {
            beratBersih();
            totalBiaya();
        });

        $("#premi_tonase").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalBiaya();
        });
        $("#premi_per_rite").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalBiaya();
        });

        $('#nopol').change(function(){
			totalRotasi();
		});

        $('#tanggal').change(function(){
			totalRotasi();
		});

        function totalRotasi() {
            let nopol = $("#nopol").val();
			let tanggal = $("#tanggal").val();
			$.ajax({
				type   : "GET",
				data   : {nopol: nopol, tanggal: tanggal},
				url    : "{{ route('getTotalRotasi') }}",
				cache  : false,
				success: function(result){
                    let data = $.parseJSON(result);
					$('#total_rotasi').val(data);
				}
			});
        }

        function beratBersih() {
            let berat_kotor = $("#berat_kotor").val();
            let berat_kendaraan = $("#berat_kendaraan").val();
            let berat_bersih = parseFloat(berat_kotor) - parseFloat(berat_kendaraan);
            $("#berat_bersih").val(berat_bersih);
        }

        function totalBiaya() {
            let berat_bersih = $("#berat_bersih").val();
            let premi_tonase = $("#premi_tonase").val();
            let premi_per_rite = $("#premi_per_rite").val();
            let int_premi_tonase = premi_tonase.replace(/,/g, "");
            let int_premi_per_rite = premi_per_rite.replace(/,/g, "");

            let total_biaya = (berat_bersih * parseInt(int_premi_tonase)) + parseInt(int_premi_per_rite);

            $('#total_biaya').val(total_biaya);
            $('#total_biaya').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection