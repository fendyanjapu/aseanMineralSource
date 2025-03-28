<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajihKaryawanSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'karyawan_site_id',
        'gajih_periode',
        'total',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function karyawanSite()
    {
        return $this->belongsTo(KaryawanSite::class);
    }
}
