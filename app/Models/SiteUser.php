<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'site_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
