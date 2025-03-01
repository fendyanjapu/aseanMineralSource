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
        Schema::create('kondisi_lapangans', function (Blueprint $table) {
            $table->id();
            $table->text('keterangan');
            $table->string('bukti_pelaporan');
            $table->date('tanggal');
            $table->string('lokasi');
            $table->string('nama_jetty');
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
        Schema::dropIfExists('kondisi_lapangans');
    }
};
