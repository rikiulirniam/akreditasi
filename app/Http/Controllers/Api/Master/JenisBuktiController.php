<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreJenisBuktiRequest;
use App\Http\Requests\Master\UpdateJenisBuktiRequest;
use App\Models\JenisBukti;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class JenisBuktiController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $data = JenisBukti::latest()->get();

        return $this->successResponse($data, 'Data jenis bukti berhasil diambil');
    }

    public function store(StoreJenisBuktiRequest $request): JsonResponse
    {
        $jenisBukti = JenisBukti::create($request->validated());

        return $this->successResponse($jenisBukti, 'Jenis bukti berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $jenisBukti = JenisBukti::find($id);

        if (! $jenisBukti) {
            return $this->errorResponse('Jenis bukti tidak ditemukan', null, 404);
        }

        return $this->successResponse($jenisBukti, 'Detail jenis bukti berhasil diambil');
    }

    public function update(UpdateJenisBuktiRequest $request, int $id): JsonResponse
    {
        $jenisBukti = JenisBukti::find($id);

        if (! $jenisBukti) {
            return $this->errorResponse('Jenis bukti tidak ditemukan', null, 404);
        }

        $jenisBukti->update($request->validated());

        return $this->successResponse($jenisBukti, 'Jenis bukti berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $jenisBukti = JenisBukti::find($id);

        if (! $jenisBukti) {
            return $this->errorResponse('Jenis bukti tidak ditemukan', null, 404);
        }

        $jenisBukti->delete();

        return $this->successResponse(null, 'Jenis bukti berhasil dihapus');
    }
}
