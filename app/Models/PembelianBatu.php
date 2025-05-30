<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBatu extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'site_id',
        'tgl_pembelian',
        'tgl_rotasi',
        'jumlah_tonase',
        'harga',
        'total_penjualan',
        'status_pengapalan',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
