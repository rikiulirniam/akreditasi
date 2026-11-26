<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreMappingTimRequest;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
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
     * Ambil semua penugasan tim, bisa difilter by project, role, atau user/dosen.
     * Menggunakan local scopes Model untuk Clean Code MVC.
     *
     * GET /api/v1/mapping-tim?id_project=1&role=PJ
     */
    public function index(Request $request): JsonResponse
    {
        $query = MappingTimAkreditasi::withDetails();

        // Filter by project (menggunakan scopeForProject)
        if ($request->filled('id_project')) {
            $query->forProject((int) $request->input('id_project'));
        } elseif ($request->filled('project_id')) {
            $query->forProject((int) $request->input('project_id'));
        }

        // Filter by role (menggunakan scopeForRole)
        if ($request->filled('role')) {
            $query->forRole((string) $request->input('role'));
        }

        // Filter by user / dosen (menggunakan scopeForDosen)
        if ($request->filled('id_user')) {
            $query->forDosen((int) $request->input('id_user'));
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
     * Menggunakan local scopes Model dan optimasi single query untuk self_assessment (mencegah N+1).
     *
     * GET /api/v1/dosen/my-assignments
     */
    public function getMyAssignments(Request $request): JsonResponse
    {
        $user = $request->user();
        $userId = (int) ($user->id ?? $user->getAuthIdentifier());

        // Gunakan scope Model: withDetails, forDosen, assignedRoles, dan excludeNonHandleCriteria
        $mappings = MappingTimAkreditasi::withDetails()
            ->forDosen($userId)
            ->assignedRoles()
            ->excludeNonHandleCriteria()
            ->get();

        // Optimasi: Tarik seluruh self_assessment, evidence indikator, dan narasi subkriteria dalam 3 batch query (Bebas N+1)
        $projectIds = $mappings->pluck('id_project')->unique()->filter()->values()->all();
        $indikatorIds = $mappings->pluck('id_indikator')->unique()->filter()->values()->all();
        $subkriteriaIds = $mappings->pluck('indikator.id_subkriteria')->unique()->filter()->values()->all();

        $assessedMap = [];
        $evidenceMap = [];
        $narasiMap = [];

        if (! empty($projectIds) && ! empty($indikatorIds)) {
            $assessedMap = DB::table('self_assessment')
                ->whereIn('id_project', $projectIds)
                ->whereIn('id_indikator', $indikatorIds)
                ->whereNotNull('id_rubrik')
                ->select('id_project', 'id_indikator')
                ->get()
                ->mapWithKeys(fn ($row) => ["{$row->id_project}_{$row->id_indikator}" => true])
                ->all();

            $evidenceMap = DB::table('project_indicator_evidence')
                ->whereIn('id_project', $projectIds)
                ->whereIn('id_indikator', $indikatorIds)
                ->select('id_project', 'id_indikator')
                ->get()
                ->mapWithKeys(fn ($row) => ["{$row->id_project}_{$row->id_indikator}" => true])
                ->all();
        }

        if (! empty($projectIds) && ! empty($subkriteriaIds)) {
            $narasiMap = DB::table('narasi_subkriterias')
                ->whereIn('id_project', $projectIds)
                ->whereIn('id_subkriteria', $subkriteriaIds)
                ->whereNotNull('narasi')
                ->where('narasi', '!=', '')
                ->select('id_project', 'id_subkriteria')
                ->get()
                ->mapWithKeys(fn ($row) => ["{$row->id_project}_{$row->id_subkriteria}" => true])
                ->all();
        }

        $assignments = $mappings->map(function ($mapping) use ($assessedMap, $evidenceMap, $narasiMap) {
            $key = "{$mapping->id_project}_{$mapping->id_indikator}";
            $subKey = "{$mapping->id_project}_{$mapping->indikator?->id_subkriteria}";
            $hasBukti = isset($assessedMap[$key]);
            $hasEvidence = $hasBukti || isset($evidenceMap[$key]);
            $hasNarasi = isset($narasiMap[$subKey]);

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
                'kriteria' => $mapping->indikator?->subkriteria?->kriteria?->nama_kriteria,
                'has_bukti' => $hasBukti,
                'status_narasi' => $hasNarasi ? 'Terisi' : 'Belum Terisi',
                'status_evidence' => $hasEvidence ? 'Terunggah' : 'Belum Terunggah',
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar penugasan dosen berhasil diambil.',
            'data' => $assignments,
            'meta' => [
                'total' => $assignments->count(),
                'id_user' => (string) $userId,
            ],
        ], 200);
    }

    /**
     * Mengembalikan metadata kriteria/modul read-only (placeholder) yang tidak ditangani mitra
     * (Tata Pamong, Keuangan & Sarpras) agar struktur 9 kriteria LAM-INFOKOM tetap lengkap di UI.
     *
     * GET /api/v1/projects/{id}/placeholder-modules
     */
    public function getPlaceholderModules(int $id): JsonResponse
    {
        $project = ProjectAkreditasi::find($id);

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project akreditasi tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $placeholders = [
            [
                'kode_kriteria' => 'C.2',
                'nama_kriteria' => 'Tata Pamong, Tata Kelola, dan Kerjasama',
                'is_placeholder' => true,
                'mode' => 'read_only',
                'status' => 'Aktif (Placeholder LAM-INFOKOM)',
                'keterangan' => 'Modul Tata Pamong, Tata Kelola, dan Kerjasama disajikan sebagai komponen display data statis/read-only untuk kelengkapan 9 kriteria LAM-INFOKOM.',
            ],
            [
                'kode_kriteria' => 'C.5',
                'nama_kriteria' => 'Keuangan, Sarana, dan Prasarana',
                'total_bobot' => 40,
                'is_placeholder' => true,
                'mode' => 'read_only',
                'status' => 'Aktif (Placeholder LAM-INFOKOM)',
                'catatan_sistem' => 'Komponen Read-Only LAM-INFOKOM (Data dikelola oleh SPMI Pusat Polines)',
                'keterangan' => 'Modul Keuangan, Sarana, dan Prasarana disajikan sebagai komponen display data statis/read-only tanpa transaksi form input borang.',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => '5.1',
                        'nama_subkriteria' => 'Standar Tata Kelola Otonom & Transparan',
                        'is_editable' => false,
                        'status' => 'Statis / Read-Only',
                    ],
                    [
                        'kode_subkriteria' => '5.2',
                        'nama_subkriteria' => 'Sarana, Prasarana, dan Keuangan',
                        'is_editable' => false,
                        'status' => 'Statis / Read-Only',
                    ],
                ],
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data modul placeholder berhasil diambil.',
            'data' => $placeholders,
            'meta' => [
                'id_project' => $id,
                'nama_project' => $project->nama_project,
                'total' => count($placeholders),
            ],
        ], 200);
    }
}
