@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Unit</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('unit.create') }}">
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
                                <th scope="col">Kode</th>
                                <th scope="col">No Identitas Unit</th>
                                <th scope="col">Spefikasi</th>
                                <th scope="col">Merk</th>
                                <th scope="col">Tanggal Pembelian</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Updated By</th>
                                @if (auth()->user()->level != 'Operator')
                                <th scope="col">Created At</th>
                                    <th scope="col" style="text-align: center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $unit->kode }}</td>
                                    <td>{{ $unit->no_identitas_unit }}</td>
                                    <td>{{ $unit->spesifikasi }}</td>
                                    <td>{{ $unit->merk }}</td>
                                    <td>{{ $unit->tanggal_pembelian }}</td>
                                    <td>{{ $unit->harga }}</td>
                                    <td>{{ $unit->created_by }}</td>
                                    <td>{{ $unit->updated_by }}</td>
                                    @auth
                                        @can('update', $unit)
                                        <td>{{ $unit->created_at }}</td>
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('unit.edit', ['unit' => $unit]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form action="{{ route('unit.destroy', ['unit' => $unit]) }}" method="post">
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