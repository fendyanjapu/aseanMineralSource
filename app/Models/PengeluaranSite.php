<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'jumlah',
        'sumber_dana',
        'metode_transaksi',
        'bukti_transaksi',
        'tanggal',
        'created_by',
        'updated_by',
        'site_id',
        'user_id',
        'status_hutang',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
