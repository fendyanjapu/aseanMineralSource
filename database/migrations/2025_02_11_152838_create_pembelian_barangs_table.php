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
        Schema::create('pembelian_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->smallInteger('barang_id');
            $table->string('jumlah', 10);
            $table->string('harga_satuan', 20);
            $table->string('total_harga', 20);
            $table->date('tanggal');
            $table->text('keterangan');
            $table->string('bukti_transaksi');
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
        Schema::dropIfExists('pembelian_barangs');
    }
};
