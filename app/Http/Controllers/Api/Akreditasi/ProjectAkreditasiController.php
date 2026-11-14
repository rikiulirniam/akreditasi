<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreMappingTimRequest;
use App\Http\Requests\Akreditasi\StoreProjectAkreditasiRequest;
use App\Http\Requests\Akreditasi\UpdateProjectAkreditasiRequest;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectAkreditasiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = ProjectAkreditasi::with(['versiInstrumen', 'jenjang', 'jenisInstrumen']);

        if ($request->filled('id_prodi')) {
            $query->where('id_prodi', $request->query('id_prodi'));
        }
        if ($request->filled('id_jenjang')) {
            $query->where('id_jenjang', $request->query('id_jenjang'));
        }
        if ($request->filled('status_project')) {
            $query->where('status_project', $request->query('status_project'));
        }

        $projects = $query->latest()->get();

        return $this->successResponse($projects, 'Daftar project akreditasi berhasil diambil');
    }

    public function store(StoreProjectAkreditasiRequest $request): JsonResponse
    {
        $project = ProjectAkreditasi::create($request->validated());

        return $this->successResponse($project, 'Project akreditasi berhasil dibuat', 201);
    }

    public function show(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::with([
            'versiInstrumen',
            'jenjang',
            'jenisInstrumen',
            'mappingTim.indikator',
            'lembarProdi.buktis',
            'selfAssessments.rubrik',
        ])->find($id);

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
     * Memperbarui siklus status project akreditasi.
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status_project' => 'required|string|in:Draft,On Progress,Pending,Cancel,Selesai',
            'tanggal_verifikasi_akreditasi' => 'nullable|date',
            'nomor_sk_akreditasi' => 'nullable|string|max:255',
        ]);

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

        if ($validated['status_project'] === 'Selesai' && (empty($tanggalVerifikasi) || empty($nomorSk))) {
            return $this->errorResponse(
                'Status Selesai ditolak. Tanggal verifikasi akreditasi dan nomor SK akreditasi wajib diisi.',
                [
                    'status_project' => ['Tanggal verifikasi akreditasi dan nomor SK akreditasi wajib terisi untuk menyelesaikan project.'],
                ],
                422
            );
        }

        $project->update([
            'status_project' => $validated['status_project'],
            'tanggal_verifikasi_akreditasi' => $tanggalVerifikasi,
            'nomor_sk_akreditasi' => $nomorSk,
        ]);

        return $this->successResponse($project->fresh(), 'Status project akreditasi berhasil diperbarui');
    }
}
