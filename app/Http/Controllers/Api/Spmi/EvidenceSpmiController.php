<?php

namespace App\Http\Controllers\Api\Spmi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spmi\StoreEvidenceSpmiRequest;
use App\Http\Resources\EvidenceOverviewResource;
use App\Models\EvidenceSpmi;
use App\Models\ProjectAkreditasi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EvidenceSpmiController extends Controller
{
    use ApiResponseTrait;

    /**
     * Mengambil data evidence SPMI untuk project akreditasi tertentu.
     */
    public function show(Request $request, ?int $id = null): JsonResponse
    {
        $projectId = $request->query('project_id') ?? $request->query('id_project') ?? $id;

        if (! $projectId) {
            return $this->errorResponse('Parameter project_id wajib disertakan.', [
                'project_id' => ['Parameter project_id wajib disertakan.'],
            ], 422);
        }

        $evidence = EvidenceSpmi::where('project_id', $projectId)->first();

        return $this->successResponse($evidence, 'Data evidence SPMI berhasil diambil');
    }

    /**
     * Menyimpan atau memperbarui data evidence SPMI (updateOrCreate berbasis project_id).
     */
    public function store(StoreEvidenceSpmiRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $evidence = EvidenceSpmi::updateOrCreate(
            ['project_id' => $validated['project_id']],
            $validated
        );

        $evidence->refresh();

        return $this->successResponse($evidence, 'Evidence SPMI berhasil disimpan', 200);
    }

    /**
     * Rekapitulasi evidence overview untuk sebuah project akreditasi.
     *
     * Endpoint: GET /api/v1/projects/{id}/evidence-overview
     * Menampilkan ringkasan 4 pilar evidence, daftar indikator yang ditugaskan,
     * serta riwayat status temuan audit SPMI (Open/Closed).
     */
    public function overview(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::with([
            'evidenceSpmi',
            'mappingTim.indikator',
            'dataSpmiAudit',
        ])->find($id);

        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan.', [
                'id' => ['Project akreditasi dengan ID tersebut tidak ditemukan.'],
            ], 404);
        }

        return $this->successResponse(
            new EvidenceOverviewResource($project),
            'Rekapitulasi evidence overview berhasil diambil'
        );
    }
}
