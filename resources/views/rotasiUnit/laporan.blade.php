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
                                title: 'Laporan Produksi periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Laporan Produksi periode {{ $dariTanggal }} s.d {{ $sampaiTanggal }}',
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
    <h1 class="h3 mb-3">Laporan Produksi</h1>

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
                            @if (auth()->user()->level_id == 1)
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
                            @endif
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
                                <th scope="col">Jumlah Rotasi</th>
                                <th scope="col">Total Tonase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rotasiUnits as $rotasiUnit)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ $loop->iteration }}</th>
                                    <td>{{ $rotasiUnit->kode_transaksi }}</td>
                                    <td>{{ date_format(date_create($rotasiUnit->tanggal), 'd-m-Y') }}</td>
                                    <td>{{ number_format($rotasiUnit->jumlah_rotasi) }}</td>
                                    <td>{{ number_format($rotasiUnit->total_tonase) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection