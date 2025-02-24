@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Tambah Data Karyawan</h1>

    </div>

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" placeholder="NIP" value="{{ old('nip') }}">
                        @error('nip')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="{{ old('jabatan') }}">
                        @error('jabatan')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Level</label>
                        <select class="form-select mb-3" name="level">
                            <option value="" selected></option>
                            <option value="Direksi">Direksi</option>
                            <option value="Admin">Admin</option>
                            <option value="Operator">Operator</option>
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

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>NIK</label>
                        <input type="text" class="form-control" name="nik" placeholder="NIK" value="{{ old('nik') }}">
                        @error('nik')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Jenis Kelamin</label>
                        <br>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" checked>
                                <span class="form-check-label">
                                    Laki-laki
                                </span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="P">
                                <span class="form-check-label">
                                    Perempuan
                                </span>
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Tangal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Tangal Masuk</label>
                        <input type="date" class="form-control" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                        @error('tanggal_masuk')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Status</label>
                        <input type="text" class="form-control" name="status" placeholder="Status" value="{{ old('status') }}">
                        @error('status')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </form>


@endsection