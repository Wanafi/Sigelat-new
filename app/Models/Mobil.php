<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_plat',
        'merk_mobil',
        'no_unit',
        'nama_tim',
        'status_mobil',
    ];
}
