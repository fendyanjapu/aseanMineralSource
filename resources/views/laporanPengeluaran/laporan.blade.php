<!DOCTYPE html>
<html>

<head>
	<title>Asean Mineral Source</title>

	<style>
		.tabel {
			width: 100%;
			border-left: 0.01em solid #ccc;
			border-right: 0;
			border-top: 0.01em solid #ccc;
			border-bottom: 0;
			border-collapse: collapse;
		}

		.tabel td,
		.tabel th {
			border-left: ;
			border-right: 0.01em solid #ccc;
			border-top: 0;
			border-bottom: 0.01em solid #ccc;
			padding-right: 10px;
			padding-left: 10px;
		}
	</style>
</head>

<body>
	<center>
		<h2>Asean Mineral Source</h2>
		<h3>Laporan Pengeluaran {{ $namaBulan }} {{ $tahun }}</h3>
	</center>

	<h4>Pembelian Barang</h4>
	<table class='tabel'>
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Kode Transaksi</th>
				<th scope="col">Kode Barang</th>
				<th scope="col">Nama</th>
				<th scope="col">Tanggal</th>
				<th scope="col">Jumlah</th>
				<th scope="col">Harga Satuan</th>
				<th scope="col">Total Harga</th>
			</tr>
		</thead>
		<tbody>
			<?php $totalPembelianBarang = 0; ?>
			@foreach($pembelianBarangs as $pembelianBarang)
						<tr>
							<th style="text-align: center">{{ $loop->iteration }}</th>
							<td>{{ $pembelianBarang->kode_transaksi }}</td>
							<td>{{ $pembelianBarang->barang->kode }}</td>
							<td>{{ $pembelianBarang->barang->nama }}</td>
							<td>{{ $pembelianBarang->tanggal }}</td>
							<td style="text-align: center">{{ $pembelianBarang->jumlah }}</td>
							<td style="text-align: right">{{ $pembelianBarang->harga_satuan }}</td>
							<td style="text-align: right">{{ $pembelianBarang->total_harga }}</td>
							<?php 
								$jml = str_replace(',', '', $pembelianBarang->total_harga);
				$totalPembelianBarang += $jml;
							?>
						</tr>
			@endforeach
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align: right"><b>Total</b></td>
			<td style="text-align: right">{{ number_format($totalPembelianBarang) }}</td>
		</tbody>
	</table>

	<h4>Perbaikan Unit</h4>
	<table class="tabel">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Kode Transaksi</th>
				<th scope="col">Kode Unit</th>
				<th scope="col">Nomor Identitas Unit</th>
				<th scope="col">Detail Perbaikan</th>
				<th scope="col">Tanggal</th>
				<th scope="col">Total Harga</th>
			</tr>
		</thead>
		<tbody>
			<?php $totalPerbaikanUnit = 0; ?>
			@foreach ($perbaikanUnits as $perbaikanUnit)
				<tr>
					<th style="text-align: center">{{ $loop->iteration }}</th>
					<td>{{ $perbaikanUnit->kode_transaksi }}</td>
					<td>{{ $perbaikanUnit->unit->kode }}</td>
					<td>{{ $perbaikanUnit->unit->no_identitas_unit }}</td>
					<td>{{ $perbaikanUnit->detail_perbaikan }}</td>
					<td>{{ $perbaikanUnit->tanggal }}</td>
					<td style="text-align: right">{{ $perbaikanUnit->total_harga }}</td>
					<?php 
						$jml = str_replace(',', '', $perbaikanUnit->total_harga);
						$totalPerbaikanUnit += $jml;
					?>
				</tr>
			@endforeach
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align: right"><b>Total</b></td>
			<td style="text-align: right">{{ number_format($totalPerbaikanUnit) }}</td>
		</tbody>
	</table>

	<h4>Penggajihan</h4>
	<table class="tabel">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Kode Transaksi</th>
				<th scope="col">Nama Karyawan</th>
				<th scope="col">Periode Gajih</th>
				<th scope="col">Tanggal</th>
				<th scope="col">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php $totalPenggajihan = 0; ?>
			@foreach ($penggajihans as $penggajihan)
				<tr>
					<th style="text-align: center">{{ $loop->iteration }}</th>
					<td>{{ $penggajihan->kode_transaksi }}</td>
					<td>{{ $penggajihan->karyawan->nama }}</td>
					<td>{{ $penggajihan->periode_gajih }}</td>
					<td>{{ $penggajihan->tanggal }}</td>
					<td style="text-align: right">{{ $penggajihan->total }}</td>
					<?php 
						$jml = str_replace(',', '', $penggajihan->total);
						$totalPenggajihan += $jml;
					?>
				</tr>
			@endforeach
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align: right"><b>Total</b></td>
			<td style="text-align: right">{{ number_format($totalPenggajihan) }}</td>
			
		</tbody>
	</table>
	<br>
	<table class="tabel">
		<tbody>
			<td style="text-align: center"><b>TOTAL SEMUA PENGELUARAN</b></td>
			<?php $totalSemua = $totalPembelianBarang + $totalPerbaikanUnit + $totalPenggajihan ?>
			<td style="text-align: right">{{ number_format($totalSemua) }}</td>
		</tbody>
	</table>
</body>

</html>