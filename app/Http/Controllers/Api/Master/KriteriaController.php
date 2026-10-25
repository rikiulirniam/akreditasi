<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreKriteriaRequest;
use App\Http\Requests\Master\UpdateKriteriaRequest;
use App\Models\Kriteria;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Kriteria::with([
            'instrumen.versiInstrumen.lembaga',
            'instrumen.jenjang',
            'instrumen.jenisInstrumen',
        ])->withCount('subkriteria');

        if ($request->filled('id_instrumen')) {
            $query->where('id_instrumen', $request->query('id_instrumen'));
        }

        $data = $query->orderBy('kode_kriteria')->get();

        return $this->successResponse($data, 'Data kriteria berhasil diambil');
    }

    public function store(StoreKriteriaRequest $request): JsonResponse
    {
        $kriteria = Kriteria::create($request->validated());
        $kriteria->load([
            'instrumen.versiInstrumen.lembaga',
            'instrumen.jenjang',
            'instrumen.jenisInstrumen',
        ])->loadCount('subkriteria');

        return $this->successResponse($kriteria, 'Kriteria berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $kriteria = Kriteria::with([
            'instrumen.versiInstrumen.lembaga',
            'instrumen.jenjang',
            'instrumen.jenisInstrumen',
            'subkriteria' => function ($q) {
                $q->withCount('indikator')->orderBy('kode_subkriteria');
            },
        ])->withCount('subkriteria')->find($id);

        if (! $kriteria) {
            return $this->errorResponse('Kriteria tidak ditemukan', null, 404);
        }

        return $this->successResponse($kriteria, 'Detail kriteria berhasil diambil');
    }

    public function update(UpdateKriteriaRequest $request, int $id): JsonResponse
    {
        $kriteria = Kriteria::find($id);

        if (! $kriteria) {
            return $this->errorResponse('Kriteria tidak ditemukan', null, 404);
        }

        $kriteria->update($request->validated());
        $kriteria->load([
            'instrumen.versiInstrumen.lembaga',
            'instrumen.jenjang',
            'instrumen.jenisInstrumen',
        ])->loadCount('subkriteria');

        return $this->successResponse($kriteria, 'Kriteria berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $kriteria = Kriteria::find($id);

        if (! $kriteria) {
            return $this->errorResponse('Kriteria tidak ditemukan', null, 404);
        }

        $kriteria->delete();

        return $this->successResponse(null, 'Kriteria berhasil dihapus');
    }
}
