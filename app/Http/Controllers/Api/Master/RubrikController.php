<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreRubrikRequest;
use App\Http\Requests\Master\UpdateRubrikRequest;
use App\Models\Rubrik;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RubrikController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Rubrik::with('indikator');

        if ($request->filled('id_indikator')) {
            $query->where('id_indikator', $request->query('id_indikator'));
        }

        $data = $query->orderBy('skor')->get();

        return $this->successResponse($data, 'Data rubrik berhasil diambil');
    }

    public function store(StoreRubrikRequest $request): JsonResponse
    {
        $rubrik = Rubrik::create($request->validated());

        return $this->successResponse($rubrik, 'Rubrik berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $rubrik = Rubrik::with('indikator.subkriteria')->find($id);

        if (! $rubrik) {
            return $this->errorResponse('Rubrik tidak ditemukan', null, 404);
        }

        return $this->successResponse($rubrik, 'Detail rubrik berhasil diambil');
    }

    public function update(UpdateRubrikRequest $request, int $id): JsonResponse
    {
        $rubrik = Rubrik::find($id);

        if (! $rubrik) {
            return $this->errorResponse('Rubrik tidak ditemukan', null, 404);
        }

        $rubrik->update($request->validated());

        return $this->successResponse($rubrik, 'Rubrik berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $rubrik = Rubrik::find($id);

        if (! $rubrik) {
            return $this->errorResponse('Rubrik tidak ditemukan', null, 404);
        }

        $sudahDigunakan = $rubrik->selfAssessments()->exists();

        if ($sudahDigunakan) {
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

        $rubrik->delete();

        return $this->successResponse(null, 'Rubrik berhasil dihapus');
    }
}
