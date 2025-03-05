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
            $table->string('tonase');
            $table->string('harga_di_site');
            $table->string('harga_jual_per_tonase');
            $table->string('document_dll');
            $table->string('total_harga_penjualan');
            $table->string('laba_bersih');
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
