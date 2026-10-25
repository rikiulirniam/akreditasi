<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreIndikatorRequest;
use App\Http\Requests\Master\UpdateIndikatorRequest;
use App\Models\Indikator;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class IndikatorController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        // Dihapus 'bobots' dari with()
        $data = Indikator::with(['subkriteria', 'rubriks'])->latest()->get();

        return $this->successResponse($data, 'Data indikator berhasil diambil');
    }

    public function store(StoreIndikatorRequest $request): JsonResponse
    {
        $indikator = Indikator::create($request->validated());

        return $this->successResponse($indikator, 'Indikator berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        // Dihapus 'bobots' dari with()
        $indikator = Indikator::with(['subkriteria.kriteria', 'rubriks'])->find($id);

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

        return $this->successResponse($indikator, 'Indikator berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $indikator = Indikator::find($id);

        if (! $indikator) {
            return $this->errorResponse('Indikator tidak ditemukan', null, 404);
        }

        $indikator->delete();

        return $this->successResponse(null, 'Indikator berhasil dihapus');
    }
}
