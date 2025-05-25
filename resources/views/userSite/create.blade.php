@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Pengguna Site</h1>

    </div>

    <form action="{{ route('userSite.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nama">
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
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                            placeholder="Username">
                        @error('username')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        <br>
                        <input type="checkbox" onclick="myFunction()">Show Password
                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                                <small>
                                    Must be at least 8 characters in length,
                                    must contain at least one lowercase letter,
                                    must contain at least one uppercase letter,
                                    must contain at least one digit,
                                    must contain a special character.
                                </small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Level</label>
                        <select class="form-select mb-3" name="level_id" readlony>
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
                                    <input class="form-check-input" type="checkbox" name="site[]" value="{{ $site->id }}">
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
                                    value="1" checked>
                                <span class="form-check-label">
                                    Ya
                                </span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_checker"
                                    value="0">
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
                
            </div>
        </div>

        <button class="btn btn-success" type="submit">Simpan</button>
        <a href="#" onclick="self.history.back()" class="btn btn-danger">Batal</a>
        </div>
        </div>
    </form>

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

@endsection