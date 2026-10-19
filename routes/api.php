<?php

use App\Http\Controllers\Api\Akreditasi\BuktiController;
use App\Http\Controllers\Api\Akreditasi\LembarProdiController;
use App\Http\Controllers\Api\Akreditasi\ProjectAkreditasiController;
use App\Http\Controllers\Api\Akreditasi\SelfAssessmentController;
use App\Http\Controllers\Api\Master\IndikatorController;
use App\Http\Controllers\Api\Master\JenisBuktiController;
use App\Http\Controllers\Api\Master\JenisPembiayaanController;
use App\Http\Controllers\Api\Master\KriteriaController;
use App\Http\Controllers\Api\Master\LembagaAkreditasiController;
use App\Http\Controllers\Api\Master\RubrikController;
use App\Http\Controllers\Api\Master\StandarMutuController;
use App\Http\Controllers\Api\Master\VersiInstrumenController;
use App\Http\Controllers\Api\Sarpras\DataSaranaProdiController;
use App\Http\Controllers\Api\Sarpras\DataSarprasProdiController;
use App\Http\Controllers\Api\Spmi\SpmiAuditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (Version 1 - Open / Public Endpoints)
|--------------------------------------------------------------------------
| Seluruh endpoint REST API di bawah terbuka tanpa middleware auth:sanctum
| maupun role middleware, dengan prefix versi /v1.
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 1. Modul Master Data
    |--------------------------------------------------------------------------
    */
    Route::prefix('master')->group(function () {
        Route::apiResource('lembaga-akreditasi', LembagaAkreditasiController::class);
        Route::apiResource('versi-instrumen', VersiInstrumenController::class);
        Route::apiResource('kriteria', KriteriaController::class);
        Route::apiResource('indikator', IndikatorController::class);
        Route::apiResource('rubrik', RubrikController::class);
        Route::apiResource('standar-mutu', StandarMutuController::class);
        Route::apiResource('jenis-bukti', JenisBuktiController::class);
        Route::apiResource('jenis-pembiayaan', JenisPembiayaanController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | 2. Modul Akreditasi
    |--------------------------------------------------------------------------
    */
    // Project Akreditasi & Pembagian Tim
    Route::apiResource('projects', ProjectAkreditasiController::class);
    Route::post('projects/{id}/mapping-tim', [ProjectAkreditasiController::class, 'storeMappingTim']);

    // Lembar Kerja Prodi (GET, POST, PUT, DELETE)
    Route::get('lembar-prodi', [LembarProdiController::class, 'index']);
    Route::post('lembar-prodi', [LembarProdiController::class, 'storeOrUpdate']);
    Route::put('lembar-prodi', [LembarProdiController::class, 'storeOrUpdate']);
    Route::get('lembar-prodi/{id}', [LembarProdiController::class, 'show']);
    Route::delete('lembar-prodi/{id}', [LembarProdiController::class, 'destroy']);

    // Berkas Bukti & Update Status Validasi (POST, DELETE, PUT status, GET)
    Route::get('bukti', [BuktiController::class, 'index']);
    Route::post('bukti', [BuktiController::class, 'store']);
    Route::get('bukti/{id}', [BuktiController::class, 'show']);
    Route::put('bukti/{id}/status', [BuktiController::class, 'updateStatus']);
    Route::patch('bukti/{id}/status', [BuktiController::class, 'updateStatusValidasi']);
    Route::delete('bukti/{id}', [BuktiController::class, 'destroy']);

    // Self Assessment / Penilaian Mandiri Reviewer (GET, POST, DELETE)
    Route::get('self-assessment', [SelfAssessmentController::class, 'index']);
    Route::post('self-assessment', [SelfAssessmentController::class, 'storeOrUpdate']);
    Route::get('self-assessment/{id}', [SelfAssessmentController::class, 'show']);
    Route::delete('self-assessment/{id}', [SelfAssessmentController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | 3. Modul SPMI & Audit
    |--------------------------------------------------------------------------
    */
    Route::apiResource('spmi-audit', SpmiAuditController::class);
    Route::put('spmi-audit/{id}/tindak-lanjut', [SpmiAuditController::class, 'updateTindakLanjut']);
    Route::patch('spmi-audit/{id}/tindak-lanjut', [SpmiAuditController::class, 'updateTindakLanjut']);

    /*
    |--------------------------------------------------------------------------
    | 4. Modul Sarana & Prasarana
    |--------------------------------------------------------------------------
    */
    Route::apiResource('sarpras-prodi', DataSarprasProdiController::class);
    Route::apiResource('sarana-prodi', DataSaranaProdiController::class);
});
