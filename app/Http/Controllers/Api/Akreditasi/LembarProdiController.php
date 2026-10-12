<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreLembarProdiRequest;
use App\Models\LembarProdi;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LembarProdiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = LembarProdi::with(['project', 'indikator', 'buktis']);

        if ($request->has('id_project')) {
            $query->where('id_project', $request->query('id_project'));
        }

        if ($request->has('id_indikator')) {
            $query->where('id_indikator', $request->query('id_indikator'));
        }

        $data = $query->latest()->get();

        return $this->successResponse($data, 'Data lembar prodi berhasil diambil');
    }

    /**
     * Menyimpan atau memperbarui penjelasan_prodi per id_project & id_indikator.
     */
    public function storeOrUpdate(StoreLembarProdiRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $lembarProdi = LembarProdi::updateOrCreate(
            [
                'id_project' => $validated['id_project'],
                'id_indikator' => $validated['id_indikator'],
            ],
            [
                'penjelasan_prodi' => $validated['penjelasan_prodi'] ?? null,
            ]
        );

        $lembarProdi->load(['project', 'indikator', 'buktis']);

        return $this->successResponse(
            $lembarProdi,
            'Penjelasan lembar prodi berhasil disimpan/diperbarui',
            200
        );
    }

    public function show(int $id): JsonResponse
    {
        $lembarProdi = LembarProdi::with(['project', 'indikator', 'buktis.jenisBukti'])->find($id);

        if (! $lembarProdi) {
            return $this->errorResponse('Lembar prodi tidak ditemukan', null, 404);
        }

        return $this->successResponse($lembarProdi, 'Detail lembar prodi berhasil diambil');
    }

    public function destroy(int $id): JsonResponse
    {
        $lembarProdi = LembarProdi::find($id);

        if (! $lembarProdi) {
            return $this->errorResponse('Lembar prodi tidak ditemukan', null, 404);
        }

        $lembarProdi->delete();

        return $this->successResponse(null, 'Lembar prodi berhasil dihapus');
    }
}
