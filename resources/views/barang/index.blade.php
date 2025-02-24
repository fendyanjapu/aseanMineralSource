@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Barang</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('barang.create') }}">
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
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Merk</th>
                                <th scope="col">Spesifikasi</th>
                                <th scope="col">Kisaran Harga</th>
                                @if (auth()->user()->level_id < 2)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                @endif

                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created At</th>
                                    <th scope="col" style="text-align: center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $barang)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $barang->kode }}</td>
                                    <td>{{ $barang->nama }}</td>
                                    <td>{{ $barang->merk }}</td>
                                    <td>{{ $barang->spesifikasi }}</td>
                                    <td>{{ $barang->kisaran_harga }}</td>
                                    @if (auth()->user()->level_id < 2)
                                        <td>{{ $barang->created_by }}</td>
                                        <td>{{ $barang->updated_by }}</td>
                                    @endif

                                    @auth
                                        @can('update', $barang)
                                            <td>{{ $barang->created_at }}</td>
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('barang.edit', ['barang' => $barang]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('barang.destroy', ['barang' => $barang]) }}" method="post">
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