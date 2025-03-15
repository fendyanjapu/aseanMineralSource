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
        <h1 class="h3 d-inline align-middle">Tambah Data Pengapalan</h1>

    </div>
    <form action="{{ route('pengapalan.store') }}" method="POST">
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
                        <label>Tanggal Pengapalan</label>
                        <input type="date" class="form-control" name="tanggal_pengapalan" placeholder="Tanggal Pengapalan"
                            value="{{ old('tanggal_pengapalan') }}">
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
                            value="{{ old('nama_tongkang') }}">
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
                        <select name="site_id" id="site" class="form-control">
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
                        <label>Pilih Tanggal Pembelian</label>
                        <input type="text" class="form-control col-lg-3" name="" id="tglPembelianBatu">
                        <br>
                        <table>
                            <tr>
                                <td><label>Harga</label></td>
                                <td><label>Tonase</label></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control col-lg-3" name="" id="harga"
                                        readonly></td>
                                <td><input type="text" class="form-control col-lg-3" name="" id="tonase" readonly>
                                </td>
                                <td>
                                    <a href="#" onclick="tambah()" class="btn btn-sm btn-success buton">Tambah</a>
                                    {{-- <a href="#" onclick="hapus()" class="btn btn-sm btn-danger buton">Hapus</a> --}}
                                    <a href="#" onclick="reset()" class="btn btn-sm btn-info buton">Reset</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <input type="hidden" class="form-control" name="" id="id_pembelian" readonly>
                <input type="hidden" class="form-control" name="" id="hargaSite" readonly>
                <input type="hidden" class="form-control" name="id_pembelian_batu" id="id_pembelian_batu">
                {{-- <div class="card">
                    <div class="card-body">
                        <label>Data Pembelian Batu</label>
                        <input type="text" class="form-control" name="data_pembelian_batu" id="data_pembelian_batu" placeholder="Data Pembelian Batu"
                            value="{{ old('data_pembelian_batu') }}" readonly>
                        @error('data_pembelian_batu')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div> --}}

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal Pembelian</label>
                        <input type="text" class="form-control" name="tanggal_pembelian" id="tanggal_pembelian" placeholder="Tanggal Pembelian"
                            value="{{ old('tanggal_pembelian') }}" readonly>
                        @error('tanggal_pembelian')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="harga" id="sumHarga"
                            placeholder="Harga" value="{{ old('harga') }}" readonly>
                        @error('harga')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tonase</label>
                        <input type="text" class="form-control" name="tonase" id="jmlTonase" placeholder="Tonase"
                            value="{{ old('tonase') }}" readonly>
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
                            placeholder="Harga di Site" value="{{ old('harga_di_site') }}" readonly>
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
                            placeholder="Harga Jual Pertonase" value="{{ old('harga_jual_per_tonase') }}"
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
                            placeholder="Document dll" value="{{ old('document_dll') }}"
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
                            placeholder="Total Harga Penjualan" value="{{ old('total_harga_penjualan') }}" readonly>
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
                            placeholder="Laba Bersih" value="{{ old('laba_bersih') }}" readonly>
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
        $('a.buton').click(function (e) {
            e.preventDefault();
        });
        		
		function colorDate(dates) {
            // var dates = ['2025-03-05','2025-03-15','2025-03-25'];
            dateArray = dates.split(",");
            jQuery(function(){
                jQuery('#tglPembelianBatu').datepicker({
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

        function tambah() {
            let tonase = $('#tonase').val();
            let jumlah_tonase = $('#jmlTonase').val();

            if (jumlah_tonase == '') {
                var jmlTonase = tonase;
            } else {
                var jmlTonase = parseFloat(jumlah_tonase) + parseFloat(tonase);
            }

            let id_pembelian = $('#id_pembelian').val();
            let id_pembelian_batu = $('#id_pembelian_batu').val();

            if (id_pembelian_batu == '') {
                var sumDataPembelian = [id_pembelian];
            } else {
                var sumDataPembelian = [id_pembelian_batu];
                sumDataPembelian.push(id_pembelian);
            }
            let idPembelian = sumDataPembelian.toString();

            let hargaSite = $('#hargaSite').val();
            let harga_di_site = $('#harga_di_site').val();
            let int_hargaSite = hargaSite.replace(/,/g, "");
            let int_harga_di_site = harga_di_site.replace(/,/g, "");

            if (int_harga_di_site == '') {
                var total_harga = int_hargaSite;
            } else {
                var total_harga = parseInt(int_harga_di_site) + parseInt(int_hargaSite);
            }

            let tglPembelian = $('#tglPembelianBatu').val();
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

            let harga = $('#harga').val();
            let sumHarga = $('#sumHarga').val();

            if (sumHarga == '') {
                var sum = harga;
            } else {
                if (sumHarga == harga) {
                    var sum = harga;
                } else {
                    var sum = sumHarga;
                    sum = sum+'|'+harga;
                }
            }

            // let dataPembelian = $('#dataPembelian').val();
            // let dataPembelianSite = $('#data_pembelian_site').val();

            // if (dataPembelianSite == '') {
            //     var sumData = [dataPembelian];
            // } else {
            //     var sumData = [dataPembelianSite];
            //     sumData.push(dataPembelian);
            // }
            // let data_pembelian_site = sumData.toString();

            // $('#data_pembelian_site').val(data_pembelian_site);

            $('#id_pembelian_batu').val(idPembelian);
            $('#tanggal_pembelian').val(tgl);
            $('#jmlTonase').val(jmlTonase);
            $('#sumHarga').val(sum);
            $('#harga_di_site').val(total_harga);
            $('#harga_di_site').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        }

        function reset() {
            $('#id_pembelian_batu').val("");
            $('#tanggal_pembelian').val("");
            $('#jmlTonase').val("");
            $('#sumHarga').val("");
            $('#harga_di_site').val("");
        }

        $('#tglPembelianBatu').change(function() {
            let tanggal = $(this).val();
            let id = $('#site').val();
            $.ajax({
                type: "GET",
                data: { site_id: id, tgl_pembelian: tanggal  },
                url: "{{ route('getDataPembelianbatu') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    $('#tonase').val(data.jumlah_tonase);
                    $('#hargaSite').val(data.total_penjualan);
                    
                    $('#harga').val(data.harga);
                    $('#harga').val(function (index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                    });
                    $('#id_pembelian').val(data.id_pembelian_batu);
                }
            });
        })

        $('#site').change(function () {
            let id = $(this).val();
            $.ajax({
                type: "GET",
                data: "site_id=" + id,
                url: "{{ route('getSite') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    let dates = data.tgl_pembelian;
                    colorDate(dates);
                }
            });
        });

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