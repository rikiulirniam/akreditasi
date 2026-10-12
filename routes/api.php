<?php

use App\Http\Controllers\Api\Akreditasi\BuktiController;
use App\Http\Controllers\Api\Akreditasi\LembarProdiController;
use App\Http\Controllers\Api\Akreditasi\ProjectAkreditasiController;
use App\Http\Controllers\Api\Akreditasi\SelfAssessmentController;
use App\Http\Controllers\Api\Master\IndikatorController;
use App\Http\Controllers\Api\Master\JenisBuktiController;
use App\Http\Controllers\Api\Master\JenisPembiayaanController;
use App\Http\Controllers\Api\Master\KriteriaController;
use App\Http\Controllers\Api\Master\RubrikController;
use App\Http\Controllers\Api\Master\StandarMutuController;
use App\Http\Controllers\Api\Spmi\SpmiAuditController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| 1. Master Data System & Referensi Endpoints
|--------------------------------------------------------------------------
*/
Route::prefix('master')->group(function () {
    Route::apiResource('kriteria', KriteriaController::class);
    Route::apiResource('indikator', IndikatorController::class);
    Route::apiResource('rubrik', RubrikController::class);
    Route::apiResource('standar-mutu', StandarMutuController::class);
    Route::apiResource('jenis-bukti', JenisBuktiController::class);
    Route::apiResource('jenis-pembiayaan', JenisPembiayaanController::class);
});

/*
|--------------------------------------------------------------------------
| 2. Akreditasi Eksternal Endpoints
|--------------------------------------------------------------------------
*/
Route::prefix('akreditasi')->group(function () {
    // Project Akreditasi & Pembagian Tim
    Route::apiResource('project', ProjectAkreditasiController::class);
    Route::post('project/{projectId}/mapping-tim', [ProjectAkreditasiController::class, 'storeMappingTim']);

    // Lembar Kerja Prodi
    Route::get('lembar-prodi', [LembarProdiController::class, 'index']);
    Route::post('lembar-prodi', [LembarProdiController::class, 'storeOrUpdate']);
    Route::get('lembar-prodi/{id}', [LembarProdiController::class, 'show']);
    Route::delete('lembar-prodi/{id}', [LembarProdiController::class, 'destroy']);

    // Berkas Bukti & Validasi
    Route::get('bukti', [BuktiController::class, 'index']);
    Route::post('bukti', [BuktiController::class, 'store']);
    Route::get('bukti/{id}', [BuktiController::class, 'show']);
    Route::patch('bukti/{id}/status', [BuktiController::class, 'updateStatusValidasi']);
    Route::delete('bukti/{id}', [BuktiController::class, 'destroy']);

    // Self Assessment / Penilaian Mandiri Reviewer
    Route::get('self-assessment', [SelfAssessmentController::class, 'index']);
    Route::post('self-assessment', [SelfAssessmentController::class, 'storeOrUpdate']);
    Route::get('self-assessment/{id}', [SelfAssessmentController::class, 'show']);
    Route::delete('self-assessment/{id}', [SelfAssessmentController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| 3. Penjaminan Mutu Internal (SPMI) Endpoints
|--------------------------------------------------------------------------
*/
Route::prefix('spmi')->group(function () {
    Route::apiResource('audit', SpmiAuditController::class);
    Route::patch('audit/{id}/tindak-lanjut', [SpmiAuditController::class, 'updateTindakLanjut']);
});
