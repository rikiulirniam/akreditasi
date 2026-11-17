<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreMappingTimRequest;
use App\Models\MappingTimAkreditasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * MappingTimAkreditasiController
 *
 * Mengelola penugasan anggota tim pada indikator akreditasi.
 * Setiap indikator bisa memiliki dua peran:
 *   - PJ  (Penanggung Jawab) : bertanggung jawab atas substansi/isi indikator
 *   - PIC (Pelaksana Teknis) : bertanggung jawab mengunggah berkas bukti dukung
 */
class MappingTimAkreditasiController extends Controller
{
    /**
     * Ambil semua penugasan tim, bisa difilter by project atau role.
     *
     * GET /api/v1/mapping-tim?id_project=1&role=PJ
     */
    public function index(Request $request): JsonResponse
    {
        $query = MappingTimAkreditasi::with([
            'project:id,nama_project',   // hanya ambil kolom yang diperlukan
            'indikator:id,nama_indikator,kode_indikator',
        ]);

        // Filter by project
        if ($request->filled('id_project')) {
            $query->where('id_project', $request->input('id_project'));
        } elseif ($request->filled('project_id')) {
            $query->where('id_project', $request->input('project_id'));
        }

        // Filter by role (PJ / PIC)
        if ($request->filled('role')) {
            $query->where('role', strtoupper($request->input('role')));
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Data mapping tim akreditasi berhasil diambil.',
            'data' => $data,
        ], 200);
    }

    /**
     * Simpan penugasan — mendukung mode single maupun batch.
     *
     * Mode single  : { id_project, id_user, id_indikator, role }
     * Mode batch   : { id_project, assignments: [{ id_user, id_indikator, role }] }
     *
     * POST /api/v1/mapping-tim
     */
    public function store(StoreMappingTimRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // ── MODE BATCH ──────────────────────────────────────────────────────
        if ($request->has('assignments')) {
            $created = [];
            foreach ($validated['assignments'] as $item) {
                $role = strtoupper($item['role']); // sudah divalidasi in:PJ,PIC
                $created[] = MappingTimAkreditasi::updateOrCreate(
                    // Kunci unik: 1 indikator hanya punya 1 PJ dan 1 PIC per project
                    [
                        'id_project' => $validated['id_project'],
                        'id_indikator' => $item['id_indikator'],
                        'role' => $role,
                    ],
                    // Nilai yang di-upsert
                    ['id_user' => $item['id_user']]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Batch assignments berhasil disimpan.',
                'data' => $created,
            ], 201);
        }

        // ── MODE SINGLE ─────────────────────────────────────────────────────
        $role = strtoupper($validated['role']); // sudah divalidasi in:PJ,PIC
        $data = MappingTimAkreditasi::updateOrCreate(
            [
                'id_project' => $validated['id_project'],
                'id_indikator' => $validated['id_indikator'],
                'role' => $role,
            ],
            ['id_user' => $validated['id_user']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Penugasan berhasil disimpan.',
            'data' => $data,
        ], 201);
    }

    /**
     * Hapus satu penugasan berdasarkan ID baris mapping.
     *
     * DELETE /api/v1/mapping-tim/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $mapping = MappingTimAkreditasi::findOrFail($id);
        $mapping->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penugasan berhasil dihapus.',
            'data' => null,
        ], 200);
    }

    /**
     * Ambil semua indikator yang ditugaskan ke dosen yang sedang login (PJ atau PIC),
     * beserta status kelengkapan bukti dukungnya.
     *
     * GET /api/v1/dosen/my-assignments
     *
     * Response per item:
     *   - id_mapping       : ID baris mapping
     *   - role             : PJ / PIC
     *   - id_indikator     : ID indikator
     *   - kode_indikator   : kode butir (misal: A.1.1)
     *   - deskripsi        : deskripsi indikator
     *   - bobot            : bobot penilaian
     *   - id_project       : ID project akreditasi
     *   - nama_project     : nama project
     *   - has_bukti        : true jika reviewer sudah mengisi self assessment (rubrik dipilih)
     */
    public function getMyAssignments(Request $request): JsonResponse
    {
        $user = $request->user();
        $userId = $user->id;

        // Ambil semua penugasan milik dosen ini,
        // load relasi indikator (kode, deskripsi, bobot) dan project (nama)
        $assignments = MappingTimAkreditasi::with([
            'indikator:id,id_subkriteria,kode_indikator,deskripsi_indikator,bobot',
            'project:id,nama_project,status_project',
        ])
            ->where('id_user', $userId)
            ->whereIn('role', ['PJ', 'PIC'])
            ->get()
            ->map(function ($mapping) {
                // Cek apakah indikator ini sudah dinilai reviewer (self_assessment terisi)
                // "has_bukti" = sudah ada self assessment dengan rubrik dipilih
                $hasBukti = DB::table('self_assessment')
                    ->where('id_project', $mapping->id_project)
                    ->where('id_indikator', $mapping->id_indikator)
                    ->whereNotNull('id_rubrik')
                    ->exists();

                return [
                    'id_mapping' => $mapping->id,
                    'role' => $mapping->role,
                    'id_project' => $mapping->id_project,
                    'nama_project' => $mapping->project?->nama_project,
                    'status_project' => $mapping->project?->status_project,
                    'id_indikator' => $mapping->id_indikator,
                    'kode_indikator' => $mapping->indikator?->kode_indikator,
                    'deskripsi' => $mapping->indikator?->deskripsi_indikator,
                    'bobot' => $mapping->indikator?->bobot,
                    'has_bukti' => $hasBukti,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar penugasan dosen berhasil diambil.',
            'data' => $assignments,
            'meta' => [
                'total' => $assignments->count(),
                'id_user' => $userId,
            ],
        ], 200);
    }
}
