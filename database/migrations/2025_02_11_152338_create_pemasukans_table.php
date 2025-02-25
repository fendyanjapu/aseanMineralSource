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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->string('jumlah', 20);
            $table->string('sumber_dana');
            $table->string('metode_transaksi');
            $table->string('bukti_transaksi');
            $table->date('tanggal');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->smallInteger('site_id');
            $table->smallInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
