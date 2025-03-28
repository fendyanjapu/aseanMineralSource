<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'pengeluaran_site_id',
        'pembayaran_penjualan_id',
        'hutang',
        'dibayar',
    ];
}
