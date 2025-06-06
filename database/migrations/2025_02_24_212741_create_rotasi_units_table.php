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
        Schema::create('rotasi_units', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->date('tanggal');
            $table->string('nopol');
            $table->string('supir');
            $table->float('berat_kendaraan');
            $table->float('berat_kotor');
            $table->float('berat_bersih');
            $table->string('total_rotasi');
            $table->smallInteger('site_id');
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
        Schema::dropIfExists('rotasi_units');
    }
};
