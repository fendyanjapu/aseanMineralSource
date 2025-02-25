@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Site</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('site.create') }}">
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
                                <th scope="col">Nama Site</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Penganggung Jawab</th>
                                @if (auth()->user()->level_id == 1)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sites as $site)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $site->nama_site }}</td>
                                    <td>{{ $site->lokasi }}</td>
                                    <td>{{ $site->penanggung_jawab }}</td>
                                    @if (auth()->user()->level_id == 1)
                                        <td>{{ $site->created_by }}</td>
                                        <td>{{ $site->updated_by }}</td>
                                        <td>{{ $site->created_at }}</td>
                                    @endif

                                    @auth
                                        @can('update', $site)

                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('site.edit', ['site' => $site]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('site.destroy', ['site' => $site]) }}" method="post">
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