<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'unit_id',
        'detail_perbaikan',
        'total_harga',
        'tanggal',
        'bukti_transaksi',
        'created_by',
        'updated_by',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
