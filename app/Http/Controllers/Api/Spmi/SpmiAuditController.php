<?php

namespace App\Http\Controllers\Api\Spmi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spmi\StoreDataSpmiAuditRequest;
use App\Http\Requests\Spmi\UpdateDataSpmiAuditRequest;
use App\Http\Requests\Spmi\UpdateTindakLanjutSpmiRequest;
use App\Models\DataSpmiAudit;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpmiAuditController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = DataSpmiAudit::with(['project', 'standarMutu', 'indikator']);

        if ($request->has('id_project')) {
            $query->where('id_project', $request->query('id_project'));
        }

        if ($request->has('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->query('jenis_kegiatan'));
        }

        if ($request->has('status_penyelesaian')) {
            $query->where('status_penyelesaian', $request->query('status_penyelesaian'));
        }

        $data = $query->latest('tanggal_pelaksanaan')->get();

        return $this->successResponse($data, 'Data temuan audit SPMI berhasil diambil');
    }

    public function store(StoreDataSpmiAuditRequest $request): JsonResponse
    {
        $audit = DataSpmiAudit::create($request->validated());
        $audit->load(['project', 'standarMutu', 'indikator']);

        return $this->successResponse($audit, 'Temuan audit SPMI berhasil ditambahkan', 201);
    }

    public function show(int $id): JsonResponse
    {
        $audit = DataSpmiAudit::with(['project', 'standarMutu', 'indikator'])->find($id);

        if (! $audit) {
            return $this->errorResponse('Data temuan audit SPMI tidak ditemukan', null, 404);
        }

        return $this->successResponse($audit, 'Detail temuan audit SPMI berhasil diambil');
    }

    public function update(UpdateDataSpmiAuditRequest $request, int $id): JsonResponse
    {
        $audit = DataSpmiAudit::find($id);

        if (! $audit) {
            return $this->errorResponse('Data temuan audit SPMI tidak ditemukan', null, 404);
        }

        $audit->update($request->validated());
        $audit->load(['project', 'standarMutu', 'indikator']);

        return $this->successResponse($audit, 'Data temuan audit SPMI berhasil diperbarui');
    }

    /**
     * Method khusus untuk memperbarui tindak lanjut temuan audit SPMI.
     */
    public function updateTindakLanjut(UpdateTindakLanjutSpmiRequest $request, int $id): JsonResponse
    {
        $audit = DataSpmiAudit::find($id);

        if (! $audit) {
            return $this->errorResponse('Data temuan audit SPMI tidak ditemukan', null, 404);
        }

        $validated = $request->validated();
        $audit->tindak_lanjut = $validated['tindak_lanjut'];

        if (isset($validated['status_penyelesaian'])) {
            $audit->status_penyelesaian = $validated['status_penyelesaian'];
        }

        $audit->save();
        $audit->load(['project', 'standarMutu', 'indikator']);

        return $this->successResponse(
            $audit,
            'Tindak lanjut audit SPMI berhasil diperbarui'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $audit = DataSpmiAudit::find($id);

        if (! $audit) {
            return $this->errorResponse('Data temuan audit SPMI tidak ditemukan', null, 404);
        }

        $audit->delete();

        return $this->successResponse(null, 'Data temuan audit SPMI berhasil dihapus');
    }
}
