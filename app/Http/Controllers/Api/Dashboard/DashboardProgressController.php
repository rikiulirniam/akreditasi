<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\ProjectAkreditasi;
use App\Models\ProjectIndicatorEvidence;
use App\Models\VersiInstrumen;
use App\Services\Akreditasi\DashboardMetricsService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardProgressController extends Controller
{
    use ApiResponseTrait;

    /**
     * Menyuntikkan service agregasi yang dipakai dashboard dan readiness.
     */
    public function __construct(
        protected DashboardMetricsService $dashboardMetricsService,
    ) {}

    /**
     * Mengembalikan progres pengisian bukti untuk seluruh kriteria project.
     */
    public function dashboardProgress(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $progress = $this->dashboardMetricsService->getDashboardProgress($project);

        if (! $progress['instrument_found']) {
            return $this->errorResponse('Instrumen untuk project ini tidak ditemukan', null, 404);
        }
        unset($progress['instrument_found']);

        return $this->successResponse($progress, 'Metrik progres dashboard berhasil dihitung');
    }

    /**
     * Mengembalikan daftar indikator yang belum memenuhi syarat submit.
     */
    public function readiness(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $readiness = $this->dashboardMetricsService->getReadiness($project);

        if (! $readiness['instrument_found']) {
            return $this->errorResponse('Instrumen untuk project ini tidak ditemukan', null, 404);
        }
        unset($readiness['instrument_found']);

        return $this->successResponse($readiness, 'Pengecekan kesiapan submit berhasil dilakukan');
    }

    /**
     * Membuat project ringkas berdasarkan master data TRK yang aktif.
     */
    public function quickCreate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_prodi' => ['required', 'integer'],
        ]);

        $jenjang = Jenjang::query()
            ->where('nama_jenjang', 'Sarjana Terapan')
            ->first();
        $jenisInstrumen = JenisInstrumen::query()
            ->where('nama_jenis', 'Instrumen APS untuk Status Terakreditasi Unggul')
            ->first();

        $version = null;
        if ($jenjang) {
            $version = VersiInstrumen::query()
                ->where('nomor_versi', '2.1')
                ->whereHas('jenjangs', function ($j) use ($jenjang) {
                    $j->where('jenjang.id', $jenjang->id)
                        ->where('versi_instrumen_jenjang.status_aktif', true);
                })
                ->orderByDesc('tanggal_berlaku')
                ->first();
        }

        if (! $version || ! $jenjang || ! $jenisInstrumen) {
            return $this->errorResponse(
                'Master data aktif untuk pembuatan project TRK belum lengkap',
                [
                    'master_data' => [
                        'Pastikan versi instrumen 2.1 aktif, jenjang Sarjana Terapan, dan jenis Akreditasi Unggul tersedia.',
                    ],
                ],
                422
            );
        }

        $instrumentExists = Instrumen::query()
            ->where('id_versi_instrumen', $version->id)
            ->where('id_jenjang', $jenjang->id)
            ->where('id_jenis_instrumen', $jenisInstrumen->id)
            ->exists();

        if (! $instrumentExists) {
            return $this->errorResponse(
                'Instrumen aktif untuk kombinasi project TRK tidak ditemukan',
                ['instrumen' => ['Instrumen 2.1 untuk Sarjana Terapan dan Akreditasi Unggul belum tersedia.']],
                422
            );
        }

        $year = now()->year;
        $project = DB::transaction(fn () => ProjectAkreditasi::create([
            'id_prodi' => $validated['id_prodi'],
            'id_versi_instrumen' => $version->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenisInstrumen->id,
            'nama_project' => 'Akreditasi Program Studi TRK '.$year,
            'tahun_target_submit' => $year,
            'status_project' => 'Draft',
        ]));

        return $this->successResponse($project, 'Project TRK berhasil dibuat', 201);
    }

    /**
     * Menampilkan link evidence milik satu indikator pada project.
     */
    public function showEvidence(int $id, int $indicatorId): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        if (! $this->projectContainsIndicator($project, $indicatorId)) {
            return $this->errorResponse('Indikator tidak ditemukan pada project ini', null, 404);
        }

        $evidence = ProjectIndicatorEvidence::query()
            ->where('id_project', $project->id)
            ->where('id_indikator', $indicatorId)
            ->first();

        return $this->successResponse($evidence, 'Bukti indikator berhasil diambil');
    }

    /**
     * Menyimpan atau memperbarui link evidence satu indikator project.
     */
    public function storeEvidence(Request $request, int $id, int $indicatorId): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        if (! $this->projectContainsIndicator($project, $indicatorId)) {
            return $this->errorResponse('Indikator tidak ditemukan pada project ini', null, 404);
        }

        $validated = $request->validate([
            'link_evidence' => ['required', 'string', 'max:2048'],
        ]);

        $evidence = ProjectIndicatorEvidence::updateOrCreate(
            [
                'id_project' => $project->id,
                'id_indikator' => $indicatorId,
            ],
            ['link_evidence' => $validated['link_evidence']]
        );

        return $this->successResponse($evidence, 'Bukti indikator berhasil disimpan');
    }

    /**
     * Mencari instrumen yang sesuai dengan versi, jenjang, dan jenis project.
     */
    private function findProjectInstrument(ProjectAkreditasi $project): ?Instrumen
    {
        return Instrumen::query()
            ->where('id_versi_instrumen', $project->id_versi_instrumen)
            ->where('id_jenjang', $project->id_jenjang)
            ->where('id_jenis_instrumen', $project->id_jenis_instrumen)
            ->first();
    }

    /**
     * Memastikan indikator memang termasuk pada instrumen milik project.
     */
    private function projectContainsIndicator(ProjectAkreditasi $project, int $indicatorId): bool
    {
        $instrument = $this->findProjectInstrument($project);

        if (! $instrument) {
            return false;
        }

        return Indikator::query()
            ->whereKey($indicatorId)
            ->whereHas('subkriteria.kriteria', fn ($query) => $query->where('id_instrumen', $instrument->id))
            ->exists();
    }
}
