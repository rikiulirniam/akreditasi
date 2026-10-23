<?php

namespace App\Http\Controllers\Api\Sarpras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sarpras\StoreDataSaranaProdiRequest;
use App\Http\Requests\Sarpras\UpdateDataSaranaProdiRequest;
use App\Models\DataSaranaProdi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataSaranaProdiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = DataSaranaProdi::with('prasarana');

        if ($request->has('id_prasarana')) {
            $query->where('id_prasarana', $request->query('id_prasarana'));
        }

        $data = $query->latest()->get();

        return $this->successResponse($data, 'Daftar data sarana prodi berhasil diambil');
    }

    public function store(StoreDataSaranaProdiRequest $request): JsonResponse
    {
        $sarana = DataSaranaProdi::create($request->validated());
        $sarana->load('prasarana');

        return $this->successResponse($sarana, 'Data sarana prodi berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $sarana = DataSaranaProdi::with('prasarana')->find($id);

        if (! $sarana) {
            return $this->errorResponse('Data sarana prodi tidak ditemukan', null, 404);
        }

        return $this->successResponse($sarana, 'Detail data sarana prodi berhasil diambil');
    }

    public function update(UpdateDataSaranaProdiRequest $request, int $id): JsonResponse
    {
        $sarana = DataSaranaProdi::find($id);

        if (! $sarana) {
            return $this->errorResponse('Data sarana prodi tidak ditemukan', null, 404);
        }

        $sarana->update($request->validated());
        $sarana->load('prasarana');

        return $this->successResponse($sarana, 'Data sarana prodi berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $sarana = DataSaranaProdi::find($id);

        if (! $sarana) {
            return $this->errorResponse('Data sarana prodi tidak ditemukan', null, 404);
        }

        $sarana->delete();

        return $this->successResponse(null, 'Data sarana prodi berhasil dihapus');
    }
}
