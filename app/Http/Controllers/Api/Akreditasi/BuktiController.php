<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreBuktiRequest;
use App\Http\Requests\Akreditasi\UpdateStatusBuktiRequest;
use App\Models\Bukti;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class BuktiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Bukti::with(['lembarProdi', 'jenisBukti']);

        if ($request->has('id_lembar_prodi')) {
            $query->where('id_lembar_prodi', $request->query('id_lembar_prodi'));
        }

        if ($request->has('status_validasi')) {
            $query->where('status_validasi', $request->query('status_validasi'));
        }

        $data = $query->latest('tanggal_up')->get();

        return $this->successResponse($data, 'Daftar berkas bukti berhasil diambil');
    }

    /**
     * Upload berkas bukti ke storage Laravel dan simpan data record ke database.
     */
    public function store(StoreBuktiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $uploadedFile = $request->file('file');

        $originalName = $validated['nama_file'] ?? $uploadedFile->getClientOriginalName();
        $storedPath = $uploadedFile->store('bukti', 'public');

        $bukti = Bukti::create([
            'id_lembar_prodi' => $validated['id_lembar_prodi'],
            'id_jenis_bukti' => $validated['id_jenis_bukti'],
            'nama_file' => $originalName,
            'file_path' => $storedPath,
            'tanggal_up' => Carbon::now(),
            'masa_berlaku' => $validated['masa_berlaku'] ?? null,
            'status_validasi' => $validated['status_validasi'] ?? 'Pending',
        ]);

        $bukti->load(['lembarProdi', 'jenisBukti']);

        return $this->successResponse($bukti, 'Berkas bukti berhasil diunggah', 201);
    }

    public function show(int $id): JsonResponse
    {
        $bukti = Bukti::with(['lembarProdi', 'jenisBukti'])->find($id);

        if (! $bukti) {
            return $this->errorResponse('Berkas bukti tidak ditemukan', null, 404);
        }

        $buktiArray = $bukti->toArray();
        $buktiArray['file_url'] = Storage::disk('public')->url($bukti->file_path);

        return $this->successResponse($buktiArray, 'Detail berkas bukti berhasil diambil');
    }

    /**
     * Memperbarui status validasi berkas bukti ('Pending', 'Approved', 'Revision').
     */
    public function updateStatusValidasi(UpdateStatusBuktiRequest $request, int $id): JsonResponse
    {
        return $this->updateStatus($request, $id);
    }

    /**
     * Method updateStatus untuk memenuhi rute PUT /v1/bukti/{id}/status.
     */
    public function updateStatus(UpdateStatusBuktiRequest $request, int $id): JsonResponse
    {
        $bukti = Bukti::find($id);

        if (! $bukti) {
            return $this->errorResponse('Berkas bukti tidak ditemukan', null, 404);
        }

        $bukti->update([
            'status_validasi' => $request->validated()['status_validasi'],
        ]);

        return $this->successResponse($bukti, 'Status validasi bukti berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $bukti = Bukti::find($id);

        if (! $bukti) {
            return $this->errorResponse('Berkas bukti tidak ditemukan', null, 404);
        }

        if (Storage::disk('public')->exists($bukti->file_path)) {
            Storage::disk('public')->delete($bukti->file_path);
        }

        $bukti->delete();

        return $this->successResponse(null, 'Berkas bukti berhasil dihapus');
    }
}
