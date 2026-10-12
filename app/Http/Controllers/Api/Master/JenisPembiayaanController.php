<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreJenisPembiayaanRequest;
use App\Http\Requests\Master\UpdateJenisPembiayaanRequest;
use App\Models\JenisPembiayaan;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class JenisPembiayaanController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $data = JenisPembiayaan::latest()->get();

        return $this->successResponse($data, 'Data jenis pembiayaan berhasil diambil');
    }

    public function store(StoreJenisPembiayaanRequest $request): JsonResponse
    {
        $pembiayaan = JenisPembiayaan::create($request->validated());

        return $this->successResponse($pembiayaan, 'Jenis pembiayaan berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $pembiayaan = JenisPembiayaan::find($id);

        if (! $pembiayaan) {
            return $this->errorResponse('Jenis pembiayaan tidak ditemukan', null, 404);
        }

        return $this->successResponse($pembiayaan, 'Detail jenis pembiayaan berhasil diambil');
    }

    public function update(UpdateJenisPembiayaanRequest $request, int $id): JsonResponse
    {
        $pembiayaan = JenisPembiayaan::find($id);

        if (! $pembiayaan) {
            return $this->errorResponse('Jenis pembiayaan tidak ditemukan', null, 404);
        }

        $pembiayaan->update($request->validated());

        return $this->successResponse($pembiayaan, 'Jenis pembiayaan berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $pembiayaan = JenisPembiayaan::find($id);

        if (! $pembiayaan) {
            return $this->errorResponse('Jenis pembiayaan tidak ditemukan', null, 404);
        }

        $pembiayaan->delete();

        return $this->successResponse(null, 'Jenis pembiayaan berhasil dihapus');
    }
}
