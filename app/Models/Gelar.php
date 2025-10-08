<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelar extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobil_id',
        'user_id',
        'status',
        'tanggal_cek',
        'pelaksana',
    ];

    protected $casts = [
        'tanggal_cek' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'pelaksana' => 'array',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function detailGelars()
    {
        return $this->hasMany(\App\Models\DetailGelar::class);
    }

    public function detailAlats()
    {
        return $this->hasMany(\App\Models\DetailGelar::class);
    }


}
