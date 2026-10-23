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
use Illuminate\Support\Facades\DB;

class ProjectAkreditasiController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $projects = ProjectAkreditasi::with(['versiInstrumen', 'jenjang', 'jenisInstrumen'])
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
                    $createdRecords[] = MappingTimAkreditasi::updateOrCreate(
                        [
                            'id_project' => $projectId,
                            'id_indikator' => $item['id_indikator'],
                            'id_user' => $item['id_user'],
                        ],
                        []
                    );
                }
            } else {
                $createdRecords[] = MappingTimAkreditasi::updateOrCreate(
                    [
                        'id_project' => $projectId,
                        'id_indikator' => $validated['id_indikator'],
                        'id_user' => $validated['id_user'],
                    ],
                    []
                );
            }
        });

        return $this->successResponse(
            $createdRecords,
            'Pembagian tugas tim akreditasi berhasil disimpan',
            201
        );
    }
}
