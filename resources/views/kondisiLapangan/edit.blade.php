@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Kondisi Lapangan</h1>

    </div>

    <form action="{{ route('kondisiLapangan.update', ['kondisiLapangan' => $kondisiLapangan]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Keterangan Kondisi Batu</label>
                        <textarea name="keterangan" id="keterangan" class="form-control"
                            placeholder="Keterangan Kondisi Batu">{{ $kondisiLapangan->keterangan }}</textarea>
                        @error('keterangan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Lokasi</label>
                        <p onclick="getLocation()" class="btn btn-info btn-sm">Get Location</p>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" value="{{ $kondisiLapangan->lokasi }}" readonly>
                        @error('lokasi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama Jetty</label>
                        <input type="text" class="form-control" name="nama_jetty" placeholder="Nama Jetty"
                            value="{{ $kondisiLapangan->nama_jetty }}">
                        @error('nama_jetty')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" placeholder="Tanggal"
                            value="{{ $kondisiLapangan->tanggal }}">
                        @error('tanggal')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Site</label>
                        <select name="site_id" id="" class="form-control">
                            <option value=""></option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" {{ $site->id == $kondisiLapangan->site_id ? 'selected' : '' }}>
                                    {{ $site->nama_site }}
                                </option>
                            @endforeach
                        </select>
                        @error('site_id')
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

        var x = document.getElementById("lokasi");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.value = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.value = position.coords.latitude +
                " " + position.coords.longitude;
        }

    </script>

@endsection