<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreVersiInstrumenRequest;
use App\Http\Requests\Master\UpdateVersiInstrumenRequest;
use App\Models\VersiInstrumen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VersiInstrumenController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = VersiInstrumen::with([
            'lembaga',
            'jenjangs',
            'kriteria.subkriteria',
        ]);

        if ($request->filled('id_lembaga')) {
            $query->where('id_lembaga', $request->query('id_lembaga'));
        }

        if ($request->filled('id_jenjang')) {
            $query->whereHas('jenjangs', function ($q) use ($request) {
                $q->where('jenjang.id', $request->query('id_jenjang'));
            });
        }

        if ($request->has('status_aktif')) {
            $statusAktif = filter_var(
                $request->query('status_aktif'),
                FILTER_VALIDATE_BOOLEAN
            );

            $query->whereHas('jenjangs', function ($q) use ($statusAktif) {
                $q->where(
                    'versi_instrumen_jenjang.status_aktif',
                    $statusAktif
                );
            });
        }

        $data = $query->latest()->get();

        return $this->successResponse(
            $data,
            'Data versi instrumen berhasil diambil'
        );
    }

    public function store(StoreVersiInstrumenRequest $request): JsonResponse
    {
        $versi = VersiInstrumen::create($request->validated());

        $versi->load([
            'lembaga',
            'jenjangs',
        ]);

        return $this->successResponse(
            $versi,
            'Versi instrumen berhasil ditambahkan',
            201
        );
    }

    public function show(int $id): JsonResponse
    {
        $versi = VersiInstrumen::with([
            'lembaga',
            'jenjangs',
            'kriteria.subkriteria',
        ])->find($id);

        if (! $versi) {
            return $this->errorResponse(
                'Versi instrumen tidak ditemukan',
                null,
                404
            );
        }

        return $this->successResponse(
            $versi,
            'Detail versi instrumen berhasil diambil'
        );
    }

    public function update(UpdateVersiInstrumenRequest $request, int $id): JsonResponse
    {
        $versi = VersiInstrumen::find($id);

        if (! $versi) {
            return $this->errorResponse('Versi instrumen tidak ditemukan', null, 404);
        }

        $versi->update($request->validated());
        $versi->load(['lembaga', 'jenjangs']);

        return $this->successResponse($versi, 'Versi instrumen berhasil diperbarui');
    }

    public function aktifkan(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'id_jenjang' => 'required|integer|exists:jenjang,id',
        ]);

        $versi = VersiInstrumen::find($id);

        if (! $versi) {
            return $this->errorResponse(
                'Versi instrumen tidak ditemukan',
                null,
                404
            );
        }

        $idJenjang = $validated['id_jenjang'];

        $relasiAda = DB::table('versi_instrumen_jenjang')
            ->where('id_versi_instrumen', $id)
            ->where('id_jenjang', $idJenjang)
            ->exists();

        if (! $relasiAda) {
            return $this->errorResponse(
                'Versi instrumen belum terhubung dengan jenjang tersebut.',
                null,
                422
            );
        }

        DB::transaction(function () use ($id, $idJenjang) {
            DB::table('versi_instrumen_jenjang')
                ->where('id_jenjang', $idJenjang)
                ->lockForUpdate()
                ->get();

            // Nonaktifkan versi lain untuk jenjang yang sama
            DB::table('versi_instrumen_jenjang')
                ->where('id_jenjang', $idJenjang)
                ->update([
                    'status_aktif' => false,
                    'updated_at' => now(),
                ]);

            // Aktifkan versi yang dipilih
            DB::table('versi_instrumen_jenjang')
                ->where('id_versi_instrumen', $id)
                ->where('id_jenjang', $idJenjang)
                ->update([
                    'status_aktif' => true,
                    'updated_at' => now(),
                ]);
        });

        $versi->load(['lembaga', 'jenjangs']);

        return $this->successResponse(
            $versi,
            'Versi instrumen berhasil diaktifkan untuk jenjang tersebut'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $versi = VersiInstrumen::find($id);

        if (! $versi) {
            return $this->errorResponse(
                'Versi instrumen tidak ditemukan',
                null,
                404
            );
        }

        if ($versi->projects()->exists()) {
            return $this->errorResponse(
                'Versi instrumen tidak dapat dihapus karena masih digunakan oleh project akreditasi.',
                [
                    'id' => [
                        'Versi instrumen masih digunakan oleh project akreditasi.',
                    ],
                ],
                422
            );
        }

        $versi->delete();

        return $this->successResponse(
            null,
            'Versi instrumen berhasil dihapus'
        );
    }
}
