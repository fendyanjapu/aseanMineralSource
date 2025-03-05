<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotasiUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'no_nota',
        'tanggal',
        'nopol',
        'supir',
        'jarak',
        'berat_kendaraan',
        'berat_kotor',
        'berat_bersih',
        'premi_tonase',
        'premi_per_rite',
        'total_biaya',
        'total_rotasi',
        'site_id',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
