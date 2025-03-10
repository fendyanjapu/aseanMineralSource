@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Pembelian Batu Dari Site</h1>

    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('pembelianBatu.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label>Tanggal Pembelian</label>
                        <input type="date" class="form-control col-lg-3" name="tgl_pembelian"
                            value="{{ old('tgl_pembelian') }}">
                        @error('tgl_pembelian')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Site</label>
                        <select name="site_id" id="site_id" class="form-control">
                            <option value=""></option>
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

                <div class="card">
                    <div class="card-body">
                        <label>Pilih Tanggal Rotasi</label>
                        <input type="date" class="form-control col-lg-3" name="" id="tgl_rotasi">
                        <br>
                        <table>
                            <tr>
                                <td><label>Total Rotasi</label></td>
                                <td><label>Tonase</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control col-lg-3" name="total_rotasi" id="total_rotasi"
                                        readonly></td>
                                <td><input type="text" class="form-control col-lg-3" name="tonase" id="tonase" readonly>
                                </td>
                                <td>
                                    <a href="#" onclick="tambahRotasi()" class="btn btn-sm btn-success buton">Tambah</a>
                                    <a href="#" onclick="hapusRotasi()" class="btn btn-sm btn-danger buton">Hapus</a>
                                    <a href="#" onclick="resetRotasi()" class="btn btn-sm btn-info buton">Reset</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal Rotasi</label>
                        <input type="text" class="form-control" name="tgl_rotasi" id="tanggal_rotasi"
                            placeholder="Tanggal Rotasi" value="{{ old('tgl_rotasi') }}" readonly>
                        @error('tgl_rotasi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jumlah Tonase</label>
                        <input type="text" class="form-control" name="jumlah_tonase" id="jumlah_tonase"
                            placeholder="Jumlah Tonase" value="{{ old('jumlah_tonase') }}" readonly>
                        @error('jumlah_tonase')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Jetty</label>
                        <input type="text" class="form-control" name="nama_jetty" placeholder="Nama Jetty"
                            value="{{ old('nama_jetty') }}">
                        @error('nama_jetty')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga"
                            value="{{ old('harga') }}">
                        @error('harga')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jetty</label>
                        <input type="text" class="form-control" name="jetty" id="jetty" placeholder="Jetty"
                            value="{{ old('jetty') }}">
                        @error('jetty')
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
                            placeholder="Document dll" value="{{ old('document_dll') }}">
                        @error('document_dll')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Total Penjualan</label>
                        <input type="text" class="form-control" name="total_penjualan" id="total_penjualan"
                            placeholder="Total Penjualan" value="{{ old('total_penjualan') }}" readonly>
                        @error('total_penjualan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="{{ route('pembelianBatu.index') }}" class="btn btn-danger">Batal</a>
            </div>

        </div>
    </form>

    <script>
        $('a.buton').click(function (e) {
            e.preventDefault();
        });

        $("#jumlah_tonase").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });
        $("#harga").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });
        $("#jetty").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });
        $("#document_dll").keyup(function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalPenjualan();
        });

        $("#tgl_rotasi").change(function (event) {
            totalRotasi();
        });

        $("#site_id").change(function (event) {
            totalRotasi();
        });

        function totalRotasi() {
            let tgl_rotasi = $('#tgl_rotasi').val();
            let site_id = $('#site_id').val();
            $.ajax({
                type: "GET",
                data: { tanggal: tgl_rotasi, site_id: site_id },
                url: "{{ route('pembelianBatu.getTotalRotasi') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    $('#total_rotasi').val(data.totalRotasi);
                    $('#tonase').val(data.jumlahTonase);
                }
            });
        }

        function tambahRotasi() {
            let tgl_rotasi = $('#tgl_rotasi').val();

            $.ajax({
                type: "GET",
                data: { tanggal: tgl_rotasi },
                url: "{{ route('cekTglRotasi') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    cek = data;

                    if (cek == 1) {
                        alert('Tanggal rotasi sudah ada!')
                    } else {
                        let tonase = $('#tonase').val();

                        if (tonase == 0) {
                            alert('Tidak ada produksi!');
                        } else {
                            let tanggal_rotasi = $('#tanggal_rotasi').val();
                            let jumlah_tonase = $('#jumlah_tonase').val();
                            let tonase = $('#tonase').val();
                            if (tanggal_rotasi == '') {
                                var jumTgl = [tgl_rotasi];
                            } else {
                                var jumTgl = [tanggal_rotasi];
                                jumTgl.push(tgl_rotasi);
                            }
                            if (jumlah_tonase == '') {
                                var jmlTonase = tonase;
                            } else {
                                var jmlTonase = parseInt(jumlah_tonase) + parseInt(tonase);
                            }
                            let tglRotasi = jumTgl.toString();
                            $('#tanggal_rotasi').val(tglRotasi);
                            $('#jumlah_tonase').val(jmlTonase);
                        }
                    }
                }
            });
        }

        function hapusRotasi() {
            let tanggal_rotasi = $('#tanggal_rotasi').val();
            let tgl_rotasi = $('#tgl_rotasi').val();
            let jumlah_tonase = $('#jumlah_tonase').val();
            let tonase = $('#tonase').val();
            let jumTgl = tanggal_rotasi.replace(tgl_rotasi, '');
            jumTgl = jumTgl.substring(0, jumTgl.length - 1);

            if (jumlah_tonase == '') {
                var jmlTonase = "";
            } else {
                var jmlTonase = parseInt(jumlah_tonase) - parseInt(tonase);
            }
            $('#tanggal_rotasi').val(jumTgl);
            $('#jumlah_tonase').val(jmlTonase);
        }

        function resetRotasi() {
            $('#tanggal_rotasi').val("");
            $('#jumlah_tonase').val("");
        }

        function totalPenjualan() {
            let harga = $("#harga").val();
            let jetty = $("#jetty").val();
            let document_dll = $("#document_dll").val();
            let jumlah_tonase = $("#jumlah_tonase").val();
            let int_harga = harga.replace(/,/g, "");
            let int_jetty = jetty.replace(/,/g, "");
            let int_document_dll = document_dll.replace(/,/g, "");
            let int_jumlah_tonase = jumlah_tonase.replace(/,/g, "");

            let total_penjualan = (int_harga * int_jumlah_tonase) +
                (int_jetty * int_jumlah_tonase) +
                (int_document_dll * int_jumlah_tonase);

            $('#total_penjualan').val(total_penjualan);
            $('#total_penjualan').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }
    </script>

@endsection