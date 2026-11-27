<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Models\ProjectAkreditasi;
use App\Services\External\DosenApiService;
use App\Services\External\ProdiApiService;
use App\Services\External\TridharmaApiService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class DataSummaryController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ProdiApiService $prodiApiService,
        protected DosenApiService $dosenApiService,
        protected TridharmaApiService $tridharmaApiService,
    ) {}

    public function show(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);
        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $prodi = $this->prodiApiService->getProdiById($project->id_prodi);
        $dosen = $this->dosenApiService->getDtpsProfile();
        $tridharma = $this->tridharmaApiService->getSummary();

        return $this->successResponse([
            'project' => [
                'id' => $project->id,
                'id_prodi' => $project->id_prodi,
                'tahun' => $project->tahun_target_submit,
            ],
            'prodi' => $prodi,
            'mahasiswa' => [
                'total_aktif' => $this->prodiApiService->getMahasiswaAktifCount(),
                'source' => 'akademik:/api/mahasiswa',
            ],
            'dosen' => $dosen,
            'tridharma' => $tridharma,
            'meta' => [
                'is_simulation' => (bool) data_get($tridharma, '_meta.is_simulation', false),
                'pending' => [
                    'akademik:/api/tracer-study',
                    'tridharma:pendanaan kegiatan',
                ],
            ],
        ], 'Ringkasan data akreditasi berhasil diambil');
    }
}
