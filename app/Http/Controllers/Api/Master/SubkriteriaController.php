<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreSubkriteriaRequest;
use App\Http\Requests\Master\UpdateSubkriteriaRequest;
use App\Models\Subkriteria;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubkriteriaController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Subkriteria::with('kriteria')
            ->withCount('indikator');

        if ($request->filled('id_kriteria')) {
            $query->where('id_kriteria', $request->query('id_kriteria'));
        }

        $subkriteria = $query->orderBy('kode_subkriteria')->get();

        return $this->successResponse($subkriteria, 'Data subkriteria berhasil diambil');
    }

    public function store(StoreSubkriteriaRequest $request): JsonResponse
    {
        $subkriteria = Subkriteria::create($request->validated());
        $subkriteria->load('kriteria')->loadCount('indikator');

        return $this->successResponse($subkriteria, 'Subkriteria berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $subkriteria = Subkriteria::with([
            'kriteria',
            'indikator' => function ($q) {
                $q->withCount('rubriks')->orderBy('kode_indikator');
            },
        ])->withCount('indikator')->find($id);

        if (! $subkriteria) {
            return $this->errorResponse('Subkriteria tidak ditemukan', null, 404);
        }

        return $this->successResponse($subkriteria, 'Detail subkriteria berhasil diambil');
    }

    public function update(UpdateSubkriteriaRequest $request, int $id): JsonResponse
    {
        $subkriteria = Subkriteria::find($id);

        if (! $subkriteria) {
            return $this->errorResponse('Subkriteria tidak ditemukan', null, 404);
        }

        $subkriteria->update($request->validated());
        $subkriteria->load('kriteria')->loadCount('indikator');

        return $this->successResponse($subkriteria, 'Subkriteria berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $subkriteria = Subkriteria::find($id);

        if (! $subkriteria) {
            return $this->errorResponse('Subkriteria tidak ditemukan', null, 404);
        }

        $subkriteria->delete();

        return $this->successResponse(null, 'Subkriteria berhasil dihapus');
    }
}
