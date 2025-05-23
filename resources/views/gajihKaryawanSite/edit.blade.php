@extends('layouts.template')

@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Edit Data gajihKaryawanSite</h1>

    </div>

    <form action="{{ route('gajihKaryawanSite.update', ['gajihKaryawanSite' => $gajihKaryawanSite]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <label>Kode Transaksi</label>
                        <input type="text" class="form-control" name="kode_transaksi" readonly
                            value="{{ $gajihKaryawanSite->kode_transaksi }}">
                        @error('kode_transaksi')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Karyawan</label>
                        <select class="form-control" name="karyawan_site_id" id="karyawan_site_id">
                            <option value=""></option>
                            @foreach ($karyawanSites as $item)
                                <option value="{{ $item->id }}" {{ $gajihKaryawanSite->karyawan_site_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('karyawan_site_id')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label>Gajih Periode</label>
                        <input type="text" class="form-control" name="gajih_periode"
                            value="{{ $gajihKaryawanSite->gajih_periode }}">
                        @error('gajih_periode')
                            <div class="text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card">

                    <div class="card-body">
                        <label>Total</label>
                        <input type="text" class="form-control" name="total" id="total"
                            value="{{ $gajihKaryawanSite->total }}">
                        @error('total')
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
        $('#total').keyup(function (event) {

            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function (index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });

        $(function(){
            $('#karyawan_site_id').select2();
        })
    </script>


@endsection