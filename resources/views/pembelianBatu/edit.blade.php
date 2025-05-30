@extends('layouts.template')

@section('content')
<style>
    .ui-highlight .ui-state-default{
        background: green !important;
        border-color: green !important;
        color: white !important;
    }
</style>
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pembelian Batu Dari Site</h1>

    </div>

    <form action="{{ route('pembelianBatu.update', ['pembelianBatu' => $pembelianBatu]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly
                            value="{{ $pembelianBatu->kode_transaksi }}">
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
                            value="{{ $pembelianBatu->tgl_pembelian }}">
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
                        <select name="site_id" id="" class="form-control">
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $pembelianBatu->site_id ? 'selected' : '' }}>
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
                        <label>Pilih Tanggal Rotasi</label>
                        <input type="text" class="form-control col-lg-3" name="" id="tgl_rotasi">
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
                        <input type="text" class="form-control col-lg-3" name="tgl_rotasi" id="tanggal_rotasi"
                            value="{{ $pembelianBatu->tgl_rotasi }}" readonly>
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
                        <input type="text" class="form-control" name="jumlah_tonase" id="jumlah_tonase" placeholder="Jumlah Tonase"
                            value="{{ $pembelianBatu->jumlah_tonase }}" readonly>
                        @error('jumlah_tonase')
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
                            value="{{ $pembelianBatu->harga }}">
                        @error('harga')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Total Penjualan</label>
                        <input type="text" class="form-control" name="total_penjualan" id="total_penjualan" placeholder="Total Penjualan"
                            value="{{ $pembelianBatu->total_penjualan }}" readonly>
                        @error('total_penjualan')
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
        $('a.buton').click(function (e) {
            e.preventDefault();
        });

        function colorDate(dates) {
            // var dates = ['2025-03-05','2025-03-15','2025-03-25'];
            dateArray = dates.split(",");
            jQuery(function(){
                jQuery('#tgl_rotasi').datepicker({
                    changeMonth : true,
                    changeYear : true,
                    beforeShowDay : function(date){
                        var y = date.getFullYear().toString(); // get full year
                        var m = (date.getMonth() + 1).toString(); // get month.
                        var d = date.getDate().toString(); // get Day
                        if(m.length == 1){ m = '0' + m; } // append zero(0) if single digit
                        if(d.length == 1){ d = '0' + d; } // append zero(0) if single digit
                        var currDate = y+'-'+m+'-'+d;
                        if(dateArray.indexOf(currDate) >= 0){
                            return [true, "ui-highlight"];	
                        }else{
                            return [true];
                        }					
                    }
                });
            })
        }

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

        $("#tgl_rotasi").change(function (event) {
            totalRotasi();
        });

        $("#site_id").change(function (event) {
            let id = $(this).val();
            $.ajax({
                type: "GET",
                data: "site_id=" + id,
                url: "{{ route('getRotasi') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    let dates = data.tanggal;
                    colorDate(dates);
                }
            });
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
            let jumlah_tonase = $("#jumlah_tonase").val();
            let int_harga = harga.replace(/,/g, "");

            let total_penjualan = int_harga * jumlah_tonase

            $('#total_penjualan').val(total_penjualan);
            $('#total_penjualan').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }

        $(document).ready(function(){
            $('#total_penjualan').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });
    </script>

@endsection