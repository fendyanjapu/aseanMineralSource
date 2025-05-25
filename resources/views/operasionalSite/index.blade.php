@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Operasional Site</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->level_id == 1 || auth()->user()->level_id == 4)
                        <h5 class="card-title mb-0">
                            <a class="btn btn-primary" href="{{ route('operasionalSite.create') }}">
                                <i class="align-middle" data-feather="plus-square"></i> <span class="align-middle">Tambah</span>
                            </a>
                        </h5>
                    @endif
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
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Transaksi</th>
                                <th scope="col">Biaya</th>
                                <th scope="col">Bukti Transaksi</th>
                                <th scope="col">Site</th>
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operasionalSites as $operasionalSite)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $operasionalSite->kode_transaksi }}</td>
                                    <td>{{ date_format(date_create($operasionalSite->tanggal), 'd-m-Y') }}</td>
                                    <td>{{ $operasionalSite->nama_transaksi }}</td>
                                    <td>{{ number_format($operasionalSite->biaya) }}</td>
                                    <td>
                                        @include('layouts.buktiTransaksi', ['tabel' => 'operasionalSite'])
                                    </td>
                                    <td>{{ $operasionalSite->site?->nama_site }}</td>
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $operasionalSite->created_by }}</td>
                                        <td>{{ $operasionalSite->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $operasionalSite)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('operasionalSite.edit', ['operasionalSite' => $operasionalSite]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('operasionalSite.destroy', ['operasionalSite' => $operasionalSite]) }}"
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