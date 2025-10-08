<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailGelar extends Model
{
    use HasFactory;

    protected $fillable = [
        'gelar_id',
        'alat_id',
        'status_alat',
        'foto_kondisi',
        'keterangan',
    ];

    public function gelar()
    {
        return $this->belongsTo(Gelar::class);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
