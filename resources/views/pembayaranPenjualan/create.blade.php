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
        <h1 class="h3 d-inline align-middle">Tambah Pembayaran Penjualan</h1>

    </div>
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('pembayaranPenjualan.store') }}" method="POST" enctype="multipart/form-data">
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
                        <br>
                        <label>Total Hutang Site</label><br>
                        <input type="text" class="form-control col-lg-3" name="total_hutang_site" id="total_hutang"
                            value="{{ old('total_hutang_site') }}" readonly>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Pilih Tanggal Pembelian</label>
                        <input type="text" class="form-control col-lg-3" name="" id="tglPembelian">
                        <br>
                        <label>Data Pembelian</label>
                        <select class="form-control col-lg-3" name="" id="dataPembelian">
                            <option value=""></option>
                        </select>
                        <br>
                        <table>
                            <tr>
                                <td><label>Tonase</label></td>
                                <td><label>Harga Pembelian</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control col-lg-3" name="" id="tonase" readonly>
                                <td><input type="text" class="form-control col-lg-3" name="" id="hargaPembelian" readonly>
                                </td>
                                </td>
                                <td>
                                    <a href="#" onclick="tambahPembelian()" class="btn btn-sm btn-success buton">Tambah</a>
                                    <a href="#" onclick="hapusPembelian()" class="btn btn-sm btn-danger buton">Hapus</a>
                                    <a href="#" onclick="resetPembelian()" class="btn btn-sm btn-info buton">Reset</a>
                                </td>
                            </tr>
                        </table>


                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Data Pembelian Site</label>
                        <input type="text" class="form-control col-lg-3" name="data_pembelian_site" id="data_pembelian_site"
                            value="{{ old('data_pembelian_site') }}" readonly>
                        @error('data_pembelian_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <br>
                        <label>Tanggal Pembelian</label>
                        <input type="text" class="form-control" name="tanggal_pembelian"
                            id="tanggal_pembelian" value="{{ old('tanggal_pembelian') }}" readonly>
                        @error('tanggal_pembelian')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <br>
                        <label>Jumlah Tonase</label>
                        <input type="text" class="form-control col-lg-3" name="tonase" id="jmlTonase"
                            value="{{ old('tonase') }}" readonly>
                        @error('tonase')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <br>
                        <label>Total Harga Pembelian</label>
                        <input type="text" class="form-control col-lg-3" name="total_harga_pembelian"
                            id="total_harga_pembelian" value="{{ old('total_harga_pembelian') }}" readonly>
                        @error('total_harga_pembelian')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Pilih Dana Operasional</label>
                        <select class="form-control col-lg-3" name="" id="danaOperasional"></select>
                        <br>
                        <table>
                            <tr>
                                <td><label>Tanggal Transfer</label></td>
                                <td><label>Hutang Site</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="date" class="form-control col-lg-3" name="" id="tglTransfer" readonly></td>
                                <td><input type="text" class="form-control col-lg-3" name="" id="hutangSite" readonly>
                                </td>
                                <td>
                                    <a href="#" onclick="tambahOperasional()"
                                        class="btn btn-sm btn-success buton">Tambah</a>
                                    <a href="#" onclick="hapusOperasional()" class="btn btn-sm btn-danger buton">Hapus</a>
                                    <a href="#" onclick="resetOperasional()" class="btn btn-sm btn-info buton">Reset</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Dana Operasional Site</label>
                        <input type="text" class="form-control" name="dana_operasional_site"
                            id="dana_operasional_site" value="{{ old('dana_operasional_site') }}" readonly>
                        @error('dana_operasional_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <br>
                        <label>Tanggal Transfer ke Site</label>
                        <input type="text" class="form-control" name="tanggal_transfer_ke_site"
                            id="tanggal_transfer_ke_site" value="{{ old('tanggal_transfer_ke_site') }}" readonly>
                        @error('tanggal_transfer_ke_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                        <br>
                        <label>Jumlah Hutang Site</label>
                        <input type="text" class="form-control" name="jumlah_hutang_site" id="jumlah_hutang_site"
                            value="{{ old('jumlah_hutang_site') }}" readonly>
                        @error('jumlah_hutang_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Total Pembayaran Site</label>
                        <input type="text" class="form-control" name="total_pembayaran_site" id="total_pembayaran_site"
                            value="{{ old('total_pembayaran_site') }}" readonly>
                        @error('total_pembayaran_site')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ old('tanggal_transaksi') }}">
                        @error('tanggal_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jumlah Bukti Transaksi</label>
                        <input type="number" name="jumlah_bukti_transaksi" id="jumlah_bukti_transaksi" class="form-control" value="0">
                    </div>
                </div>

                <div class="card" id="bukti_transaksis">
                    
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Sisa Hutang Site</label>
                        <input type="text" class="form-control" name="sisa_hutang_site" id="sisa_hutang_site" value="{{ old('sisa_hutang_site') }}" readonly>
                        @error('sisa_hutang_site')
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

    @include('layouts.buktiTransaksiJS')

    <script>
        $('a.buton').click(function (e) {
            e.preventDefault();
        });

        function colorDate(dates) {
            // var dates = ['2025-03-05','2025-03-15','2025-03-25'];
            dateArray = dates.split(",");
            jQuery(function(){
                jQuery('#tglPembelian').datepicker({
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

        $('#site_id').change(function () {
            let site_id = $(this).val();
            $.ajax({
                type: "GET",
                data: { site_id: site_id },
                url: "{{ route('getTotalHutang') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    $("#total_hutang").val(data.total_hutang);
                    $('#total_hutang').val(function (index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                    });
                    let dates = data.tgl_pembelian;
                    colorDate(dates);
                }
            });
            getDataPembelian();
            $.ajax({
                type: "GET",
                data: { site_id: site_id },
                url: "{{ route('getOperasional') }}",
                cache: false,
                success: function (result) {
                    $('#danaOperasional').html(result);
                }
            });
        });

        $('#danaOperasional').change(function () {
            let kode_transaksi = $(this).val();
            if (kode_transaksi == '') {
                $("#tglTransfer").val('');
                $("#hutangSite").val('');
            } else {
                $.ajax({
                    type: "GET",
                    data: { kode_transaksi: kode_transaksi },
                    url: "{{ route('getPengeluaranSite') }}",
                    cache: false,
                    success: function (result) {
                        let data = $.parseJSON(result);
                        $("#tglTransfer").val(data.tanggal);
                        $("#hutangSite").val(data.jumlah);
                    }
                });
            }
        });

        $('#dataPembelian').change(function () {
            let kode_transaksi = $(this).val();
            if (kode_transaksi == '') {
                $("#tonase").val('');
                $("#total_harga_pembelian").val('');
            } else {
                $.ajax({
                    type: "GET",
                    data: { kode_transaksi: kode_transaksi },
                    url: "{{ route('getHarga') }}",
                    cache: false,
                    success: function (result) {
                        let data = $.parseJSON(result);
                        $("#tonase").val(data.jumlah_tonase);
                        $("#hargaPembelian").val(data.total_penjualan);
                        $('#hargaPembelian').val(function (index, value) {
                            return value
                                .replace(/\D/g, "")
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                ;
                        });
                    }
                });
            }
        });

        $('#tglPembelian').change(function () {
            getDataPembelian();
        });

        function totalpembayaranSite() {
            let total_harga_pembelian = $('#total_harga_pembelian').val();
            let jumlah_hutang_site = $('#jumlah_hutang_site').val();
            let int_total_harga_pembelian = total_harga_pembelian.replace(/,/g, "");
            let int_jumlah_hutang_site = jumlah_hutang_site.replace(/,/g, "");
            let total = parseInt(int_total_harga_pembelian) - parseInt(int_jumlah_hutang_site);
            if (total < 0) {
                total = 0;
            }
            $('#total_pembayaran_site').val(total);
            $('#total_pembayaran_site').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }

        function sisaHutangSite() {
            let total_hutang = $('#total_hutang').val();
            let jumlah_hutang_site = $('#jumlah_hutang_site').val();
            let total_harga_pembelian = $('#total_harga_pembelian').val();
            let int_total_hutang = total_hutang.replace(/,/g, "");
            let int_jumlah_hutang_site = jumlah_hutang_site.replace(/,/g, "");
            let int_total_harga_pembelian = total_harga_pembelian.replace(/,/g, "");

            if (parseInt(int_total_harga_pembelian) > parseInt(int_jumlah_hutang_site)) {
                total = parseInt(int_total_hutang) - parseInt(int_jumlah_hutang_site);
            } else {
                total = parseInt(int_jumlah_hutang_site) - parseInt(int_total_harga_pembelian);
            }
            $('#sisa_hutang_site').val(total);
            $('#sisa_hutang_site').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }

        function tambahOperasional() {
            let tglTransfer = $('#tglTransfer').val();
            let tanggal_transfer_ke_site = $('#tanggal_transfer_ke_site').val();

            let hutangSite = $('#hutangSite').val();
            let jumlah_hutang_site = $('#jumlah_hutang_site').val();
            let int_hutangSite = hutangSite.replace(/,/g, "");
            let int_jumlah_hutang_site = jumlah_hutang_site.replace(/,/g, "");

            let danaOperasional = $('#danaOperasional').val();
            let danaOperasionalSite = $('#dana_operasional_site').val();

            if (danaOperasionalSite == '') {
                var sumData = [danaOperasional];
            } else {
                var sumData = [danaOperasionalSite];
                sumData.push(danaOperasional);
            }
            let dana_operasional_site = sumData.toString();

            if (tanggal_transfer_ke_site == '') {
                var jumTgl = [tglTransfer];
            } else {
                var jumTgl = [tanggal_transfer_ke_site];
                jumTgl.push(tglTransfer);
            }
            let tgl = jumTgl.toString();

            if (int_jumlah_hutang_site == '') {
                var jumlah_hutang = int_hutangSite;
            } else {
                var jumlah_hutang = parseInt(int_jumlah_hutang_site) + parseInt(int_hutangSite);
            }

            $('#dana_operasional_site').val(dana_operasional_site);
            $('#tanggal_transfer_ke_site').val(tgl);
            $('#jumlah_hutang_site').val(jumlah_hutang);
            $('#jumlah_hutang_site').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalpembayaranSite();
            sisaHutangSite();
        }

        function hapusOperasional() {
            let tanggal_transfer_ke_site = $('#tanggal_transfer_ke_site').val();
            let tglTransfer = $('#tglTransfer').val();
            let jumTgl = tanggal_transfer_ke_site.replace(tglTransfer, '');
            jumTgl = jumTgl.substring(0, jumTgl.length - 1);

            let jumlah_hutang_site = $('#jumlah_hutang_site').val();
            let hutangSite = $('#hutangSite').val();
            let int_jumlah_hutang_site = jumlah_hutang_site.replace(/,/g, "");
            let int_hutangSite = hutangSite.replace(/,/g, "");

            if (jumlah_hutang_site == '') {
                var jml = "";
            } else {
                var jml = parseInt(int_jumlah_hutang_site) - parseInt(int_hutangSite);
            }

            let danaOperasional = $('#danaOperasional').val();
            let danaOperasionalSite = $('#dana_operasional_site').val();

            let sumData = danaOperasionalSite.replace(danaOperasional, '');
            sumData = sumData.substring(0, sumData.length - 1);

            $('#dana_operasional_site').val(sumData);
            $('#tanggal_transfer_ke_site').val(jumTgl);
            $('#jumlah_hutang_site').val(jml);
            $('#jumlah_hutang_site').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalpembayaranSite();
            sisaHutangSite();
        }

        function resetOperasional() {
            $('#dana_operasional_site').val("");
            $('#tanggal_transfer_ke_site').val("");
            $('#jumlah_hutang_site').val("");
            totalpembayaranSite();
            sisaHutangSite();
        }

        function getDataPembelian() {
            let tgl_pembelian = $('#tglPembelian').val();
            let site_id = $('#site_id').val();
            $.ajax({
                type: "GET",
                data: { tgl_pembelian: tgl_pembelian, site_id: site_id },
                url: "{{ route('getDataPembelian') }}",
                cache: false,
                success: function (result) {
                    $('#dataPembelian').html(result);
                }
            });
        }

        function tambahPembelian() {
            let kode_transaksi = $('#dataPembelian').val();

            $.ajax({
                type: "GET",
                data: { kode_transaksi: kode_transaksi },
                url: "{{ route('cekPembelian') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    cek = data;

                    if (cek == 1) {
                        alert('Data Pembelian sudah ada!')
                    } else {
                        let tonase = $('#tonase').val();
                        let jumlah_tonase = $('#jmlTonase').val();

                        let hargaPembelian = $('#hargaPembelian').val();
                        let total_harga_pembelian = $('#total_harga_pembelian').val();
                        let int_hargaPembelian = hargaPembelian.replace(/,/g, "");
                        let int_total_harga_pembelian = total_harga_pembelian.replace(/,/g, "");

                        let dataPembelian = $('#dataPembelian').val();
                        let dataPembelianSite = $('#data_pembelian_site').val();

                        let tglPembelian = $('#tglPembelian').val();
                        let tanggal_pembelian = $('#tanggal_pembelian').val();

                        if (tanggal_pembelian == '') {
                            var jumTgl = [tglPembelian];
                        } else {
                            if (tanggal_pembelian == tglPembelian) {
                                var jumTgl = [tglPembelian];
                            } else {
                                var jumTgl = [tanggal_pembelian];
                                jumTgl.push(tglPembelian);
                            }
                        }
                        let tgl = jumTgl.toString();

                        if (dataPembelianSite == '') {
                            var sumData = [dataPembelian];
                        } else {
                            var sumData = [dataPembelianSite];
                            sumData.push(dataPembelian);
                        }
                        let data_pembelian_site = sumData.toString();

                        if (jumlah_tonase == '') {
                            var jmlTonase = tonase;
                        } else {
                            var jmlTonase = parseFloat(jumlah_tonase) + parseFloat(tonase);
                        }

                        if (int_total_harga_pembelian == '') {
                            var total_harga = int_hargaPembelian;
                        } else {
                            var total_harga = parseInt(int_total_harga_pembelian) + parseInt(int_hargaPembelian);
                        }
                        
                        $('#data_pembelian_site').val(data_pembelian_site);
                        $('#tanggal_pembelian').val(tgl);
                        $('#jmlTonase').val(jmlTonase);
                        $('#total_harga_pembelian').val(total_harga);
                        $('#total_harga_pembelian').val(function (index, value) {
                            return value
                                .replace(/\D/g, "")
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                ;
                        });
                        totalpembayaranSite();
                        // sisaHutangSite();
                    }
                }
            });
        }

        function hapusPembelian() {
            let tonase = $('#tonase').val();
            let jumlah_tonase = $('#jmlTonase').val();
            let hargaPembelian = $('#hargaPembelian').val();
            let total_harga_pembelian = $('#total_harga_pembelian').val();
            let int_hargaPembelian = hargaPembelian.replace(/,/g, "");
            let int_total_harga_pembelian = total_harga_pembelian.replace(/,/g, "");
            let dataPembelian = $('#dataPembelian').val();
            let dataPembelianSite = $('#data_pembelian_site').val();

            let tanggal_pembelian = $('#tanggal_pembelian').val();
            let tglPembelian = $('#tglPembelian').val();
            let jumTgl = tanggal_pembelian.replace(tglPembelian, '');
            jumTgl = jumTgl.substring(0, jumTgl.length - 1);

            let sumData = dataPembelianSite.replace(dataPembelian, '');
            sumData = sumData.substring(0, sumData.length - 1);

            if (jumlah_tonase == '') {
                var jmlTonase = "";
            } else {
                var jmlTonase = parseFloat(jumlah_tonase) - parseFloat(tonase);
            }
            if (total_harga_pembelian == '') {
                var total_harga = "";
            } else {
                var total_harga = parseInt(int_total_harga_pembelian) - parseInt(int_hargaPembelian);
            }

            $('#data_pembelian_site').val(sumData);
            $('#tanggal_pembelian').val(jumTgl);
            $('#jmlTonase').val(jmlTonase);
            $('#total_harga_pembelian').val(total_harga);
            $('#total_harga_pembelian').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            totalpembayaranSite();
            // sisaHutangSite();
        }

        function resetPembelian() {
            $('#data_pembelian_site').val("");
            $('#tanggal_pembelian').val("");
            $('#jmlTonase').val("");
            $('#total_harga_pembelian').val("");
            totalpembayaranSite();
            // sisaHutangSite();
        }

    </script>

@endsection