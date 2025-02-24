@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Pengguna</h1>

    </div>

    <form action="{{ route('userSite.update', ['userSite' => $userSite]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama"
                            value="{{ $userSite->name }}">
                        @error('name')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username"
                            value="{{ $userSite->username }}">
                        @error('username')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Level</label>
                        <select class="form-select mb-3" name="level_id">
                            <option value="4" selected>Operator Site</option>
                        </select>
                        @error('level')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="#" onclick="self.history.back()" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>


@endsection