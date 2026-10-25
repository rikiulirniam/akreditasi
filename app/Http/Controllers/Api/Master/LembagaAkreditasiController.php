<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreLembagaAkreditasiRequest;
use App\Http\Requests\Master\UpdateLembagaAkreditasiRequest;
use App\Models\LembagaAkreditasi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class LembagaAkreditasiController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $data = LembagaAkreditasi::with('versiInstrumen')->latest()->get();

        return $this->successResponse($data, 'Data lembaga akreditasi berhasil diambil');
    }

    public function store(StoreLembagaAkreditasiRequest $request): JsonResponse
    {
        $lembaga = LembagaAkreditasi::create($request->validated());

        return $this->successResponse($lembaga, 'Lembaga akreditasi berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $lembaga = LembagaAkreditasi::with(['versiInstrumen.kriteria'])->find($id);

        if (! $lembaga) {
            return $this->errorResponse('Lembaga akreditasi tidak ditemukan', null, 404);
        }

        return $this->successResponse($lembaga, 'Detail lembaga akreditasi berhasil diambil');
    }

    public function update(UpdateLembagaAkreditasiRequest $request, int $id): JsonResponse
    {
        $lembaga = LembagaAkreditasi::find($id);

        if (! $lembaga) {
            return $this->errorResponse('Lembaga akreditasi tidak ditemukan', null, 404);
        }

        $lembaga->update($request->validated());

        return $this->successResponse($lembaga, 'Lembaga akreditasi berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $lembaga = LembagaAkreditasi::find($id);

        if (! $lembaga) {
            return $this->errorResponse('Lembaga akreditasi tidak ditemukan', null, 404);
        }

        $lembaga->delete();

        return $this->successResponse(null, 'Lembaga akreditasi berhasil dihapus');
    }
}
