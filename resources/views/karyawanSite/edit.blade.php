@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data Karyawan Site</h1>

    </div>

    <form action="{{ route('karyawanSite.update', ['karyawanSite' => $karyawanSite]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" placeholder="NIP" value="{{ $karyawanSite->nip }}">
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
                        <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ $karyawanSite->nama }}">
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
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" value="{{ $karyawanSite->tempat_lahir }}">
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
                        <textarea class="form-control" name="alamat">{{ $karyawanSite->alamat }}</textarea>
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
                        <select class="form-control" name="jabatan">
                            <option value=""></option>
                            <option value="Operator" {{ $karyawanSite->jabatan == 'Operator' ? 'selected' : '' }}>Operator</option>
                            <option value="Mekanik" {{ $karyawanSite->jabatan == 'Mekanik' ? 'selected' : '' }}>Mekanik</option>
                            <option value="Helper Mekanik" {{ $karyawanSite->jabatan == 'Helper Mekanik' ? 'selected' : '' }}>Helper Mekanik</option>
                            <option value="Keamanan" {{ $karyawanSite->jabatan == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                        </select>
                        @error('jabatan')
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
                        <input type="text" class="form-control" name="nik" placeholder="NIK" value="{{ $karyawanSite->nik }}">
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
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" {{ $karyawanSite->jenis_kelamin == 'L' ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    Laki-laki
                                </span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" {{ $karyawanSite->jenis_kelamin == 'P' ? 'checked' : '' }}>
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
                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ $karyawanSite->tanggal_lahir }}">
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
                        <input type="date" class="form-control" name="tanggal_masuk" value="{{ $karyawanSite->tanggal_masuk }}">
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
                        <input type="text" class="form-control" name="status" placeholder="Status" value="{{ $karyawanSite->status }}">
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