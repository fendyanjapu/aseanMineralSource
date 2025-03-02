@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Pembelian Batu Dari Site</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('pembelianBatu.create') }}">
                            <i class="align-middle" data-feather="plus-square"></i> <span class="align-middle">Tambah</span>
                        </a>
                    </h5>
                </div>
                <div style="margin: 0px 20px">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
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
                                @if (auth()->user()->level_id == 1)
                                    <th scope="col" rowspan="2">Created By</th>
                                    <th scope="col" rowspan="2">Updated By</th>
                                    <th scope="col" rowspan="2">Created At</th>
                                @endif
                                <th scope="col" rowspan="2" style="text-align: center">Action</th>
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
                                    
                                    @if (auth()->user()->level_id == 1)
                                        <td>{{ $pembelianBatu->created_by }}</td>
                                        <td>{{ $pembelianBatu->updated_by }}</td>
                                        <td>{{ $pembelianBatu->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $pembelianBatu)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('pembelianBatu.edit', ['pembelianBatu' => $pembelianBatu]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('pembelianBatu.destroy', ['pembelianBatu' => $pembelianBatu]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus data?')">Hapus</button>
                                                </form>
                                            </td>
                                        @else
                                            <td></td>
                                        @endcan
                                    @endauth
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection