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
                                title: 'Laporan Pengeluaran periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Laporan Pengeluaran periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}',
                                orientation: 'landscape',
                                customize: function (doc) {
                                    doc.content[1].margin = [0, 0, 20, 0];
                                }
                            }
                        ]
                    }
                }
            });
        });
    </script>
    <h1 class="h3 mb-3">Laporan Pengeluaran</h1>

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
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jenis Pengeluaran</th>
                                <th scope="col">Barang/Unit</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            @foreach ($pembelianBarangs as $pembelianBarang)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no }}</th>
                                    <td>{{ $pembelianBarang->kode_transaksi }}</td>
                                    <td>{{ $pembelianBarang->tanggal }}</td>
                                    <td>Pembelian Barang</td>
                                    <td>{{ $pembelianBarang->barang?->nama }}</td>
                                    <td>{{ $pembelianBarang->total_harga }}</td>
                                </tr>
                            @endforeach
                            @foreach ($perbaikanUnits as $perbaikanUnit)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no }}</th>
                                    <td>{{ $perbaikanUnit->kode_transaksi }}</td>
                                    <td>{{ $perbaikanUnit->tanggal }}</td>
                                    <td>Perbaikan Unit</td>
                                    <td>{{ $perbaikanUnit->unit?->merk."-".$perbaikanUnit->unit?->no_identitas_unit }}</td>
                                    <td>{{ $perbaikanUnit->total_harga }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection