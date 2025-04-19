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
        <h1 class="h3 d-inline align-middle">Edit Data Pembelian Batu Dari Jetty</h1>

    </div>

    <form action="{{ route('pembelianDariJetty.update', ['pembelianDariJetty' => $pembelianDariJetty]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly
                            value="{{ $pembelianDariJetty->kode_transaksi }}">
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
                            value="{{ $pembelianDariJetty->tgl_pembelian }}">
                        @error('tgl_pembelian')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Jetty</label>
                        <input type="text" class="form-control col-lg-3" name="nama_jetty"
                            value="{{ $pembelianDariJetty->nama_jetty }}">
                        @error('nama_jetty')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jumlah Tonase</label>
                        <input type="number" class="form-control" name="jumlah_tonase" id="jumlah_tonase" placeholder="Jumlah Tonase" step=".01"
                            value="{{ $pembelianDariJetty->jumlah_tonase }}">
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
                            value="{{ $pembelianDariJetty->harga }}">
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
                            value="{{ $pembelianDariJetty->total_penjualan }}" readonly>
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

        $("#jumlah_tonase").keyup(function (event) {
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

        function totalPenjualan() {
            let harga = $("#harga").val();
            let jumlah_tonase = $("#jumlah_tonase").val();
            let int_harga = harga.replace(/,/g, "");
            let float_jumlah_tonase = parseFloat(jumlah_tonase).toFixed(2);
            let float_int_harga = parseFloat(int_harga).toFixed(2);

            let total_penjualan = float_jumlah_tonase * float_int_harga;

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