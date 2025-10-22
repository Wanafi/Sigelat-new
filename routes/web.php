<?php

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\LaporanGelarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/alat/{alat}/printqr', [QrCodeController::class, 'print'])->name('printqr.printqr');

Route::get('/scan/{kode}', function ($kode, Request $request) {
    $alat = Alat::where('kode_barcode', $kode)->firstOrFail();
    return view('scanqr.scanqr', ['alat' => $alat]);
})->name('scan.barcode');

Route::post('/scan/verifikasi/{id}', function (Request $request, $id) {
    $alat = Alat::findOrFail($id);

    $request->validate([
        'akses_password' => 'required',
    ]);

    // Password admin
    $passwordBenar = 'plnadmin123';

    if ($request->akses_password === $passwordBenar) {
        session(['akses_diizinkan' => true]);
        return redirect()->route('scan.barcode', ['kode' => $alat->kode_barcode])
                         ->with('success', 'Akses admin berhasil.');
    } else {
        return redirect()->route('scan.barcode', ['kode' => $alat->kode_barcode])
                         ->with('akses_error', 'Password salah.');
    }
})->name('scan.barcode.verifikasi');

Route::put('/scan/{alat}/update-status', function (Request $request, Alat $alat) {
    $request->validate([
        'status' => 'required|in:Baik,Rusak,Hilang',
    ]);

    if (!session('akses_diizinkan')) {
        abort(403, 'Tidak memiliki akses untuk memperbarui status.');
    }

    $alat->update([
        'status_alat' => $request->status,
    ]);

    return back()->with('success', 'Status alat berhasil diperbarui.');
})->name('scan.barcode.update-status');

Route::middleware('auth')->group(function () {
    Route::get('/laporan-gelar/{id}', [LaporanGelarController::class, 'show'])
        ->name('laporan-gelar.show');
});