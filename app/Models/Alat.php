<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobil_id',
        'kode_barcode',
        'nama_alat',
        'foto',
        'kategori_alat',
        'merek_alat',
        'spesifikasi',
        'tanggal_masuk',
        'status_alat',
    ];


    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function detailGelars()
    {
        return $this->hasMany(DetailGelar::class);
    }
}
