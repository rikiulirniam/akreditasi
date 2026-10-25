<?php

use App\Http\Controllers\Api\Akreditasi\MappingTimAkreditasiController;
use App\Http\Controllers\Api\Akreditasi\ProjectAkreditasiController;
use App\Http\Controllers\Api\Akreditasi\SelfAssessmentController;
use App\Http\Controllers\Api\Master\IndikatorController;
use App\Http\Controllers\Api\Master\InstrumenController;
use App\Http\Controllers\Api\Master\JenisInstrumenController;
use App\Http\Controllers\Api\Master\JenisPembiayaanController;
use App\Http\Controllers\Api\Master\JenjangController;
use App\Http\Controllers\Api\Master\KriteriaController;
use App\Http\Controllers\Api\Master\LembagaAkreditasiController;
use App\Http\Controllers\Api\Master\RubrikController;
use App\Http\Controllers\Api\Master\StandarMutuController;
use App\Http\Controllers\Api\Master\SubkriteriaController;
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
        Route::apiResource('jenjang', JenjangController::class)->only(['index', 'show']);
        Route::apiResource('jenis-instrumen', JenisInstrumenController::class)->except(['store']);
        Route::apiResource('instrumen', InstrumenController::class);
        Route::apiResource('kriteria', KriteriaController::class);
        Route::apiResource('subkriteria', SubkriteriaController::class);
        Route::apiResource('indikator', IndikatorController::class);
        Route::apiResource('rubrik', RubrikController::class);
        Route::apiResource('standar-mutu', StandarMutuController::class);
        Route::apiResource('jenis-pembiayaan', JenisPembiayaanController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | 2. Modul Akreditasi
    |--------------------------------------------------------------------------
    */
    // Project Akreditasi & Mapping Tim
    Route::apiResource('projects', ProjectAkreditasiController::class);
    Route::post('projects/{id}/mapping-tim', [MappingTimAkreditasiController::class, 'store']);

    // Self Assessment / Penilaian Mandiri Reviewer
    Route::get('self-assessment', [SelfAssessmentController::class, 'index']);
    Route::post('self-assessment', [SelfAssessmentController::class, 'store']);
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
