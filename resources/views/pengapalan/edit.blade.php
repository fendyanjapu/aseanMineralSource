@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pengapalan</h1>

    </div>
    <form action="{{ route('pengapalan.update', ['pengapalan' => $pengapalan]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly value="{{ $pengapalan->kode_transaksi }}">
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
                        <input type="date" class="form-control" name="tanggal_pengapalan" placeholder="Tanggal Pengapalan"
                            value="{{ $pengapalan->tanggal_pengapalan }}">
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
                            value="{{ $pengapalan->nama_tongkang }}">
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
                        <input type="hidden" name="site_id" value="{{ $pengapalan->site_id }}">
                        <select name="site" id="site" class="form-control" disabled>
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $pengapalan->site_id ? 'selected' : '' }}>
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

                <div class="card">
                    <div class="card-body">
                        <label>Tonase</label>
                        <input type="text" class="form-control" name="tonase" id="tonase" placeholder="Tonase"
                            value="{{ $pengapalan->tonase }}" readonly>
                        @error('tonase')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Harga di Site</label>
                        <input type="text" class="form-control" name="harga_di_site" id="harga_di_site"
                            placeholder="Harga di Site" value="{{ $pengapalan->harga_di_site }}" readonly>
                        @error('harga_di_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Harga Jual Pertonase</label>
                        <input type="text" class="form-control" name="harga_jual_per_tonase" id="harga_jual_per_tonase"
                            placeholder="Harga Jual Pertonase" value="{{ $pengapalan->harga_jual_per_tonase }}"
                            {{ auth()->user()->level_id != 2 ? 'readonly' : '' }}>
                            <small>*diinput direksi</small>
                        @error('harga_jual_per_tonase')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Document dll</label>
                        <input type="text" class="form-control" name="document_dll" id="document_dll"
                            placeholder="Document dll" value="{{ $pengapalan->document_dll }}"
                            {{ auth()->user()->level_id != 2 ? 'readonly' : '' }}>
                            <small>*diinput direksi</small>
                        @error('document_dll')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Total Harga Penjualan</label>
                        <input type="text" class="form-control" name="total_harga_penjualan" id="total_harga_penjualan"
                            placeholder="Total Harga Penjualan" value="{{ $pengapalan->total_harga_penjualan }}" readonly>
                        @error('total_harga_penjualan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Laba Bersih</label>
                        <input type="text" class="form-control" name="laba_bersih" id="laba_bersih"
                            placeholder="Laba Bersih" value="{{ $pengapalan->laba_bersih }}" readonly>
                        @error('laba_bersih')
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
        $('#harga_jual_per_tonase').keyup(function(){
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
			totalPenjualan();
            labaBersih();
		});

        $('#document_dll').keyup(function(){
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
			totalPenjualan();
            labaBersih();
		});

        function totalPenjualan() {
            let tonase = $('#tonase').val();
            let harga_jual_per_tonase = $('#harga_jual_per_tonase').val();
            let document_dll = $('#document_dll').val();
            let int_tonase = tonase.replace(/,/g, "");
            let int_harga_jual_per_tonase = harga_jual_per_tonase.replace(/,/g, "");
            let int_document_dll = document_dll.replace(/,/g, "");

            let total_harga_penjualan = (parseInt(int_harga_jual_per_tonase) * parseInt(int_tonase)) - (parseInt(int_document_dll) * parseInt(int_tonase));

            $('#total_harga_penjualan').val(total_harga_penjualan);
            $('#total_harga_penjualan').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }

        function labaBersih() {
            let total_harga_penjualan = $('#total_harga_penjualan').val();
            let harga_di_site = $('#harga_di_site').val();
            let int_total_harga_penjualan = total_harga_penjualan.replace(/,/g, "");
            let int_harga_di_site = harga_di_site.replace(/,/g, "");

            let laba_bersih = parseInt(int_total_harga_penjualan) - parseInt(int_harga_di_site);

            $('#laba_bersih').val(laba_bersih);
            $('#laba_bersih').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection