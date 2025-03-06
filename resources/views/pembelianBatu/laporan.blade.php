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
                                title: 'Laporan Pembelian Batu Dari Site periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Laporan Pembelian Batu Dari Site periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}'
                            }
                        ]
                    }
                }
            });
        });
    </script>
    <h1 class="h3 mb-3">Laporan Pembelian Batu Dari Site</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="">
                        <div class="col-3 col-lg-3">
                            <p>Periode:</p>
                            <input type="date" class="form-control" name="dari_tanggal" value="{{ $dariTanggal }}" required>
                            <p>s.d</p>
                            <input type="date" class="form-control" name="sampai_tanggal" value="{{ $sampaiTanggal }}"
                                required>
                        </div>
                        <br>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2">#</th>
                                <th scope="col" rowspan="2">Kode Transaksi</th>
                                <th scope="col" rowspan="2">Site</th>
                                <th scope="col" rowspan="2">Nama Jetty</th>
                                <th scope="col" colspan="2">Tanggal Rotasi</th>
                                <th scope="col" rowspan="2">Jumlah Tonase</th>
                                <th scope="col" rowspan="2">Harga</th>
                                <th scope="col" rowspan="2">Jetty</th>
                                <th scope="col" rowspan="2">Document dll</th>
                                <th scope="col" rowspan="2">Total Penjuanan</th>

                            </tr>
                            <tr>
                                <th scope="col">Dari</th>
                                <th scope="col">Sampai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelianBatus as $pembelianBatu)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pembelianBatu->kode_transaksi }}</td>
                                    <td>{{ $pembelianBatu->site?->nama_site }}</td>
                                    <td>{{ $pembelianBatu->nama_jetty }}</td>
                                    <td>{{ date_format(date_create($pembelianBatu->tgl_rotasi_dari), 'd-m-Y') }}</td>
                                    <td>{{ date_format(date_create($pembelianBatu->tgl_rotasi_sampai), 'd-m-Y') }}</td>
                                    <td>{{ $pembelianBatu->jumlah_tonase }}</td>
                                    <td>{{ $pembelianBatu->harga }}</td>
                                    <td>{{ $pembelianBatu->jetty }}</td>
                                    <td>{{ $pembelianBatu->document_dll }}</td>
                                    <td>{{ $pembelianBatu->total_penjualan }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection