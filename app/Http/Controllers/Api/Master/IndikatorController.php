<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreIndikatorRequest;
use App\Http\Requests\Master\UpdateIndikatorRequest;
use App\Models\Indikator;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $idSubkriteria = $request->filled('id_subkriteria') ? (int) $request->query('id_subkriteria') : null;

        $data = Indikator::withDetails()
            ->filterBySubkriteria($idSubkriteria)
            ->orderBy('kode_indikator')
            ->get();

        return $this->successResponse($data, 'Data indikator berhasil diambil');
    }

    public function store(StoreIndikatorRequest $request): JsonResponse
    {
        $indikator = Indikator::create($request->validated());
        $indikator->load(['subkriteria.kriteria'])->loadCount('rubriks');

        return $this->successResponse($indikator, 'Indikator berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $indikator = Indikator::withDetailedRubriks()->find($id);

        if (! $indikator) {
            return $this->errorResponse('Indikator tidak ditemukan', null, 404);
        }

        return $this->successResponse($indikator, 'Detail indikator berhasil diambil');
    }

    public function update(UpdateIndikatorRequest $request, int $id): JsonResponse
    {
        $indikator = Indikator::find($id);

        if (! $indikator) {
            return $this->errorResponse('Indikator tidak ditemukan', null, 404);
        }

        $indikator->update($request->validated());
        $indikator->load(['subkriteria.kriteria'])->loadCount('rubriks');

        return $this->successResponse($indikator, 'Indikator berhasil diperbarui');
    }

    /**
     * Menghapus master indikator dengan proteksi soft guard transaksi aktif.
     */
    public function destroy(int $id): JsonResponse
    {
        $indikator = Indikator::find($id);

        if (! $indikator) {
            return $this->errorResponse('Indikator tidak ditemukan', null, 404);
        }

        if ($indikator->isUsedInActiveTransactions()) {
            return $this->errorResponse(
                'Data tidak dapat dihapus karena telah digunakan dalam penilaian atau penugasan aktif.',
                [
                    'id' => [
                        'Data sedang aktif digunakan pada transaksi penilaian/penugasan.',
                    ],
                ],
                422
            );
        }

        $indikator->delete();

        return $this->successResponse(null, 'Indikator berhasil dihapus');
    }
}
