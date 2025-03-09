@extends('layouts.template')

@section('content')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <h1 class="h3 mb-3">Data Pembayaran Penjualan</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <a class="btn btn-primary" href="{{ route('pembayaranPenjualan.create') }}">
                            <i class="align-middle" data-feather="plus-square"></i> <span class="align-middle">Tambah</span>
                        </a>
                    </h5>
                    <br>
                    <form action="">
                        <div class="mb-3 col-lg-3">
                            <table>
                                <tr>
                                    <td>
                                        <p>Site</p>
                                        <select name="site_id" id="site_id" class="form-control" required>
                                            <option value=""></option>
                                            @foreach ($sites as $site)
                                                <option value="{{ $site->id }}">
                                                    {{ $site->nama_site }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <p>Total Hutang Site</p>
                                        <input type="text" class="form-control" id="total_hutang" readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
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
                                <th scope="col">Kode Transaksi</th>
                                <th scope="col">Data Pembelian Site</th>
                                <th scope="col">Tanggal Pembelian</th>
                                <th scope="col">Tonase</th>
                                <th scope="col">Total Harga Pembelian</th>
                                <th scope="col">Dana Operasional Site</th>
                                <th scope="col">Tanggal Transfer ke Site</th>
                                <th scope="col">Jumlah Hutang Site</th>
                                <th scope="col">Total Pembayaran Site</th>
                                <th scope="col">Tanggal Transaksi</th>
                                <th scope="col">Bukti Transaksi</th>
                                <th scope="col">Sisa Hutang Site</th>
                                @if (auth()->user()->level_id == 2)
                                    <th scope="col" style="text-align: center">Action</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaranPenjualans as $pembayaranPenjualan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pembayaranPenjualan->kode_transaksi }}</td>
                                    <td>{{ $pembayaranPenjualan->pembelianBatu?->kode_transaksi }}</td>
                                    <td>{{ $pembayaranPenjualan->pembelianBatu?->tgl_pembelian }}</td>
                                    <td>{{ $pembayaranPenjualan->pembelianBatu?->jumlah_tonase }}</td>
                                    <td>{{ $pembayaranPenjualan->pembelianBatu?->total_penjualan }}</td>
                                    <td>
                                        {{ $pembayaranPenjualan->pemasukan?->kode_transaksi }} |
                                        {{ $pembayaranPenjualan->pemasukan?->sumber_dana }}
                                    </td>
                                    <td>{{ $pembayaranPenjualan->pemasukan?->tanggal }}</td>
                                    <td>{{ $pembayaranPenjualan->pemasukan?->jumlah }}</td>
                                    <td>{{ $pembayaranPenjualan->total_pembayaran_site }}</td>
                                    <td>{{ date_format(date_create($pembayaranPenjualan->tanggal_transaksi), 'd-m-Y') }}</td>
                                    <td><a href="{{ env('APP_URL') . '/upload/pembayaranPenjualan/' . $pembayaranPenjualan->bukti_transaksi }}"
                                            target="_blank">Lihat</a></td>
                                    <td>{{ $pembayaranPenjualan->sisa_hutang_site }}</td>

                                    @auth
                                        @can('update', $pembayaranPenjualan)
                                            <td style="display: flex; justify-content: center;">
                                                <a href="{{ route('pembayaranPenjualan.edit', ['pembayaranPenjualan' => $pembayaranPenjualan]) }}"
                                                    class="btn btn-success btn-sm">Edit</a>

                                                <form
                                                    action="{{ route('pembayaranPenjualan.destroy', ['pembayaranPenjualan' => $pembayaranPenjualan]) }}"
                                                    method="post">
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

    <script>
        $('#site_id').change(function (event) {
            site_id = $(this).val();
            $.ajax({
                type: "GET",
                data: { site_id: site_id },
                url: "{{ route('getTotalHutang') }}",
                cache: false,
                success: function (result) {
                    let data = $.parseJSON(result);
                    $("#total_hutang").val(data);
                    $('#total_hutang').val(function (index, value) {
                        return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                    });
                }
            });
        });
    </script>
@endsection