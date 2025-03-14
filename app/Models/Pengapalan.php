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
        'tanggal_pembelian',
        'id_pembelian_batu',
        'tonase',
        'harga',
        'harga_di_site',
        'harga_jual_per_tonase',
        'document_dll',
        'total_harga_penjualan',
        'laba_bersih',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
