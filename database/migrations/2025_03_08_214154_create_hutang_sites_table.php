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
        Schema::create('hutang_sites', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('site_id');
            $table->smallInteger('pemasukan_id')->nullable();
            $table->smallInteger('pembayaran_penjualan_id')->nullable();
            $table->string('hutang')->default('0');
            $table->string('dibayar')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang_sites');
    }
};
