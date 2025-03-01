<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiLapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'keterangan',
        'bukti_pelaporan',
        'tanggal',
        'lokasi',
        'nama_jetty',
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
