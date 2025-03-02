<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperasionalSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'nama_transaksi',
        'biaya',
        'bukti_transaksi',
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
