<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'karyawan_id',
        'periode_gajih',
        'total',
        'tanggal',
        'bukti_transaksi',
        'created_by',
        'updated_by',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
