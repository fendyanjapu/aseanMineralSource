@extends('layouts.template')

@section('content')
<style>
	.box {
		height: 150px;
	}
</style>

@if (auth()->user()->level_id < 4)
<h2 class="h3 mb-3">Informasi Keuangan</h2>
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Pemasukan Asean Mineral Source</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">Rp {{ number_format($pemasukan) }}</h2>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Pengeluaran Asean Mineral Source</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">Rp {{ number_format($pengeluaran) }}</h2>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Saldo Asean Mineral Source</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">Rp {{ number_format($saldo) }}</h2>
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>
@endif

@if (auth()->user()->level_id < 3)
<br>
<h2 class="h3 mb-3">Informasi Penjualan</h2>
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Pembelian Dari Site + Jetty<br>(Rupiah & Tonase)</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">Rp {{ number_format($totalPembelianRP) }}</h2>
							<h2 class="card-title">Tonase {{ $totalPembelianTonase }}</h2>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Pengapalan<br>(Rupiah & Tonase)</h5>
								</div>
							</div>
							<br>
							{{-- <h2 class="card-title">Rp {{ number_format($pengapalanRP) }}</h2>
							<h2 class="card-title">Tonase {{ $pengapalanTonase }}</h2> --}}
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Tonase yang Masih Belum Pengapalan (Tonase)</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title"></h2>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Laba Bersih</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title"></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

<br>
<h2 class="h3 mb-3">Informasi Produksi Site</h2>
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Nama Site</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">
								<select name="" id="siteProduksi" class="form-control">
									<option value=""></option>
									@foreach ($sites as $site)
									<option value="{{ $site->id }}">{{ $site->nama_site }}</option>
									@endforeach
								</select>
							</h2>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Tonase Produksi</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="tonaseProduksi"></h2>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<br>
<h2 class="h3 mb-3">Informasi Hutang Site</h2>
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Nama Site</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">
								<select name="" id="siteHutang" class="form-control">
									<option value=""></option>
									@foreach ($sites as $site)
									<option value="{{ $site->id }}">{{ $site->nama_site }}</option>
									@endforeach
								</select>
							</h2>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Hutang</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="totalHutang"></h2>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Pembayaran Hutang</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="pembayaranHutang"></h2>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Sisa Hutang</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="sisaHutang"></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<br>
<h2 class="h3 mb-3">Informasi Pengeluaran Site</h2>
<div class="row">
	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Nama Site</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title">
								<select name="" id="sitePengeluaran" class="form-control">
									<option value=""></option>
									@foreach ($sites as $site)
									<option value="{{ $site->id }}">{{ $site->nama_site }}</option>
									@endforeach
								</select>
							</h2>
						</div>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Pemasukan Site</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="pemasukanSite"></h2>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-xxl-5 d-flex">
		<div class="w-100">
			<div class="row">
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Total Pengeluaran Site</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="operasionalSite"></h2>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="card box">
						<div class="card-body">
							<div class="row">
								<div class="col mt-0">
									<h5 class="card-title">Saldo Site</h5>
								</div>
							</div>
							<br>
							<h2 class="card-title" id="saldoSite"></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	$('#siteProduksi').change(function(){
		let site_id = $(this).val();
		$.ajax({
			type: "GET",
                data: { site_id: site_id },
                url: "{{ route('getProduksiTonase') }}",
                cache: false,
                success: function (result) {
					let data = $.parseJSON(result);
					$('#tonaseProduksi').text(data.jumlahTonase);
				}
		});
	})
	$('#siteHutang').change(function(){
		let site_id = $(this).val();
		$.ajax({
			type: "GET",
                data: { site_id: site_id },
                url: "{{ route('getHutangSite') }}",
                cache: false,
                success: function (result) {
					let data = $.parseJSON(result);
					$('#totalHutang').text('Rp '+data.totalHutang);
					$('#pembayaranHutang').text('Rp '+data.pembayaranHutang);
					$('#sisaHutang').text('Rp '+data.sisaHutang);
				}
		});
	})
	$('#sitePengeluaran').change(function(){
		let site_id = $(this).val();
		$.ajax({
			type: "GET",
                data: { site_id: site_id },
                url: "{{ route('getPengeluaranSiteDash') }}",
                cache: false,
                success: function (result) {
					let data = $.parseJSON(result);
					$('#pemasukanSite').text('Rp '+data.pemasukanSite);
					$('#operasionalSite').text('Rp '+data.operasionalSite);
					$('#saldoSite').text('Rp '+data.saldoSite);
				}
		});
	})
</script>
@endsection