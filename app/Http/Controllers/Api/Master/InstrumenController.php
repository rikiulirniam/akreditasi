<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreInstrumenRequest;
use App\Models\Instrumen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class InstrumenController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $data = Instrumen::with(['versiInstrumen', 'jenjang', 'jenisInstrumen', 'kriterias'])->get();
        return $this->successResponse($data, 'Daftar instrumen berhasil diambil');
    }

    public function store(StoreInstrumenRequest $request): JsonResponse
    {
        $instrumen = Instrumen::create($request->validated());
        $instrumen->load(['versiInstrumen', 'jenjang', 'jenisInstrumen']);

        return $this->successResponse($instrumen, 'Instrumen berhasil ditambahkan', 201);
    }

    public function show(string $id): JsonResponse
    {
        $instrumen = Instrumen::with(['versiInstrumen', 'jenjang', 'jenisInstrumen', 'kriterias'])->find($id);

        if (! $instrumen) {
            return $this->errorResponse('Data instrumen tidak ditemukan', null, 404);
        }

        return $this->successResponse($instrumen, 'Detail instrumen berhasil diambil');
    }

    public function destroy(string $id): JsonResponse
    {
        $instrumen = Instrumen::find($id);

        if (! $instrumen) {
            return $this->errorResponse('Data instrumen tidak ditemukan', null, 404);
        }

        $instrumen->delete();

        return $this->successResponse(null, 'Data instrumen berhasil dihapus');
    }
}
