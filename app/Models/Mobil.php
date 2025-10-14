<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Mobil extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'nomor_plat',
        'merk_mobil',
        'no_unit',
        'nama_tim',
        'status_mobil',
    ];

    public function alats()
    {
        return $this->hasMany(Alat::class);
    }

    public function gelars()
    {
        return $this->hasMany(Gelar::class);
    }
}
