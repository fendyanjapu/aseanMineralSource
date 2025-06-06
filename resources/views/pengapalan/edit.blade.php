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

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal Pembelian</label>
                        <input type="text" class="form-control" name="tanggal_pembelian" id="tanggal_pembelian" placeholder="Tanggal Pembelian"
                            value="{{ $pengapalan->tanggal_pembelian }}" readonly>
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
                            placeholder="Harga" value="{{ $pengapalan->harga }}" readonly>
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
                        <label>Pembelian Dari Jetty</label>
                        <select name="pembelian_dari_jetty_id" id="pembelian_dari_jetty_id" class="form-control">
                            <option value=""></option>
                            @foreach ($pembelianDariJetty as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $pengapalan->pembelian_dari_jetty_id ? 'selected' : '' }}>
                                    {{ $item->kode_transaksi }} | {{ $item->tgl_pembelian }} | {{ $item->nama_jetty }}
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
                        <label>Biaya Jetty</label>
                        <input type="text" class="form-control" name="biaya_jetty" id="biaya_jetty" placeholder="Biaya Jetty"
                            value="{{ $pengapalan->biaya_jetty }}">
                        @error('biaya_jetty')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Biaya Dokumen</label>
                        <input type="text" class="form-control" name="biaya_dokumen" id="biaya_dokumen" placeholder="Biaya Dokumen"
                            value="{{ $pengapalan->biaya_dokumen }}">
                        @error('biaya_dokumen')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Biaya Operasional dll</label>
                        <input type="text" class="form-control" name="biaya_operasional_dll" id="biaya_operasional_dll" placeholder="Biaya Operasional dll"
                            value="{{ $pengapalan->biaya_operasional_dll }}">
                        @error('biaya_dokumen')
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
                        <label>Total Harga Penjualan</label>
                        <input type="text" class="form-control" name="total_harga_penjualan" id="total_harga_penjualan"
                            placeholder="Total Harga Penjualan" value="{{ $pengapalan->total_harga_penjualan }}" 
                            {{ auth()->user()->level_id != 2 ? 'readonly' : '' }}>
                        <small>*diinput direksi</small>
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
        $('a.buton').click(function (e) {
            e.preventDefault();
        });

        $(function(){
            $('#pembelian_dari_jetty_id').select2();
        })
        		
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
            labaBersih();
        }

        function reset() {
            $('#id_pembelian_batu').val("");
            $('#tanggal_pembelian').val("");
            $('#jmlTonase').val("");
            $('#sumHarga').val("");
            $('#harga_di_site').val("");
            labaBersih();
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
            labaBersih();
		});

        $('#biaya_jetty').keyup(function(){
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            labaBersih();
		});

        $('#biaya_dokumen').keyup(function(){
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            labaBersih();
		});

        $('#biaya_operasional_dll').keyup(function(){
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            labaBersih();
		});

        $('#total_harga_penjualan').keyup(function(){
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
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

        $(document).ready(function(){
            $('#total_harga_penjualan').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });

        function labaBersih() {
            let total_harga_penjualan = $('#total_harga_penjualan').val();
            let harga_di_site = $('#harga_di_site').val();
            let biaya_jetty = $('#biaya_jetty').val();
            let biaya_dokumen = $('#biaya_dokumen').val();
            let biaya_operasional_dll = $('#biaya_operasional_dll').val();
            let int_total_harga_penjualan = total_harga_penjualan.replace(/,/g, "");
            let int_harga_di_site = harga_di_site.replace(/,/g, "");
            let int_biaya_jetty = biaya_jetty.replace(/,/g, "");
            let int_biaya_dokumen = biaya_dokumen.replace(/,/g, "");
            let int_biaya_operasional_dll = biaya_operasional_dll.replace(/,/g, "");

            let laba_bersih = parseInt(int_total_harga_penjualan) 
                            - parseInt(int_harga_di_site)
                            - parseInt(int_biaya_jetty)
                            - parseInt(int_biaya_dokumen)
                            - parseInt(int_biaya_operasional_dll);

            $('#laba_bersih').val(laba_bersih);
            $('#laba_bersih').val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            if (laba_bersih < 0) {
                let val_laba_bersih = $('#laba_bersih').val();
                val_laba_bersih = "- "+val_laba_bersih;
                $('#laba_bersih').val(val_laba_bersih);
            }
        }
    </script>

@endsection