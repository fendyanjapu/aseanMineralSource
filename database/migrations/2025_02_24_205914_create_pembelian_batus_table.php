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
        Schema::create('pembelian_batus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->smallInteger('site_id');
            $table->date('tgl_pembelian');
            $table->text('tgl_rotasi');
            $table->float('jumlah_tonase');
            $table->string('harga');
            $table->string('total_penjualan');
            $table->char('status_pengapalan', 1);
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
        Schema::dropIfExists('pembelian_batus');
    }
};
