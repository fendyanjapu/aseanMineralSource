@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Operasional Asean Mineral Source</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('operasional.create') }}">
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
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama Transaksi</th>
                                <th scope="col">Biaya</th>
                                <th scope="col">Bukti Transaksi</th>
                                
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operasionals as $operasional)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $operasional->kode_transaksi }}</td>
                                    <td>{{ date_format(date_create($operasional->tanggal), 'd-m-Y') }}</td>
                                    <td>{{ $operasional->nama_transaksi }}</td>
                                    <td>{{ number_format($operasional->biaya) }}</td>
                                    <td>
                                        @include('layouts.buktiTransaksi', ['tabel' => 'operasional'])
                                    </td>
                                    
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $operasional->created_by }}</td>
                                        <td>{{ $operasional->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $operasional)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('operasional.edit', ['operasional' => $operasional]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('operasional.destroy', ['operasional' => $operasional]) }}"
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