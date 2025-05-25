<?php
    $folder = '/upload/'.$tabel.'/';
    $buktiTransaksi = $$tabel->bukti_transaksi;
    $bukti = explode(",",$buktiTransaksi);
    $jumlahBukti = count($bukti) - 1;
    for ($i = 0; $i < $jumlahBukti; $i++) {
?>
    <div id="div_{{ $i }}">
        <a href="{{ env('APP_URL') . $folder . $bukti[$i] }}"
            target="_blank" class="badge bg-primary me-1 my-1">{{ $bukti[$i] }}</a>
        <input type="hidden" value="{{ $bukti[$i] }}" id="foto_{{ $i }}">
        <a href="#" class="badge bg-danger me-1 my-1 buton" id="bukti_{{ $i }}">Hapus</a>
        <br>
    </div>
    
    <script>
    $("#bukti_"+{{ $i }}).click(function (event) {
        let img = $("#foto_"+{{ $i }}).val();
        $.ajax({
            type: "GET",
            data: { bukti_transaksi: img, id: '{{ $id }}', tabel: '{{ $tabel }}'  },
            url: "{{ route('buktiTransaksi.delete') }}",
            cache: false,
            success: function (result) {
                $('#div_'+{{ $i }}).fadeOut();
            }
        });
    });
</script>
<?php
    }
?>
<script>
    $('a.buton').click(function (e) {
        e.preventDefault();
    });
</script>