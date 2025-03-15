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
        'data_pembelian_site',
        'tanggal_pembelian',
        'tonase',
        'total_harga_pembelian',
        'dana_operasional_site',
        'tanggal_transfer_ke_site',
        'jumlah_hutang_site',
        'total_pembayaran_site',
        'tanggal_transaksi',
        'bukti_transaksi',
        'sisa_hutang_site',
        'created_by',
        'updated_by',
        'user_id',
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
