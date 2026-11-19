<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectAkreditasi;
use App\Services\Akreditasi\DashboardMetricsService;
use App\Services\Akreditasi\ScoringCalculationService;
use App\Services\External\ProdiApiService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class CompositeProjectController extends Controller
{
    use ApiResponseTrait;

    /**
     * Menyuntikkan service yang diperlukan untuk menyusun overview project.
     */
    public function __construct(
        protected DashboardMetricsService $dashboardMetricsService,
        protected ScoringCalculationService $scoringService,
        protected ProdiApiService $prodiApiService,
    ) {}

    /**
     * Menggabungkan profil project, progress kriteria, evidence, dan simulasi skor.
     */
    public function overview(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::withOverviewProfile()->find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $progress = $this->dashboardMetricsService->getDashboardProgress($project);
        unset($progress['instrument_found']);

        $scoring = $this->scoringService->calculateProjectReviewSummary($project);
        $prodi = $this->prodiApiService->getProdiById($project->id_prodi);

        return $this->successResponse([
            'profil_project' => [
                'id' => $project->id,
                'nama_project' => $project->nama_project,
                'id_prodi' => $project->id_prodi,
                'program_studi' => $prodi,
                'status_project' => $project->status_project,
                'tahun_target_submit' => $project->tahun_target_submit,
                'versi_instrumen' => $project->versiInstrumen,
                'jenjang' => $project->jenjang,
                'jenis_instrumen' => $project->jenisInstrumen,
            ],
            'progress' => $progress,
            'progress_9_kriteria' => $progress['kriteria'],
            'ringkasan_evidence_per_kriteria' => collect($progress['kriteria'])->map(fn (array $criterion) => [
                'id_kriteria' => $criterion['id'],
                'kode_kriteria' => $criterion['kode_kriteria'],
                'nama_kriteria' => $criterion['nama_kriteria'],
                'jumlah_evidence' => $criterion['indikator_terisi_bukti'],
                'total_indikator' => $criterion['total_indikator'],
            ])->values(),
            'simulasi_skor' => [
                'total_skor' => $scoring['total_skor'],
                'predikat' => $scoring['predikat'],
                'threshold_kriteria_d' => $scoring['threshold_kriteria_d'],
                'jumlah_total' => $scoring['jumlah_total'],
                'jumlah_dinilai' => $scoring['jumlah_dinilai'],
                'jumlah_belum_dinilai' => $scoring['jumlah_belum_dinilai'],
                'persentase_kelengkapan' => $scoring['persentase_kelengkapan'],
            ],
        ], 'Composite overview project berhasil diambil');
    }
}
