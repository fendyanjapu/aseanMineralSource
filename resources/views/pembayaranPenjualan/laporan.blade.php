@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            new DataTable('#myTable', {
                layout: {
                    topStart: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                title: 'Laporan Pembayaran Penjualan periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Laporan Pembayaran Penjualan periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}',
                                orientation: 'landscape',
                                customize: function (doc) {
                                    doc.content[1].margin = [ 50, 0, 20, 0 ];
                                }
                            }
                        ]
                    }
                }
            });
        });
    </script>
    <h1 class="h3 mb-3">Laporan Pembayaran Penjualan</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="">
                        <div class="mb-3 col-lg-3">
                            <p>Periode:</p>
                            <table>
                                <tr>
                                    <td><input type="date" class="form-control" name="dari_tanggal"
                                            value="{{ $dariTanggal }}" required></td>
                                    <td style="width: 100px; text-align: center;">
                                        <p>s.d</p>
                                    </td>
                                    <td><input type="date" class="form-control" name="sampai_tanggal"
                                            value="{{ $sampaiTanggal }}" required></td>
                                </tr>
                            </table>
                            <br>
                            <p>Site:</p>
                            <select name="site_id" id="" class="form-control" required>
                                <option value=""></option>
                                <option value="all" {{ $site_id == 'all' ? 'selected' : '' }}>Semua</option>
                                @foreach ($sites as $site)
                                    <option value="{{ $site->id }}" {{ $site_id == $site->id ? 'selected' : '' }}>
                                        {{ $site->nama_site }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Transaksi</th>
                                <th scope="col">Nama Site</th>
                                <th scope="col">Tanggal Transaksi Penjualan</th>
                                <th scope="col">Tanggal Transaksi Pembayaran Penjualan Site</th>
                                <th scope="col">Tanggal Transaksi Pengeluaran Site</th>
                                <th scope="col">Tonase</th>
                                <th scope="col">Kredit (diambil dari data pembayaran penjualan site)</th>
                                <th scope="col">Debit (diambil dari data pengeluaran site)</th>
                                <th scope="col">Total Biaya</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaranPenjualans as $pembayaranPenjualan)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ $loop->iteration }}</th>
                                    <td>{{ $pembayaranPenjualan->kode_transaksi }}</td>
                                    <td>{{ $pembayaranPenjualan->site?->nama_site }}</td>
                                    <td>{{ $pembayaranPenjualan->tanggal_pembelian }}</td>
                                    <td>{{ $pembayaranPenjualan->tanggal_transaksi }}</td>
                                    <td>{{ $pembayaranPenjualan->tanggal_transfer_ke_site }}</td>
                                    <td>{{ $pembayaranPenjualan->tonase }}</td>
                                    <td>{{ $pembayaranPenjualan->total_harga_pembelian }}</td>
                                    <td>{{ $pembayaranPenjualan->jumlah_hutang_site }}</td>
                                    <td>{{ $pembayaranPenjualan->total_pembayaran_site }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection