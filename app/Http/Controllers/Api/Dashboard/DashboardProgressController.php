<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\ProjectIndicatorEvidence;
use App\Models\SelfAssessment;
use App\Models\VersiInstrumen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardProgressController extends Controller
{
    use ApiResponseTrait;

    public function dashboardProgress(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $instrument = $this->findProjectInstrument($project);

        if (! $instrument) {
            return $this->errorResponse('Instrumen untuk project ini tidak ditemukan', null, 404);
        }

        $criteria = $instrument->kriterias()
            ->with('subkriteria.indikator')
            ->orderBy('id')
            ->get();

        $indicatorIds = $criteria
            ->flatMap(fn ($criterion) => $criterion->subkriteria->flatMap(
                fn ($subcriterion) => $subcriterion->indikator->pluck('id')
            ))
            ->values();

        $evidencedIndicatorIds = ProjectIndicatorEvidence::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->whereNotNull('link_evidence')
            ->where('link_evidence', '<>', '')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();

        $criteriaProgress = $criteria->map(function ($criterion) use ($evidencedIndicatorIds): array {
            $indicators = $criterion->subkriteria->flatMap(
                fn ($subcriterion) => $subcriterion->indikator
            );
            $totalIndicators = $indicators->count();
            $completedIndicators = $indicators->filter(
                fn ($indicator) => $evidencedIndicatorIds->has((int) $indicator->id)
            )->count();

            return [
                'id' => $criterion->id,
                'kode_kriteria' => $criterion->kode_kriteria,
                'nama_kriteria' => $criterion->nama_kriteria,
                'total_indikator' => $totalIndicators,
                'indikator_terisi_bukti' => $completedIndicators,
                'progres_persen' => $totalIndicators > 0
                    ? round(($completedIndicators / $totalIndicators) * 100, 2)
                    : 0,
            ];
        });

        $totalIndicators = $indicatorIds->count();
        $completedIndicators = $evidencedIndicatorIds->count();

        return $this->successResponse([
            'project_id' => $project->id,
            'kriteria' => $criteriaProgress,
            'total_indikator' => $totalIndicators,
            'indikator_terisi_bukti' => $completedIndicators,
            'progres_total_persen' => $totalIndicators > 0
                ? round(($completedIndicators / $totalIndicators) * 100, 2)
                : 0,
        ], 'Metrik progres dashboard berhasil dihitung');
    }

    public function readiness(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $instrument = $this->findProjectInstrument($project);

        if (! $instrument) {
            return $this->errorResponse('Instrumen untuk project ini tidak ditemukan', null, 404);
        }

        $indicators = $instrument->kriterias()
            ->with('subkriteria.indikator')
            ->orderBy('id')
            ->get()
            ->flatMap(fn ($criterion) => $criterion->subkriteria->flatMap(
                fn ($subcriterion) => $subcriterion->indikator
            ));

        $indicatorIds = $indicators->pluck('id');
        $picAssignments = MappingTimAkreditasi::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->where(function ($query): void {
                $query->whereNull('role')->orWhereRaw('UPPER(role) = ?', ['PIC']);
            })
            ->whereNotNull('id_user')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();
        $evidencedIndicators = ProjectIndicatorEvidence::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->whereNotNull('link_evidence')
            ->where('link_evidence', '<>', '')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();
        $scoredIndicators = SelfAssessment::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->whereNotNull('skor_terbobot')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();

        $notReadyIndicators = $indicators->map(function (Indikator $indicator) use (
            $picAssignments,
            $evidencedIndicators,
            $scoredIndicators
        ): ?array {
            $missing = [];

            if (! $picAssignments->has((int) $indicator->id)) {
                $missing[] = 'pic';
            }
            if (! $evidencedIndicators->has((int) $indicator->id)) {
                $missing[] = 'link_evidence';
            }
            if (! $scoredIndicators->has((int) $indicator->id)) {
                $missing[] = 'skor_reviewer';
            }

            if ($missing === []) {
                return null;
            }

            return [
                'id_indikator' => $indicator->id,
                'kode_indikator' => $indicator->kode_indikator,
                'deskripsi_indikator' => $indicator->deskripsi_indikator,
                'belum_terpenuhi' => $missing,
            ];
        })->filter()->values();

        return $this->successResponse([
            'project_id' => $project->id,
            'total_indikator_kritis' => $indicators->count(),
            'indikator_belum_siap' => $notReadyIndicators,
            'jumlah_indikator_belum_siap' => $notReadyIndicators->count(),
            'siap_submit' => $notReadyIndicators->isEmpty(),
        ], 'Pengecekan kesiapan submit berhasil dilakukan');
    }

    public function quickCreate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_prodi' => ['required', 'integer'],
        ]);

        $version = VersiInstrumen::query()
            ->where('nomor_versi', '2.1')
            ->where('status_aktif', true)
            ->orderByDesc('tanggal_berlaku')
            ->first();
        $jenjang = Jenjang::query()
            ->where('nama_jenjang', 'Sarjana Terapan')
            ->first();
        $jenisInstrumen = JenisInstrumen::query()
            ->where('nama_jenis', 'Instrumen APS untuk Status Terakreditasi Unggul')
            ->first();

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

    private function findProjectInstrument(ProjectAkreditasi $project): ?Instrumen
    {
        return Instrumen::query()
            ->where('id_versi_instrumen', $project->id_versi_instrumen)
            ->where('id_jenjang', $project->id_jenjang)
            ->where('id_jenis_instrumen', $project->id_jenis_instrumen)
            ->first();
    }

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
