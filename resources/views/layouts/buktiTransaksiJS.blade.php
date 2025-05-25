<script>
    function jmlBukti() {
        let jumlah_bukti_transaksi = $('#jumlah_bukti_transaksi').val();

        $.ajax({
            type: "GET",
            data: { jumlah: jumlah_bukti_transaksi },
            url: "{{ route('buktiTransaksi.add') }}",
            cache: false,
            success: function (result) {
                $('#bukti_transaksis').html(result);
            }
        });
    }
    $("#jumlah_bukti_transaksi").keyup(function (event) {
        jmlBukti();
    });

    $("#jumlah_bukti_transaksi").change(function (event) {
        jmlBukti();
    });
</script>