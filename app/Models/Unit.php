<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'no_identitas_unit',
        'spesifikasi',
        'merk',
        'tanggal_pembelian',
        'harga',
        'created_by',
        'updated_by',
    ];
}
