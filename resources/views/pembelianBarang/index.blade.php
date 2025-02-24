@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Pembelian Barang</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('pembelianBarang.create') }}">
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
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Tanggal Pembelian</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Bukti Transaksi</th>
                                @if (auth()->user()->level_id == 1)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Created At</th>
                                @endif

                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelianBarangs as $pembelianBarang)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pembelianBarang->kode_transaksi }}</td>
                                    <td>{{ $pembelianBarang->barang?->nama }}</td>
                                    <td>{{ $pembelianBarang->jumlah }}</td>
                                    <td>{{ $pembelianBarang->harga_satuan }}</td>
                                    <td>{{ $pembelianBarang->total_harga }}</td>
                                    <td>{{ $pembelianBarang->tanggal }}</td>
                                    <td>{{ $pembelianBarang->keterangan }}</td>
                                    <td><a href="{{ env('APP_URL') . '/upload/pembelianBarang/' . $pembelianBarang->bukti_transaksi }}"
                                            target="_blank">Lihat</a></td>
                                    @if (auth()->user()->level_id == 1)
                                        <td>{{ $pembelianBarang->created_by }}</td>
                                        <td>{{ $pembelianBarang->updated_by }}</td>
                                        <td>{{ $pembelianBarang->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $pembelianBarang)

                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('pembelianBarang.edit', ['pembelianBarang' => $pembelianBarang]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form
                                                    action="{{ route('pembelianBarang.destroy', ['pembelianBarang' => $pembelianBarang]) }}"
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