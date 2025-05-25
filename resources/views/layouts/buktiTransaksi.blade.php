<?php
    $folder = '/upload/'.$tabel.'/';
    $buktiTransaksi = $$tabel->bukti_transaksi;
    $bukti = explode(",",$buktiTransaksi);
    $jumlahBukti = count($bukti) - 1;
    for ($i = 0; $i < $jumlahBukti; $i++) {
?>
    <a href="{{ env('APP_URL') . $folder . $bukti[$i] }}"
        target="_blank">Lihat</a><br>
<?php
    }
?>