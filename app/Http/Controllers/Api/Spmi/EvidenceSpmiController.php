<?php

namespace App\Http\Controllers\Api\Spmi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spmi\StoreEvidenceSpmiRequest;
use App\Models\EvidenceSpmi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EvidenceSpmiController extends Controller
{
    use ApiResponseTrait;

    /**
     * Mengambil data evidence SPMI untuk project tertentu.
     */
    public function show(Request $request, ?int $id = null): JsonResponse
    {
        $projectId = $request->query('project_id') ?? $id;

        if (! $projectId) {
            return $this->errorResponse('Parameter project_id wajib disertakan.', [
                'project_id' => ['Parameter project_id wajib disertakan.'],
            ], 422);
        }

        $evidence = EvidenceSpmi::where('project_id', $projectId)->first();

        return $this->successResponse($evidence, 'Data evidence SPMI berhasil diambil');
    }

    /**
     * Menyimpan atau memperbarui data evidence SPMI (updateOrCreate).
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
}
