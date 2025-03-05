<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengapalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'tanggal_pengapalan',
        'nama_tongkang',
        'site_id',
        'pembelian_batu_id',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function pembelianBatu()
    {
        return $this->belongsTo(PembelianBatu::class);
    }
}
