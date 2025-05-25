@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Ganti Site</h1>

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

    <form action="{{ route('settings.relogin') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Site</label>
                        <select class="form-control" name="site_id">
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->site_id }}" {{ $site->site_id == Session::get('site_id') ? 'selected' : '' }}>
                                    {{ $site->site->nama_site }}
                                </option>
                            @endforeach
                        </select>
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