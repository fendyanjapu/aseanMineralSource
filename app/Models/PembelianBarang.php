<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'keterangan',
        'tanggal',
        'bukti_transaksi',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
