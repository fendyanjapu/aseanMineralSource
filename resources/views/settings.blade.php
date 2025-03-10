@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Ubah Kata Sandi</h1>

    </div>
    <div style="margin: 0px 20px">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <form action="{{ route('settings.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="{{ auth()->user()->username }}"
                            readonly>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Kata Sandi Lama</label>
                        <input type="password" class="form-control" name="password" id="old_password"
                            placeholder="Kata Sandi Lama" required>
                        <input type="checkbox" onclick="showSandiLama()">Show Password
                        @error('password')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Kata Sandi Baru</label>
                        <input type="password" class="form-control" name="new_password" id="new_password"
                            placeholder="Kata Sandi Baru" required>
                        <input type="checkbox" onclick="showSandiBaru()">Show Password
                        @error('new_password')
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
                        <label>Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                            placeholder="Ulangi Kata Sandi Baru" required>
                        <input type="checkbox" onclick="showUlangiSandi()">Show Password
                        @error('confirm_password')
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

    <script>
        function showSandiLama() {
            var x = document.getElementById("old_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        function showSandiBaru() {
            var x = document.getElementById("new_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        function showUlangiSandi() {
            var x = document.getElementById("confirm_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>


@endsection