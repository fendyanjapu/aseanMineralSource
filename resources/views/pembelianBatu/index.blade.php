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
                                <th scope="col">#</th>
                                <th scope="col">Kode Transaksi</th>
                                <th scope="col">Site</th>
                                <th scope="col">Tanggal Pembelian</th>
                                <th scope="col">Tanggal Rotasi</th>
                                <th scope="col">Jumlah Tonase</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Total Penjualan</th>
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelianBatus as $pembelianBatu)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pembelianBatu->kode_transaksi }}</td>
                                    <td>{{ $pembelianBatu->site?->nama_site }}</td>
                                    <td>{{ date_format(date_create($pembelianBatu->tgl_pembelian), 'd-m-Y') }}</td>
                                    <?php $tgl_rotasi = str_replace(',','<br>', $pembelianBatu->tgl_rotasi) ?>
                                    <td>{!! $tgl_rotasi !!}</td>
                                    <td>{{ $pembelianBatu->jumlah_tonase }}</td>
                                    <td>{{ $pembelianBatu->harga }}</td>
                                    <td>{{ number_format($pembelianBatu->total_penjualan) }}</td>
                                    
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $pembelianBatu->created_by }}</td>
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