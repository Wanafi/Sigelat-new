<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;
use App\Models\Mobil;
use Illuminate\Support\Str;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan minimal ada 1 mobil (buat foreign key)
        $mobil = Mobil::first() ?? Mobil::factory()->create();

        $kategori = ['Elektronik', 'Listrik', 'Perkakas', 'Ukuran', 'Keamanan'];
        $merek = ['Sanwa', 'Krisbow', 'Kyoritsu', 'Bosch', 'Fluke', 'Makita'];
        $status = ['Baik', 'Rusak', 'Hilang'];

        for ($i = 1; $i <= 45; $i++) {
            Alat::create([
                'mobil_id' => $mobil->id,
                'kode_barcode' => 'ALAT-' . strtoupper(Str::random(8)),
                'nama_alat' => fake()->words(2, true), // contoh: "Tang Listrik"
                'kategori_alat' => fake()->randomElement($kategori),
                'merek_alat' => fake()->randomElement($merek),
                'spesifikasi' => fake()->sentence(10),
                'tanggal_masuk' => fake()->dateTimeBetween('-6 months', 'now'),
                'status_alat' => fake()->randomElement($status),
                'foto' => fake()->optional()->imageUrl(640, 480, 'tools', true, 'alat'),
            ]);
        }
    }
}
