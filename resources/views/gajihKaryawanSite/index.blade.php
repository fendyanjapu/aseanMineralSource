@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Gajih Karyawan per Site</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('gajihKaryawanSite.create') }}">
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
                                <th scope="col">Gajih Periode</th>
                                <th scope="col">Total</th>
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gajihKaryawanSites as $gajihKaryawanSite)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $gajihKaryawanSite->kode_transaksi }}</td>
                                    <td>{{ $gajihKaryawanSite->karyawanSite?->nama }}</td>
                                    <td>{{ $gajihKaryawanSite->gajih_periode }}</td>
                                    <td>{{ $gajihKaryawanSite->total }}</td>
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $gajihKaryawanSite->created_by }}</td>
                                        <td>{{ $gajihKaryawanSite->created_at }}</td>
                                    @endif


                                    @auth
                                        @can('update', $gajihKaryawanSite)

                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('gajihKaryawanSite.edit', ['gajihKaryawanSite' => $gajihKaryawanSite]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form
                                                    action="{{ route('gajihKaryawanSite.destroy', ['gajihKaryawanSite' => $gajihKaryawanSite]) }}"
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