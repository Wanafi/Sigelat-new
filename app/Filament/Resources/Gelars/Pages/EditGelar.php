<?php

namespace App\Filament\Resources\Gelars\Pages;

use App\Models\Alat;
use App\Models\Gelar;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Gelars\GelarResource;

class EditGelar extends EditRecord
{
    protected static string $resource = GelarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load detail alats saat edit
        $detailAlats = DB::table('detail_gelars')
            ->join('alats', 'detail_gelars.alat_id', '=', 'alats.id')
            ->where('detail_gelars.gelar_id', $data['id'])
            ->select(
                'detail_gelars.alat_id',
                'alats.nama_alat',
                'detail_gelars.status_alat',
                'detail_gelars.keterangan',
                'detail_gelars.foto_kondisi'
            )
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();

        $data['detail_alats'] = $detailAlats;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update data utama gelar
        $record->update([
            'mobil_id' => $data['mobil_id'],
            'tanggal_cek' => $data['tanggal_cek'],
            'pelaksana' => $data['pelaksana'],
        ]);

        // Hapus detail lama
        DB::table('detail_gelars')->where('gelar_id', $record->id)->delete();

        // Simpan detail baru
        $statusGelar = 'Lengkap'; // Default Lengkap
        
        foreach ($data['detail_alats'] ?? [] as $alat) {
            if (!isset($alat['alat_id'], $alat['status_alat'])) {
                continue;
            }

            // Cek jika ada alat hilang SEBELUM insert
            if ($alat['status_alat'] === 'Hilang') {
                $statusGelar = 'Tidak Lengkap';
            }

            // Insert detail gelar baru
            DB::table('detail_gelars')->insert([
                'gelar_id' => $record->id,
                'alat_id' => $alat['alat_id'],
                'status_alat' => $alat['status_alat'],
                'keterangan' => $alat['keterangan'] ?? null,
                'foto_kondisi' => $alat['foto_kondisi'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update status alat di tabel alats
            Alat::where('id', $alat['alat_id'])->update([
                'status_alat' => $alat['status_alat'],
            ]);

            // Cek jika ada alat hilang
            if ($alat['status_alat'] === 'Hilang') {
                $statusGelar = 'Tidak Lengkap';
            }
        }

        // Update status gelar
        $record->update(['status' => $statusGelar]);

        return $record;
    }
}