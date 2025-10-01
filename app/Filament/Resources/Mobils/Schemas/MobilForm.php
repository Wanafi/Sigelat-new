<?php

namespace App\Filament\Resources\Mobils\Schemas;

use App\Models\Mobil;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\ToggleButtons;

class MobilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mobil')
                    ->description('Masukkan data mobil operasional secara lengkap.')
                    ->inlineLabel(true)
                    ->schema([
                        TextInput::make('nomor_plat')
                            ->placeholder('Contoh: DA 1234 XX')
                            ->prefixIcon('heroicon-o-identification')
                            ->required(),

                        Select::make('nama_tim')
    ->label('Tim Armada')
    ->placeholder('Pilih Tim')
    ->searchable()
    ->prefixIcon('heroicon-o-users')
    ->required()
    ->options(fn () => Mobil::distinct()->pluck('nama_tim', 'nama_tim')->toArray())
    ->createOptionForm([
        TextInput::make('nama_tim')
            ->label('Tim Armada Baru')
            ->required(),
    ])
    ->createOptionAction(fn(Action $action) => $action
        ->modalHeading('Tambah Tim Armada')
        ->modalSubmitActionLabel('Simpan')
        ->modalWidth('md'))
    ->createOptionUsing(function (array $data) {
        // Bikin dummy Mobil hanya untuk nyimpen nama_tim baru
        Mobil::firstOrCreate(['nama_tim' => $data['nama_tim']]);

        // balikin string supaya langsung jadi selected
        return $data['nama_tim'];
    }),

                        Select::make('no_unit')
                                ->label('Nomor Unit Mobil')
                                ->options(Mobil::distinct()->pluck('no_unit', 'no_unit'))
                                ->searchable()
                                ->placeholder('Pilih atau Tambahkan No. Unit')
                                ->prefixIcon('heroicon-o-hashtag')
                                ->required()
                                ->createOptionForm([
                                    TextInput::make('no_unit')
                                        ->label('Nomor Unit Baru')
                                        ->required(),
                                ])
                                ->createOptionAction(fn(Action $action) => $action
                                    ->modalHeading('Tambah Nomor Unit')
                                    ->modalSubmitActionLabel('Simpan')
                                    ->modalWidth('md'))
                                ->createOptionUsing(fn(array $data) => $data['no_unit']),

                        ToggleButtons::make('status_mobil')
                            ->options(['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak aktif', 'Dalam Perbaikan' => 'Dalam perbaikan'])
                            ->icons([
                                'Aktif' => 'heroicon-o-check-circle',
                                'Tidak Aktif' => 'heroicon-o-x-circle',
                                'Dalam Perbaikan' => 'heroicon-o-wrench-screwdriver',
                            ])
                            ->colors([
                                'Aktif' => 'success',
                                'Tidak Aktif' => 'warning',
                                'Dalam Perbaikan' => 'danger',
                            ])
                            ->inline(true)
                            ->grouped()
                            ->required(),

                        Textarea::make('merk_mobil')
                            ->label('Informasi Detail Mobil')
                            ->placeholder('Contoh: Toyota Avanza, Daihatsu Xenia, dll.')
                            ->required()
                            ->columns(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
