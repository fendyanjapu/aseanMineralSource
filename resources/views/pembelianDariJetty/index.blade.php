@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Pembelian Batu Dari Jetty</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('pembelianDariJetty.create') }}">
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
                                <th scope="col">Nama Jetty</th>
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
                            @foreach ($pembelianDariJettys as $pembelianDariJetty)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pembelianDariJetty->kode_transaksi }}</td>
                                    <td>{{ $pembelianDariJetty->nama_jetty }}</td>
                                    <td>{{ date_format(date_create($pembelianDariJetty->tgl_pembelian), 'd-m-Y') }}</td>
                                    <?php $tgl_rotasi = str_replace(',','<br>', $pembelianDariJetty->tgl_rotasi) ?>
                                    <td>{!! $tgl_rotasi !!}</td>
                                    <td>{{ $pembelianDariJetty->jumlah_tonase }}</td>
                                    <td>{{ $pembelianDariJetty->harga }}</td>
                                    <td>{{ $pembelianDariJetty->total_penjualan }}</td>
                                    
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $pembelianDariJetty->created_by }}</td>
                                        <td>{{ $pembelianDariJetty->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $pembelianDariJetty)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('pembelianDariJetty.edit', ['pembelianDariJetty' => $pembelianDariJetty]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('pembelianDariJetty.destroy', ['pembelianDariJetty' => $pembelianDariJetty]) }}"
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