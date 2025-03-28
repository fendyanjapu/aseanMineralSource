<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengapalans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->date('tanggal_pengapalan');
            $table->string('nama_tongkang');
            $table->smallInteger('site_id');
            $table->text('tanggal_pembelian');
            $table->text('id_pembelian_batu');
            $table->float('tonase');
            $table->string('harga');
            $table->string('harga_di_site');
            $table->string('harga_jual_per_tonase')->nullable();
            $table->string('total_harga_penjualan')->nullable();
            $table->string('laba_bersih')->nullable();
            $table->smallInteger('pembelian_dari_jetty_id');
            $table->string('biaya_dokumen');
            $table->string('bukti_biaya_dokumen');
            $table->string('biaya_jetty');
            $table->string('bukti_biaya_jetty');
            $table->string('biaya_operasional_dll');
            $table->string('bukti_biaya_operasional_dll');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->smallInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengapalans');
    }
};
