<?php

namespace App\Filament\Resources\Mobils\Schemas;

use App\Models\Mobil;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\MarkdownEditor;

class MobilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'lg' => 2,
                ])
                    ->schema([
                        Section::make('Informasi Mobil')
                            ->schema([
                                TextInput::make('nomor_plat')
                                    ->placeholder('Contoh: DA 1234 XX')
                                    ->prefixIcon('heroicon-o-identification')
                                    ->required(),

                                MarkdownEditor::make('merk_mobil')
                                    ->label('Informasi Detail Mobil')
                                    ->placeholder('Contoh: Toyota Avanza, Daihatsu Xenia, dll.')
                                    ->required(),
                            ])
                            ->columns(1),

                        Section::make('Catatan')
                            ->schema([
                                Select::make('no_unit')
                                    ->label('Nomor Unit Mobil')
                                    ->prefixIcon('heroicon-o-numbered-list')
                                    ->placeholder('Pilih atau Tambahkan Nomor Unit')
                                    ->required()
                                    ->searchable()
                                    ->options(fn() => Mobil::query()
                                        ->whereNotNull('no_unit')
                                        ->distinct()
                                        ->pluck('no_unit', 'no_unit')
                                        ->toArray())
                                    ->createOptionForm([
                                        TextInput::make('no_unit')->label('No Unit Baru')->required(),
                                    ])
                                    ->createOptionAction(fn(Action $action) => $action
                                        ->modalHeading('Tambah Nomor Unit')
                                        ->modalSubmitActionLabel('Tambah')
                                        ->modalWidth('sm'))
                                    ->createOptionUsing(fn(array $data) => $data['no_unit'])
                                    ->getOptionLabelUsing(fn($value) => (string) $value),

                                Select::make('nama_tim')
                                    ->label('Tim Armada')
                                    ->placeholder('Pilih atau Tambahkan Tim')
                                    ->required()
                                    ->searchable()
                                    ->prefixIcon('heroicon-o-users')
                                    ->options(fn() => Mobil::query()
                                        ->whereNotNull('nama_tim')
                                        ->distinct()
                                        ->pluck('nama_tim', 'nama_tim')
                                        ->toArray())
                                    ->createOptionForm([
                                        TextInput::make('nama_tim')
                                            ->label('Nama Tim Baru')
                                            ->required(),
                                    ])
                                    ->createOptionAction(fn(Action $action) => $action
                                        ->modalHeading('Tambah Tim Armada')
                                        ->modalSubmitActionLabel('Simpan')
                                        ->modalWidth('md'))
                                    ->createOptionUsing(fn(array $data) => $data['nama_tim'])
                                    ->getOptionLabelUsing(fn($value) => (string) $value),

                                ToggleButtons::make('status_mobil')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Tidak Aktif' => 'Tidak aktif',
                                        'Dalam Perbaikan' => 'Dalam perbaikan',
                                    ])
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
                            ])
                            ->columns(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
