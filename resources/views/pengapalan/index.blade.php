@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Pengapalan</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('pengapalan.create') }}">
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
                                <th scope="col">Tanggal Pengapalan</th>
                                <th scope="col">Nama Tongkang</th>
                                <th scope="col">Site</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Tonase</th>
                                <th scope="col">Harga di Site</th>
                                <th scope="col">Harga Jual Pertonase</th>
                                <th scope="col">Document dll</th>
                                <th scope="col">Total Harga Penjualan</th>
                                <th scope="col">Laba Bersih</th>
                                @if (auth()->user()->level_id == 1)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengapalans as $pengapalan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pengapalan->kode_transaksi }}</td>
                                    <td>{{ date_format(date_create($pengapalan->tanggal_pengapalan), 'd-m-Y') }}</td>
                                    <td>{{ $pengapalan->nama_tongkang }}</td>
                                    <td>{{ $pengapalan->site?->nama_site }}</td>
                                    <td>{{ $pengapalan->harga }}</td>
                                    <td>{{ $pengapalan->tonase }}</td>
                                    <td>{{ $pengapalan->harga_di_site }}</td>
                                    <td>{{ $pengapalan->harga_jual_per_tonase }}</td>
                                    <td>{{ $pengapalan->document_dll }}</td>
                                    <td>{{ $pengapalan->total_harga_penjualan }}</td>
                                    <td>{{ $pengapalan->laba_bersih }}</td>
                                    @if (auth()->user()->level_id == 1)
                                        <td>{{ $pengapalan->created_by }}</td>
                                        <td>{{ $pengapalan->updated_by }}</td>
                                        <td>{{ $pengapalan->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $pengapalan)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('pengapalan.edit', ['pengapalan' => $pengapalan]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('pengapalan.destroy', ['pengapalan' => $pengapalan]) }}"
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