<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_site',
        'lokasi',
        'penanggung_jawab',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
