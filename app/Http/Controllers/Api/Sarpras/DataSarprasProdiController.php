<?php

namespace App\Http\Controllers\Api\Sarpras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sarpras\StoreDataSarprasProdiRequest;
use App\Http\Requests\Sarpras\UpdateDataSarprasProdiRequest;
use App\Models\DataSarprasProdi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataSarprasProdiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = DataSarprasProdi::with(['project', 'sarana']);

        if ($request->has('id_project')) {
            $query->where('id_project', $request->query('id_project'));
        }

        $data = $query->latest()->get();

        return $this->successResponse($data, 'Daftar data prasarana prodi berhasil diambil');
    }

    public function store(StoreDataSarprasProdiRequest $request): JsonResponse
    {
        $sarpras = DataSarprasProdi::create($request->validated());
        $sarpras->load(['project', 'sarana']);

        return $this->successResponse($sarpras, 'Data prasarana prodi berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $sarpras = DataSarprasProdi::with(['project', 'sarana'])->find($id);

        if (! $sarpras) {
            return $this->errorResponse('Data prasarana prodi tidak ditemukan', null, 404);
        }

        return $this->successResponse($sarpras, 'Detail data prasarana prodi berhasil diambil');
    }

    public function update(UpdateDataSarprasProdiRequest $request, int $id): JsonResponse
    {
        $sarpras = DataSarprasProdi::find($id);

        if (! $sarpras) {
            return $this->errorResponse('Data prasarana prodi tidak ditemukan', null, 404);
        }

        $sarpras->update($request->validated());
        $sarpras->load(['project', 'sarana']);

        return $this->successResponse($sarpras, 'Data prasarana prodi berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $sarpras = DataSarprasProdi::find($id);

        if (! $sarpras) {
            return $this->errorResponse('Data prasarana prodi tidak ditemukan', null, 404);
        }

        $sarpras->delete();

        return $this->successResponse(null, 'Data prasarana prodi berhasil dihapus');
    }
}
