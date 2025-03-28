<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDariJetty extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'nama_jetty',
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
}
