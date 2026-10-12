<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreStandarMutuRequest;
use App\Http\Requests\Master\UpdateStandarMutuRequest;
use App\Models\StandarMutu;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class StandarMutuController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $data = StandarMutu::latest()->get();

        return $this->successResponse($data, 'Data standar mutu berhasil diambil');
    }

    public function store(StoreStandarMutuRequest $request): JsonResponse
    {
        $standar = StandarMutu::create($request->validated());

        return $this->successResponse($standar, 'Standar mutu berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $standar = StandarMutu::find($id);

        if (! $standar) {
            return $this->errorResponse('Standar mutu tidak ditemukan', null, 404);
        }

        return $this->successResponse($standar, 'Detail standar mutu berhasil diambil');
    }

    public function update(UpdateStandarMutuRequest $request, int $id): JsonResponse
    {
        $standar = StandarMutu::find($id);

        if (! $standar) {
            return $this->errorResponse('Standar mutu tidak ditemukan', null, 404);
        }

        $standar->update($request->validated());

        return $this->successResponse($standar, 'Standar mutu berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $standar = StandarMutu::find($id);

        if (! $standar) {
            return $this->errorResponse('Standar mutu tidak ditemukan', null, 404);
        }

        $standar->delete();

        return $this->successResponse(null, 'Standar mutu berhasil dihapus');
    }
}
