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
            padding-right:10px;
            padding-left:10px;
		}
	</style>
</head>
<body>
	<center>
        <h2>Asean Mineral Source</h2>
		<h3>Laporan Pemasukan {{ $namaBulan }} {{ $tahun }}</h3>
	</center>
 
	<table class='tabel'>
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Transaksi</th>
				<th>Sumber Dana</th>
				<th>Metode Transaksi</th>
				<th>Tanggal</th>
                <th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
            <?php $total = 0; ?>
			@foreach($pemasukans as $p)
			<tr>
				<td style="text-align: center">{{ $loop->iteration }}</td>
				<td style="text-align: center">{{$p->kode_transaksi}}</td>
				<td>{{$p->sumber_dana}}</td>
				<td>{{$p->metode_transaksi}}</td>
				<td>{{$p->tanggal}}</td>
                <td style="text-align: right">{{$p->jumlah}}</td>
                <?php 
                    $jml = str_replace(',','',$p->jumlah);
                    $total += $jml;
                ?>
			</tr>
			@endforeach
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right"><b>Total</b></td>
            <td style="text-align: right">{{ number_format($total) }}</td>
		</tbody>
	</table>
 
</body>
</html>