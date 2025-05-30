@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Kondisi Lapangan</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->level_id != 2)
                        <h5 class="card-title mb-0">
                            <a class="btn btn-primary" href="{{ route('kondisiLapangan.create') }}">
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
                                <th scope="col">Keterangan Kondisi Batu</th>
                                <th scope="col">Bukti Pelaporan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Nama Jetty</th>
                                <th scope="col">Site</th>
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kondisiLapangans as $kondisiLapangan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $kondisiLapangan->keterangan }}</td>
                                    <td><a href="{{ env('APP_URL') . '/upload/kondisiLapangan/' . $kondisiLapangan->bukti_pelaporan }}"
                                            target="_blank">Lihat</a></td>
                                    <td>{{ $kondisiLapangan->tanggal }}</td>
                                    <td>
                                        <a href="https://www.google.com/search?q={{ $kondisiLapangan->lokasi }}"
                                            target="_blank">
                                            {{ $kondisiLapangan->lokasi }}
                                        </a>
                                    </td>
                                    <td>{{ $kondisiLapangan->nama_jetty }}</td>
                                    <td>{{ $kondisiLapangan->site?->nama_site }}</td>
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $kondisiLapangan->created_by }}</td>
                                        <td>{{ $kondisiLapangan->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $kondisiLapangan)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('kondisiLapangan.edit', ['kondisiLapangan' => $kondisiLapangan]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form
                                                    action="{{ route('kondisiLapangan.destroy', ['kondisiLapangan' => $kondisiLapangan]) }}"
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