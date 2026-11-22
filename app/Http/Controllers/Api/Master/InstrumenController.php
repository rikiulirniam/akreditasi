<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreInstrumenRequest;
use App\Models\Instrumen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumenController extends Controller
{
    use ApiResponseTrait;

    /**
     * Menampilkan daftar instrumen akreditasi dengan filter relasi.
     */
    public function index(Request $request): JsonResponse
    {
        $idJenjang = $request->filled('id_jenjang') ? (int) $request->query('id_jenjang') : null;
        $idVersi = $request->filled('id_versi_instrumen') ? (int) $request->query('id_versi_instrumen') : null;
        $idJenis = $request->filled('id_jenis_instrumen') ? (int) $request->query('id_jenis_instrumen') : null;

        $data = Instrumen::withRelations()
            ->filterByParams($idJenjang, $idVersi, $idJenis)
            ->latest()
            ->get();

        return $this->successResponse($data, 'Daftar instrumen berhasil diambil');
    }

    /**
     * Menyimpan instrumen akreditasi baru beserta mapping pivot versi-jenjang.
     */
    public function store(StoreInstrumenRequest $request): JsonResponse
    {
        $data = $request->validated();

        $instrumen = DB::transaction(function () use ($data): Instrumen {
            DB::table('versi_instrumen_jenjang')->insertOrIgnore([
                'id_versi_instrumen' => $data['id_versi_instrumen'],
                'id_jenjang' => $data['id_jenjang'],
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return Instrumen::create($data);
        });

        $instrumen->load([
            'versiInstrumen.lembaga',
            'jenjang',
            'jenisInstrumen',
        ])->loadCount('kriterias');

        return $this->successResponse(
            $instrumen,
            'Instrumen berhasil ditambahkan',
            201
        );
    }

    /**
     * Menampilkan detail spesifik instrumen akreditasi dan daftar kriterianya.
     */
    public function show(string $id): JsonResponse
    {
        $instrumen = Instrumen::withDetailedKriterias()->find($id);

        if (! $instrumen) {
            return $this->errorResponse('Data instrumen tidak ditemukan', null, 404);
        }

        return $this->successResponse($instrumen, 'Detail instrumen berhasil diambil');
    }

    /**
     * Endpoint ringkas menyajikan hierarki instrumen aktif LAM-INFOKOM 2.1 TRK secara statis.
     */
    public function getActiveStatic(): JsonResponse
    {
        $instrumen = Instrumen::findActiveStatic();

        if (! $instrumen) {
            return $this->errorResponse(
                'Data instrumen aktif LAM-INFOKOM 2.1 TRK tidak ditemukan',
                null,
                404
            );
        }

        return $this->successResponse(
            $instrumen->toHierarchyArray(),
            'Struktur instrumen aktif LAM-INFOKOM 2.1 TRK berhasil diambil'
        );
    }

    /**
     * Menampilkan struktur hierarki mendalam instrumen akreditasi berdasarkan ID (UUID).
     */
    public function getHierarchy(string $id): JsonResponse
    {
        $instrumen = Instrumen::completeHierarchy()->find($id);

        if (! $instrumen) {
            return $this->errorResponse(
                'Data instrumen tidak ditemukan',
                null,
                404
            );
        }

        return $this->successResponse(
            $instrumen->toHierarchyArray(),
            'Hierarchy instrumen berhasil diambil'
        );
    }

    /**
     * Menghapus instrumen akreditasi.
     */
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
