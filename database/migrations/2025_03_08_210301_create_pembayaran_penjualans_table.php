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
        Schema::create('pembayaran_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->smallInteger('site_id');

            $table->text('data_pembelian_site');
            $table->date('tanggal_pembelian');
            $table->string('tonase');
            $table->string('total_harga_pembelian');

            $table->text('dana_operasional_site');
            $table->date('tanggal_transfer_ke_site');
            $table->string('jumlah_hutang_site');
            $table->string('total_pembayaran_site');
            
            $table->date('tanggal_transaksi');
            $table->string('bukti_transaksi');
            $table->string('sisa_hutang_site');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_penjualans');
    }
};
