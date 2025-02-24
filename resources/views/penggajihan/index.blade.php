@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Penggajihan</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('penggajihan.create') }}">
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
                                <th scope="col">Nama Karyawan</th>
                                <th scope="col">Periode Gajih</th>
                                <th scope="col">Total</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Bukti Transaksi</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Updated By</th>
                                @if (auth()->user()->level != 'Operator')
                                <th scope="col">Created At</th>
                                    <th scope="col" style="text-align: center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggajihans as $penggajihan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $penggajihan->kode_transaksi }}</td>
                                    <td>{{ $penggajihan->karyawan->nama }}</td>
                                    <td>{{ $penggajihan->periode_gajih }}</td>
                                    <td>{{ $penggajihan->total }}</td>
                                    <td>{{ $penggajihan->tanggal }}</td>
                                    <td><a href="{{ env('APP_URL').'/upload/penggajihan/'.$penggajihan->bukti_transaksi }}" target="_blank">Lihat</a></td>
                                    <td>{{ $penggajihan->created_by }}</td>
                                    <td>{{ $penggajihan->updated_by }}</td>
                                    @auth
                                        @can('update', $penggajihan)
                                        <td>{{ $penggajihan->created_at }}</td>
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('penggajihan.edit', ['penggajihan' => $penggajihan]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('penggajihan.destroy', ['penggajihan' => $penggajihan]) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus data?')">Hapus</button>
                                                </form>
                                            </td>
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