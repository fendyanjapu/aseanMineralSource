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

                <div class="card">
                    <div class="card-body">
                        <label>Site</label>
                        <div>
                            @foreach ($sites as $site)
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="site[]" value="{{ $site->id }}" {{ $siteUser[$site->id] }}>
                                    <span class="form-check-label">
                                        {{ $site->nama_site }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Checker</label>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_checker"
                                    value="1" {{ $userSite->is_checker == 1 ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    Ya
                                </span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_checker"
                                    value="0" {{ $userSite->is_checker != 1 ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    Tidak
                                </span>
                            </label>
                        </div>
                    </div>
                    @error('is_checker')
                        <div class="text-danger">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror
                </div>

                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="#" onclick="self.history.back()" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>


@endsection