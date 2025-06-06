<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords"
		content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('assetsHome/img/logo.png') }}" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Asean Mineral Source</title>

	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

	<script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
	<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.dataTables.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.dataTables.css">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
					<span class="align-middle">Asean Mineral Source</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Dashboard
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('dashboard') }}">
							<i class="align-middle" data-feather="sliders"></i> <span
								class="align-middle">Dashboard</span>
						</a>
					</li>

					@if (auth()->user()->level_id < 3)
						<li class="sidebar-header">
							Data Master
						</li>

						<li class="sidebar-item dropdown">
							<a class="sidebar-link dropdown-toggle d-none d-sm-inline-block" href="#"
								data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="user"></i> <span class="align-middle">Data
									Pengguna</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="{{ route('user.index') }}"><i class="align-middle me-1"
										data-feather="user"></i>
									Asian Mining Source</a>
								<a class="dropdown-item" href="{{ route('userSite.index') }}"><i class="align-middle me-1"
										data-feather="user"></i>
									Site</a>
							</div>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('site.index') }}">
								<i class="align-middle" data-feather="map"></i> <span class="align-middle">Data Site</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('karyawan.index') }}">
								<i class="align-middle" data-feather="users"></i> <span class="align-middle">Data
									Karyawan Asean</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('karyawanSite.index') }}">
								<i class="align-middle" data-feather="users"></i> <span class="align-middle">Data
									Karyawan Site</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('barang.index') }}">
								<i class="align-middle" data-feather="package"></i> <span class="align-middle">Data
									Barang</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('unit.index') }}">
								<i class="align-middle" data-feather="truck"></i> <span class="align-middle">Data
									Unit</span>
							</a>
						</li>

						@if (auth()->user()->level_id == 2)
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{ route('pemasukan.index') }}">
									<i class="align-middle" data-feather="download"></i> <span class="align-middle">Data
										Pemasukan Asean</span>
								</a>
							</li>
						@endif
					@endif

					<li class="sidebar-header">
						Transaksi
					</li>

					@if (Session::get('level') < 4)
						

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('pembelianBarang.index') }}">
								<i class="align-middle" data-feather="shopping-cart"></i> <span
									class="align-middle">Pembelian Barang</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('pengeluaranSite.index') }}">
								<i class="align-middle" data-feather="external-link"></i> <span
									class="align-middle">Pengeluaran Asean Untuk Site</span>
							</a>
						</li>

					@endif

					@if (auth()->user()->level_id < 3)
						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('gajihKaryawanSite.index') }}">
								<i class="align-middle" data-feather="dollar-sign"></i> <span
									class="align-middle">Gajih Karyawan per Site</span>
							</a>
						</li>
					@endif

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('perbaikanUnit.index') }}">
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Perbaikan
								Unit {{ Session::get('level') == 4 ? 'Site' : '' }}</span>
						</a>
					</li>

					@if (Session::get('level') < 4)

						<li class="sidebar-header">
							Operasional
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('operasional.index') }}">
								<i class="align-middle" data-feather="link"></i> <span class="align-middle">Operasional</span>
							</a>
						</li>
						
					@endif

					<li class="sidebar-header">
						Produktivitas
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('rotasiUnit.index') }}">
							<i class="align-middle" data-feather="refresh-ccw"></i> <span class="align-middle">Rotasi
								Unit Site</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('operasionalSite.index') }}">
							<i class="align-middle" data-feather="link"></i> <span class="align-middle">Operasional
								Site</span>
						</a>
					</li>

					<li class="sidebar-header">
						Laporan Lapangan
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('kondisiBatu.index') }}">
							<i class="align-middle" data-feather="triangle"></i> <span class="align-middle">Kondisi
								Batu</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('kondisiLapangan.index') }}">
							<i class="align-middle" data-feather="image"></i> <span class="align-middle">Kondisi
								Lapangan</span>
						</a>
					</li>

					@if (auth()->user()->level_id < 3)
						<li class="sidebar-header">
							Keuangan
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('pembelianBatu.index') }}">
								<i class="align-middle" data-feather="shopping-bag"></i> <span
									class="align-middle">Pembelian
									Dari Site</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('pembelianDariJetty.index') }}">
								<i class="align-middle" data-feather="shopping-bag"></i> <span
									class="align-middle">Pembelian
									Dari Jetty</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('pengapalan.index') }}">
								<i class="align-middle" data-feather="anchor"></i> <span
									class="align-middle">Pengapalan</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a class="sidebar-link" href="{{ route('pembayaranPenjualan.index') }}">
								<i class="align-middle" data-feather="dollar-sign"></i> <span
									class="align-middle">Pembayaran Penjualan</span>
							</a>
						</li>
					@endif

					<li class="sidebar-header">
						Laporan
					</li>

					<li class="sidebar-item dropdown">
						<a class="sidebar-link dropdown-toggle d-none d-sm-inline-block" href="#"
							data-bs-toggle="dropdown">
							<i class="align-middle" data-feather="file"></i> <span class="align-middle">Asean Mineral
								Source</span>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="{{ route('pemasukan.laporan') }}"><i
								class="align-middle me-1" data-feather="file"></i>
							Pemasukan</a>
							<a class="dropdown-item" href="{{ route('pengeluaran.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Pengeluaran</a>
							<a class="dropdown-item" href="{{ route('pengeluaranSite.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Pengeluaran Asean Untuk Site</a>
							<a class="dropdown-item" href="{{ route('pembelianBatu.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Pembelian dari Site</a>
							<a class="dropdown-item" href="{{ route('pengapalan.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Pengapalan</a>
							<a class="dropdown-item" href="{{ route('penjualanBatu.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Penjualan Batu</a>
							<a class="dropdown-item" href="{{ route('pembayaranPenjualan.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Pembayaran Penjualan</a>
						</div>
					</li>

					<li class="sidebar-item dropdown">
						<a class="sidebar-link dropdown-toggle d-none d-sm-inline-block" href="#"
							data-bs-toggle="dropdown">
							<i class="align-middle" data-feather="file"></i> <span class="align-middle">Site</span>
						</a>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="{{ route('operasionalSite.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Pengeluaran</a>
							<a class="dropdown-item" href="{{ route('rotasiUnit.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Produksi</a>
							<a class="dropdown-item" href="{{ route('PenjualanSite.laporan') }}"><i
									class="align-middle me-1" data-feather="file"></i>
								Penjualan</a>
						</div>
					</li>

				</ul>


			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">


						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
								data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
								data-bs-toggle="dropdown">
								<?php
									$level = auth()->user()->level_id;
									$level_name = auth()->user()->level->level;
									if (Session::get('level') == 3) {
										$level = 3;
										$level_name = 'Checker';
									}
								?>
								<span class="text-dark">{{ auth()->user()->name }} - {{ $level_name }} 
									{{ $level == 4 ? '('.Session::get('nama_site').')' : '' }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i>
									Profil</a>
								<a class="dropdown-item" href="{{ route('settings.index') }}"><i
										class="align-middle me-1" data-feather="settings"></i>
									Settings</a>
								@if (auth()->user()->level_id == 4)
									<a class="dropdown-item" href="{{ route('settings.changeSite') }}"><i
										class="align-middle me-1" data-feather="arrow-right"></i>
									Ganti Site</a>
								@endif
								@if ($level == 4 && auth()->user()->is_checker == 1)
									<a class="dropdown-item" href="{{ route('settings.switchChecker') }}"><i
										class="align-middle me-1" data-feather="arrow-right"></i>
									Ganti ke  Checker</a>
								@endif
								<div class="dropdown-divider"></div>
								<form action="{{ route('logout') }}" method="POST">
									@csrf
									<button class="dropdown-item"><i class="align-middle me-1"
											data-feather="log-out"></i>Keluar</button>

								</form>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					@yield('content')

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://aseanmineralsource.co.id/"
									target="_blank"><strong>Asean Mineral Source</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted"
										href="https://www.linkedin.com/in/noor-rahmat-effendy-549351125/?originalSubdomain=id"
										target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>