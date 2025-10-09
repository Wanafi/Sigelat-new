<?php

namespace App\Filament\Resources\GelarResource\Pages;

use App\Models\Alat;
use App\Models\Gelar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Gelars\GelarResource;

class CreateGelar extends CreateRecord
{
    protected static string $resource = GelarResource::class;
    
    public function getTitle(): string
    {
        return 'Buat Data Kegiatan Gelar Alat';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Log untuk debugging
        Log::info('Form Data Before Create:', $data);
        
        return $data;
    }

    protected function handleRecordCreation(array $data): Gelar
    {
        // Log untuk debugging
        Log::info('Data yang masuk ke handleRecordCreation:', $data);
        
        // Buat data utama gelar
        $gelar = Gelar::create([
            'mobil_id' => $data['mobil_id'],
            'tanggal_cek' => $data['tanggal_cek'],
            'pelaksana' => $data['pelaksana'],
            'status' => 'Lengkap', // Default awal
        ]);

        Log::info('Gelar created with ID: ' . $gelar->id);

        // Simpan Detail Alat & update status_alat
        $statusGelar = 'Lengkap'; // Default Lengkap
        
        if (isset($data['detail_alats']) && is_array($data['detail_alats'])) {
            Log::info('Detail alats count: ' . count($data['detail_alats']));
            
            foreach ($data['detail_alats'] as $index => $alat) {
                Log::info("Processing alat index {$index}:", $alat);
                
                if (!isset($alat['alat_id'])) {
                    Log::warning("Skipping alat index {$index}: alat_id not set");
                    continue;
                }
                
                if (!isset($alat['status_alat'])) {
                    Log::warning("Skipping alat index {$index}: status_alat not set");
                    continue;
                }

                try {
                    // Cek jika ada alat hilang SEBELUM insert
                    if ($alat['status_alat'] === 'Hilang') {
                        $statusGelar = 'Tidak Lengkap';
                        Log::info("Found missing equipment, status changed to: Tidak Lengkap");
                    }

                    // Insert detail gelar
                    $insertId = DB::table('detail_gelars')->insertGetId([
                        'gelar_id' => $gelar->id,
                        'alat_id' => $alat['alat_id'],
                        'status_alat' => $alat['status_alat'],
                        'keterangan' => $alat['keterangan'] ?? null,
                        'foto_kondisi' => $alat['foto_kondisi'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    Log::info("Detail gelar inserted with ID: {$insertId}");

                    // Update status alat di tabel alats
                    $updated = Alat::where('id', $alat['alat_id'])->update([
                        'status_alat' => $alat['status_alat'],
                    ]);
                    
                    Log::info("Alat updated: {$updated} row(s)");

                    // Cek jika ada alat hilang
                    if ($alat['status_alat'] === 'Hilang') {
                        $statusGelar = 'Tidak Lengkap';
                    }
                } catch (\Exception $e) {
                    Log::error("Error inserting detail gelar index {$index}: " . $e->getMessage());
                }
            }
        } else {
            Log::warning('detail_alats is not set or not an array');
        }

        // Update status gelar berdasarkan kondisi alat
        $gelar->update(['status' => $statusGelar]);
        
        Log::info("Gelar status updated to: {$statusGelar}");

        return $gelar;
    }

    protected function afterCreate(): void
    {
        Log::info('afterCreate called');
        
        // Verifikasi data tersimpan
        $detailCount = DB::table('detail_gelars')
            ->where('gelar_id', $this->record->id)
            ->count();
            
        Log::info("Total detail_gelars for gelar_id {$this->record->id}: {$detailCount}");
    }
}