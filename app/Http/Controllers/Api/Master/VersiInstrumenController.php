<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreVersiInstrumenRequest;
use App\Http\Requests\Master\UpdateVersiInstrumenRequest;
use App\Models\VersiInstrumen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VersiInstrumenController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = VersiInstrumen::with(['lembaga', 'kriteria']);

        if ($request->has('id_lembaga')) {
            $query->where('id_lembaga', $request->query('id_lembaga'));
        }

        if ($request->has('status_aktif')) {
            $query->where('status_aktif', filter_var($request->query('status_aktif'), FILTER_VALIDATE_BOOLEAN));
        }

        $data = $query->latest()->get();

        return $this->successResponse($data, 'Data versi instrumen berhasil diambil');
    }

    public function store(StoreVersiInstrumenRequest $request): JsonResponse
    {
        $versi = VersiInstrumen::create($request->validated());
        $versi->load('lembaga');

        return $this->successResponse($versi, 'Versi instrumen berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $versi = VersiInstrumen::with(['lembaga', 'kriteria.subkriteria'])->find($id);

        if (! $versi) {
            return $this->errorResponse('Versi instrumen tidak ditemukan', null, 404);
        }

        return $this->successResponse($versi, 'Detail versi instrumen berhasil diambil');
    }

    public function update(UpdateVersiInstrumenRequest $request, int $id): JsonResponse
    {
        $versi = VersiInstrumen::find($id);

        if (! $versi) {
            return $this->errorResponse('Versi instrumen tidak ditemukan', null, 404);
        }

        $versi->update($request->validated());
        $versi->load('lembaga');

        return $this->successResponse($versi, 'Versi instrumen berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $versi = VersiInstrumen::find($id);

        if (! $versi) {
            return $this->errorResponse('Versi instrumen tidak ditemukan', null, 404);
        }

        $versi->delete();

        return $this->successResponse(null, 'Versi instrumen berhasil dihapus');
    }
}
