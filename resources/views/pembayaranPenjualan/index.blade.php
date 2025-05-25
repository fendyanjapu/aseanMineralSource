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
                                <th scope="col">Site</th>
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
                                @if (auth()->user()->level_id < 3)
                                    <th scope="col">Created By</th>
                                    <th scope="col">Created At</th>
                                @endif
                                <th scope="col" style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaranPenjualans as $pembayaranPenjualan)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $pembayaranPenjualan->kode_transaksi }}</td>
                                    <td>{{ $pembayaranPenjualan->site?->nama_site }}</td>
                                    <?php $data_pembelian_site = str_replace(',','<br>', $pembayaranPenjualan->data_pembelian_site) ?>
                                    <td>{!! $data_pembelian_site !!}</td>
                                    <?php $tanggal_pembelian = str_replace(',','<br>', $pembayaranPenjualan->tanggal_pembelian) ?>
                                    <td>{!! $tanggal_pembelian !!}</td>
                                    <td>{{ $pembayaranPenjualan->tonase }}</td>
                                    <td>{{ $pembayaranPenjualan->total_harga_pembelian }}</td>
                                    <?php $dana_operasional_site = str_replace(',','<br>', $pembayaranPenjualan->dana_operasional_site) ?>
                                    <td>{!! $dana_operasional_site !!}</td>
                                    <?php $tanggal_transfer_ke_site = str_replace(',','<br>', $pembayaranPenjualan->tanggal_transfer_ke_site) ?>
                                    <td>{!! $tanggal_transfer_ke_site !!}</td>
                                    <td>{{ $pembayaranPenjualan->jumlah_hutang_site }}</td>
                                    <td>{{ $pembayaranPenjualan->total_pembayaran_site }}</td>
                                    <td>{{ $pembayaranPenjualan->tanggal_transaksi }}</td>
                                    <td>
                                        @include('layouts.buktiTransaksi', ['tabel' => 'pembayaranPenjualan'])
                                    </td>
                                    <td>{{ $pembayaranPenjualan->sisa_hutang_site }}</td>
                                    @if (auth()->user()->level_id < 3)
                                        <td>{{ $pembayaranPenjualan->created_by }}</td>
                                        <td>{{ $pembayaranPenjualan->created_at }}</td>
                                    @endif
                                    @auth
                                        @can('update', $pembayaranPenjualan)
                                            <td style="display: flex; justify-content: center;">
                                                {{-- <a href="{{ route('pembayaranPenjualan.edit', ['pembayaranPenjualan' => $pembayaranPenjualan]) }}"
                                                    class="btn btn-success btn-sm">Edit</a> --}}

                                                <form
                                                    action="{{ route('pembayaranPenjualan.destroy', ['pembayaranPenjualan' => $pembayaranPenjualan]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus data?')">Hapus</button>
                                                </form>
                                            </td>
                                        @else
                                            <td></td>
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
                    $("#total_hutang").val(data.total_hutang);
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