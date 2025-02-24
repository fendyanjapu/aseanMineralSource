<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'merk',
        'spesifikasi',
        'kisaran_harga',
        'created_by',
        'updated_by',
        'user_id',
    ];
}
