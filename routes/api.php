<?php

use App\Http\Controllers\Api\Akreditasi\MappingTimAkreditasiController;
use App\Http\Controllers\Api\Akreditasi\ProjectAkreditasiController;
use App\Http\Controllers\Api\Akreditasi\SelfAssessmentController;
use App\Http\Controllers\Api\Master\IndikatorController;
use App\Http\Controllers\Api\Master\InstrumenController;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (Version 1 - Protected by JWT & Role-Based Access Control)
|--------------------------------------------------------------------------
| Seluruh endpoint REST API di bawah diproteksi oleh middleware JWT (jwt.auth)
| dan pembagian hak akses per role (administrator, reviewer, kaprodi, dosen).
*/

Route::prefix('v1')->middleware('jwt.auth')->group(function () {

    // Profil pengguna terautentikasi (semua role yang valid)
    Route::get('auth/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Profil pengguna terautentikasi berhasil diambil.',
            'data' => [
                'user' => $request->user(),
            ],
            'errors' => null,
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | 1. Modul Master Data
    |--------------------------------------------------------------------------
    | Read (GET): Semua role (administrator, kaprodi, reviewer, dosen)
    | Write/Modify (POST, PUT, DELETE): Khusus administrator
    */
    Route::prefix('master')->group(function () {
        // Read-only untuk kebutuhan instrumen semua role
        Route::middleware('role:administrator,kaprodi,reviewer,dosen')->group(function () {
            Route::get('lembaga-akreditasi', [LembagaAkreditasiController::class, 'index']);
            Route::get('lembaga-akreditasi/{id}', [LembagaAkreditasiController::class, 'show']);

            Route::get('versi-instrumen', [VersiInstrumenController::class, 'index']);
            Route::get('versi-instrumen/{id}', [VersiInstrumenController::class, 'show']);

            Route::get('instrumen', [InstrumenController::class, 'index']);
            Route::get('instrumen/{id}', [InstrumenController::class, 'show']);

            Route::get('jenjang', [JenjangController::class, 'index']);
            Route::get('jenjang/{id}', [JenjangController::class, 'show']);

            Route::get('kriteria', [KriteriaController::class, 'index']);
            Route::get('kriteria/{id}', [KriteriaController::class, 'show']);

            Route::get('subkriteria', [SubkriteriaController::class, 'index']);
            Route::get('subkriteria/{id}', [SubkriteriaController::class, 'show']);

            Route::get('indikator', [IndikatorController::class, 'index']);
            Route::get('indikator/{id}', [IndikatorController::class, 'show']);

            Route::get('rubrik', [RubrikController::class, 'index']);
            Route::get('rubrik/{id}', [RubrikController::class, 'show']);

            Route::get('standar-mutu', [StandarMutuController::class, 'index']);
            Route::get('standar-mutu/{id}', [StandarMutuController::class, 'show']);

            Route::get('jenis-pembiayaan', [JenisPembiayaanController::class, 'index']);
            Route::get('jenis-pembiayaan/{id}', [JenisPembiayaanController::class, 'show']);
        });

        // Write operations: Khusus Administrator
        Route::middleware('role:administrator')->group(function () {
            Route::apiResource('lembaga-akreditasi', LembagaAkreditasiController::class)->except(['index', 'show']);
            Route::apiResource('versi-instrumen', VersiInstrumenController::class)->except(['index', 'show']);
            Route::apiResource('instrumen', InstrumenController::class)->except(['index', 'show']);
            Route::apiResource('jenjang', JenjangController::class)->except(['index', 'show']);
            Route::apiResource('kriteria', KriteriaController::class)->except(['index', 'show']);
            Route::apiResource('subkriteria', SubkriteriaController::class)->except(['index', 'show']);
            Route::apiResource('indikator', IndikatorController::class)->except(['index', 'show']);
            Route::apiResource('rubrik', RubrikController::class)->except(['index', 'show']);
            Route::apiResource('standar-mutu', StandarMutuController::class)->except(['index', 'show']);
            Route::apiResource('jenis-pembiayaan', JenisPembiayaanController::class)->except(['index', 'show']);
        });
    });

    // Direct alias endpoint untuk akses master instrumen & kriteria tanpa prefix /master/
    Route::middleware('role:administrator,kaprodi,reviewer,dosen')->group(function () {
        Route::get('instrumen', [InstrumenController::class, 'index']);
        Route::get('instrumen/{id}', [InstrumenController::class, 'show']);

        Route::get('kriteria', [KriteriaController::class, 'index']);
        Route::get('kriteria/{id}', [KriteriaController::class, 'show']);

        Route::get('subkriteria', [SubkriteriaController::class, 'index']);
        Route::get('subkriteria/{id}', [SubkriteriaController::class, 'show']);

        Route::get('indikator', [IndikatorController::class, 'index']);
        Route::get('indikator/{id}', [IndikatorController::class, 'show']);

        Route::get('rubrik', [RubrikController::class, 'index']);
        Route::get('rubrik/{id}', [RubrikController::class, 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | 2. Modul Akreditasi
    |--------------------------------------------------------------------------
    | Project Akreditasi:
    |   - Read (GET): administrator, kaprodi, reviewer, dosen
    |   - Write (POST, PUT, DELETE): administrator, kaprodi
    | Mapping Tim Akreditasi:
    |   - Read (GET): administrator, kaprodi, reviewer, dosen
    |   - Write (POST, DELETE): administrator, kaprodi
    | Self Assessment / Penilaian Reviewer:
    |   - Read (GET): administrator, reviewer, kaprodi
    |   - Write (POST, DELETE penilaian): administrator, reviewer
    */
    // Project Akreditasi
    Route::middleware('role:administrator,kaprodi,reviewer,dosen')->group(function () {
        Route::get('projects', [ProjectAkreditasiController::class, 'index']);
        Route::get('projects/{id}', [ProjectAkreditasiController::class, 'show']);
    });

    Route::middleware('role:administrator,kaprodi')->group(function () {
        Route::post('projects', [ProjectAkreditasiController::class, 'store']);
        Route::put('projects/{id}', [ProjectAkreditasiController::class, 'update']);
        Route::patch('projects/{id}', [ProjectAkreditasiController::class, 'update']);
        Route::delete('projects/{id}', [ProjectAkreditasiController::class, 'destroy']);

        Route::post('projects/{id}/mapping-tim', [ProjectAkreditasiController::class, 'storeMappingTim']);
        Route::post('mapping-tim', [MappingTimAkreditasiController::class, 'store']);
        Route::delete('mapping-tim/{id}', [MappingTimAkreditasiController::class, 'destroy']);
    });

    Route::get('mapping-tim', [MappingTimAkreditasiController::class, 'index'])
        ->middleware('role:administrator,kaprodi,reviewer,dosen');

    // Self Assessment / Penilaian Mandiri Reviewer
    Route::middleware('role:administrator,reviewer,kaprodi')->group(function () {
        Route::get('self-assessment', [SelfAssessmentController::class, 'index']);
        Route::get('self-assessment/{id}', [SelfAssessmentController::class, 'show']);
    });

    Route::middleware('role:administrator,reviewer')->group(function () {
        Route::post('self-assessment', [SelfAssessmentController::class, 'storeOrUpdate']);
        Route::delete('self-assessment/{id}', [SelfAssessmentController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | 3. Modul SPMI & Audit
    |--------------------------------------------------------------------------
    | Read (GET): administrator, kaprodi, reviewer
    | Write (POST, PUT, DELETE, Tindak Lanjut): administrator, kaprodi
    */
    Route::middleware('role:administrator,kaprodi,reviewer')->group(function () {
        Route::get('spmi-audit', [SpmiAuditController::class, 'index']);
        Route::get('spmi-audit/{id}', [SpmiAuditController::class, 'show']);
    });

    Route::middleware('role:administrator,kaprodi')->group(function () {
        Route::post('spmi-audit', [SpmiAuditController::class, 'store']);
        Route::put('spmi-audit/{id}', [SpmiAuditController::class, 'update']);
        Route::patch('spmi-audit/{id}', [SpmiAuditController::class, 'update']);
        Route::delete('spmi-audit/{id}', [SpmiAuditController::class, 'destroy']);
        Route::put('spmi-audit/{id}/tindak-lanjut', [SpmiAuditController::class, 'updateTindakLanjut']);
        Route::patch('spmi-audit/{id}/tindak-lanjut', [SpmiAuditController::class, 'updateTindakLanjut']);
    });

    /*
    |--------------------------------------------------------------------------
    | 4. Modul Sarana & Prasarana
    |--------------------------------------------------------------------------
    | Read (GET): administrator, kaprodi, reviewer, dosen
    | Write (POST, PUT, DELETE): administrator, kaprodi
    */
    Route::middleware('role:administrator,kaprodi,reviewer,dosen')->group(function () {
        Route::get('sarpras-prodi', [DataSarprasProdiController::class, 'index']);
        Route::get('sarpras-prodi/{id}', [DataSarprasProdiController::class, 'show']);
        Route::get('sarana-prodi', [DataSaranaProdiController::class, 'index']);
        Route::get('sarana-prodi/{id}', [DataSaranaProdiController::class, 'show']);
    });

    Route::middleware('role:administrator,kaprodi')->group(function () {
        Route::post('sarpras-prodi', [DataSarprasProdiController::class, 'store']);
        Route::put('sarpras-prodi/{id}', [DataSarprasProdiController::class, 'update']);
        Route::patch('sarpras-prodi/{id}', [DataSarprasProdiController::class, 'update']);
        Route::delete('sarpras-prodi/{id}', [DataSarprasProdiController::class, 'destroy']);

        Route::post('sarana-prodi', [DataSaranaProdiController::class, 'store']);
        Route::put('sarana-prodi/{id}', [DataSaranaProdiController::class, 'update']);
        Route::patch('sarana-prodi/{id}', [DataSaranaProdiController::class, 'update']);
        Route::delete('sarana-prodi/{id}', [DataSaranaProdiController::class, 'destroy']);
    });
});
