@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Pengeluaran Asean Untuk Site</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('pengeluaranSite.create') }}">
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
                                <th scope="col">Jumlah</th>
                                <th scope="col">Sumber Dana</th>
                                <th scope="col">Mode Transaksi</th>
                                <th scope="col">Bukti Transaksi</th>
                                <th scope="col">Tanggal</th>
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengeluaranSites as $pengeluaranSite)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pengeluaranSite->kode_transaksi }}</td>
                                    <td>{{ $pengeluaranSite->site?->nama_site }}</td>
                                    <td>{{ number_format($pengeluaranSite->jumlah) }}</td>
                                    <td>{{ $pengeluaranSite->sumber_dana }}</td>
                                    <td>{{ $pengeluaranSite->metode_transaksi }}</td>
                                    <td>
                                        @include('layouts.buktiTransaksi', ['tabel' => 'pengeluaranSite'])
                                    </td>
                                    <td>{{ $pengeluaranSite->tanggal }}</td>
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $pengeluaranSite->created_by }}</td>
                                        <td>{{ $pengeluaranSite->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $pengeluaranSite)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('pengeluaranSite.edit', ['pengeluaranSite' => $pengeluaranSite]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('pengeluaranSite.destroy', ['pengeluaranSite' => $pengeluaranSite]) }}"
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