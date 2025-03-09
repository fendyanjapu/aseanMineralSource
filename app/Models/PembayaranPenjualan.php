<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'site_id',
        'pemasukan_id',
        'pembelian_batu_id',
        'tanggal_transaksi',
        'data_pembelian_site',
        'tanggal_transfer_ke_site',
        'jumlah_hutang_site',
        'sisa_hutang_site',
        'tonase',
        'total_pembayaran_site',
        'total_harga_pembelian',
        'bukti_transaksi',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function pemasukan()
    {
        return $this->belongsTo(Pemasukan::class);
    }

    public function pembelianBatu()
    {
        return $this->belongsTo(PembelianBatu::class);
    }
}
