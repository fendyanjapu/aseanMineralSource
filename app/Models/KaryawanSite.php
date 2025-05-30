<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'tanggal_masuk',
        'jabatan',
        'status',
        'created_by',
        'updated_by',
    ];
}
