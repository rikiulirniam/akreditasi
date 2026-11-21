<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreMappingTimRequest;
use App\Http\Requests\Akreditasi\StoreProjectAkreditasiRequest;
use App\Http\Requests\Akreditasi\UpdateProjectAkreditasiRequest;
use App\Http\Requests\Akreditasi\UpdateProjectStatusRequest;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Services\Akreditasi\ScoringCalculationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectAkreditasiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $projects = ProjectAkreditasi::query()
            ->withRelations()
            ->filterByProdi($request->query('id_prodi'))
            ->filterByJenjang($request->query('id_jenjang'))
            ->filterByStatus($request->query('status_project'))
            ->search($request->query('search'))
            ->latest()
            ->get();

        return $this->successResponse($projects, 'Daftar project akreditasi berhasil diambil');
    }

    public function store(StoreProjectAkreditasiRequest $request): JsonResponse
    {
        $project = ProjectAkreditasi::create($request->validated());

        return $this->successResponse($project, 'Project akreditasi berhasil dibuat', 201);
    }

    public function show(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::query()
            ->withFullDetails()
            ->find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        return $this->successResponse($project, 'Detail project akreditasi berhasil diambil');
    }

    public function update(UpdateProjectAkreditasiRequest $request, int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $project->update($request->validated());

        return $this->successResponse($project, 'Project akreditasi berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $project->delete();

        return $this->successResponse(null, 'Project akreditasi berhasil dihapus');
    }

    /**
     * Menyimpan pembagian tugas tim/user per indikator pada project akreditasi.
     */
    public function storeMappingTim(StoreMappingTimRequest $request, int $projectId): JsonResponse
    {
        $project = ProjectAkreditasi::find($projectId);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $validated = $request->validated();
        $createdRecords = [];

        DB::transaction(function () use ($projectId, $validated, &$createdRecords) {
            if (isset($validated['assignments']) && is_array($validated['assignments'])) {
                foreach ($validated['assignments'] as $item) {
                    $role = strtoupper($item['role'] ?? 'PIC');
                    $createdRecords[] = MappingTimAkreditasi::updateOrCreate(
                        [
                            'id_project' => $projectId,
                            'id_indikator' => $item['id_indikator'],
                            'role' => $role,
                        ],
                        [
                            'id_user' => $item['id_user'],
                        ]
                    );
                }
            } else {
                $role = strtoupper($validated['role'] ?? 'PIC');
                $createdRecords[] = MappingTimAkreditasi::updateOrCreate(
                    [
                        'id_project' => $projectId,
                        'id_indikator' => $validated['id_indikator'],
                        'role' => $role,
                    ],
                    [
                        'id_user' => $validated['id_user'],
                    ]
                );
            }
        });

        return $this->successResponse(
            $createdRecords,
            'Pembagian tugas tim akreditasi berhasil disimpan',
            201
        );
    }

    /**
     * Mengambil pembagian tugas tim/user per indikator untuk project tertentu.
     */
    public function getMappingTim(Request $request, int $id): JsonResponse
    {
        $request->merge(['id_project' => $id]);

        return app(MappingTimAkreditasiController::class)->index($request);
    }

    /**
     * Mengambil metadata modul kriteria placeholder (Tata Pamong, Keuangan & Sarpras).
     */
    public function getPlaceholderModules(int $id): JsonResponse
    {
        return app(MappingTimAkreditasiController::class)->getPlaceholderModules($id);
    }

    /**
     * Memperbarui siklus status project akreditasi.
     */
    public function updateStatus(UpdateProjectStatusRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();

        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $tanggalVerifikasi = array_key_exists('tanggal_verifikasi_akreditasi', $validated)
            ? $validated['tanggal_verifikasi_akreditasi']
            : $project->tanggal_verifikasi_akreditasi;

        $nomorSk = array_key_exists('nomor_sk_akreditasi', $validated)
            ? $validated['nomor_sk_akreditasi']
            : $project->nomor_sk_akreditasi;

        $project->update([
            'status_project' => $validated['status_project'],
            'tanggal_verifikasi_akreditasi' => $tanggalVerifikasi,
            'nomor_sk_akreditasi' => $nomorSk,
        ]);

        return $this->successResponse($project->fresh(), 'Status project akreditasi berhasil diperbarui');
    }

    /**
     * Simulasi skor kuantitatif LAM-INFOKOM (SDM Dosen) terintegrasi data live Kelompok 2.
     */
    public function scoringSimulation(Request $request, int $id, ScoringCalculationService $scoringService): JsonResponse
    {
        $project = ProjectAkreditasi::query()
            ->withRelations()
            ->find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $mahasiswaInput = (int) $request->query('jumlah_mahasiswa', 0);
        $result = $scoringService->simulateDosenScoring($project, $mahasiswaInput);

        return $this->successResponse($result, 'Simulasi skor LAM-INFOKOM berhasil dihitung');
    }
}
