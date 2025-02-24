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
        Schema::create('penggajihans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->integer('karyawan_id');
            $table->string('periode_gajih');
            $table->string('total', 20);
            $table->date('tanggal');
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
        Schema::dropIfExists('penggajihans');
    }
};
