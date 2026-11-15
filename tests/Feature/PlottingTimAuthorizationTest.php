<?php

namespace Tests\Feature;

use App\Auth\JwtUser;
use App\Models\Indikator;
use App\Models\MappingTimAkreditasi;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * PlottingTimAuthorizationTest
 *
 * Menguji endpoint penugasan tim (Mapping Tim Akreditasi):
 *   - POST /api/v1/projects/{id}/mapping-tim  → batch assign PJ & PIC
 *   - GET  /api/v1/mapping-tim                → ambil daftar penugasan
 *   - DELETE /api/v1/mapping-tim/{id}         → hapus penugasan
 *
 * Skenario yang diuji:
 *   1. Kaprodi/Admin bisa simpan batch assignment dengan role PJ & PIC
 *   2. Validasi menolak role selain PJ/PIC
 *   3. Validasi menolak assignments tanpa field role
 *   4. Mode single assignment juga valid
 *   5. Dosen hanya bisa GET (tidak bisa POST/DELETE)
 *   6. Tanpa token ditolak 401
 */
class PlottingTimAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    // ID dummy (tidak ada FK constraint ke tabel user external)
    protected int $dummyUserId = 99;

    protected int $dummyDosenId = 88;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwtService = app(JwtService::class);
    }

    // ─── Helper: generate JWT token per role ────────────────────────────────

    protected function tokenFor(string $role, int $userId = 1): string
    {
        return $this->jwtService->generateToken([
            'sub' => (string) $userId,
            'nama' => 'User '.ucfirst($role),
            'email' => strtolower($role).'@polines.ac.id',
            'role' => strtoupper($role),
            'permissions' => [],
        ]);
    }

    // ─── Helper: seed minimal data master ───────────────────────────────────

    protected function seedMasterData(): array
    {
        // Lembaga (hanya kolom yang ada: nama_lembaga, keterangan)
        $lembaga = \DB::table('lembaga_akreditasi')->insertGetId([
            'nama_lembaga' => 'LAM-INFOKOM',
            'keterangan' => 'Lembaga Akreditasi Mandiri Informatika dan Komputer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Versi Instrumen (kolom: id_lembaga, nomor_versi, tanggal_berlaku, status_aktif)
        $versi = \DB::table('versi_instrumen')->insertGetId([
            'id_lembaga' => $lembaga,
            'nomor_versi' => '2.1',
            'tanggal_berlaku' => '2024-01-01',
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Jenjang (kolom: nama_jenjang)
        $jenjang = \DB::table('jenjang')->insertGetId([
            'nama_jenjang' => 'Sarjana Terapan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Jenis Instrumen (kolom: nama_jenis)
        $jenis = \DB::table('jenis_instrumen')->insertGetId([
            'nama_jenis' => 'Unggul',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Instrumen (UUID PK, FK ke versi, jenjang, jenis)
        $instrumenId = Str::uuid()->toString();
        \DB::table('instrumen')->insert([
            'id' => $instrumenId,
            'id_versi_instrumen' => $versi,
            'id_jenjang' => $jenjang,
            'id_jenis_instrumen' => $jenis,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kriteria (FK id_instrumen UUID, kode_kriteria, nama_kriteria)
        $kriteria = \DB::table('kriteria')->insertGetId([
            'id_instrumen' => $instrumenId,
            'kode_kriteria' => 'A',
            'nama_kriteria' => 'Kriteria A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Subkriteria (FK id_kriteria, kode_subkriteria, nama_subkriteria)
        $subkriteria = \DB::table('subkriteria')->insertGetId([
            'id_kriteria' => $kriteria,
            'kode_subkriteria' => 'A.1',
            'nama_subkriteria' => 'Subkriteria A.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Indikator (FK id_subkriteria, kode_indikator, deskripsi_indikator, bobot)
        $indikator1 = \DB::table('indikator')->insertGetId([
            'id_subkriteria' => $subkriteria,
            'kode_indikator' => 'A.1.1',
            'deskripsi_indikator' => 'Indikator pertama untuk pengujian',
            'bobot' => 5.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $indikator2 = \DB::table('indikator')->insertGetId([
            'id_subkriteria' => $subkriteria,
            'kode_indikator' => 'A.1.2',
            'deskripsi_indikator' => 'Indikator kedua untuk pengujian',
            'bobot' => 3.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Project Akreditasi
        $project = \DB::table('project_akreditasi')->insertGetId([
            'id_prodi' => 1,
            'id_versi_instrumen' => $versi,
            'id_jenjang' => $jenjang,
            'id_jenis_instrumen' => $jenis,
            'nama_project' => 'Akreditasi TRK 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'Draft',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return compact('project', 'indikator1', 'indikator2');
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 1: Batch assignment oleh Kaprodi → berhasil
    // ════════════════════════════════════════════════════════════════════════

    public function test_kaprodi_dapat_simpan_batch_assignment_pj_dan_pic(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('kaprodi', $this->dummyUserId);

        $payload = [
            'assignments' => [
                // Indikator 1: assign PJ ke user 10
                ['id_user' => 10, 'id_indikator' => $data['indikator1'], 'role' => 'PJ'],
                // Indikator 1: assign PIC ke user 20
                ['id_user' => 20, 'id_indikator' => $data['indikator1'], 'role' => 'PIC'],
                // Indikator 2: assign PJ ke user 10
                ['id_user' => 10, 'id_indikator' => $data['indikator2'], 'role' => 'PJ'],
            ],
        ];

        $response = $this->withToken($token)
            ->postJson("/api/v1/projects/{$data['project']}/mapping-tim", $payload);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data');

        // Pastikan tersimpan di database
        $this->assertDatabaseHas('mapping_tim_akreditasi', [
            'id_project' => $data['project'],
            'id_indikator' => $data['indikator1'],
            'id_user' => 10,
            'role' => 'PJ',
        ]);
        $this->assertDatabaseHas('mapping_tim_akreditasi', [
            'id_project' => $data['project'],
            'id_indikator' => $data['indikator1'],
            'id_user' => 20,
            'role' => 'PIC',
        ]);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 2: Role tidak valid (bukan PJ/PIC) → ditolak 422
    // ════════════════════════════════════════════════════════════════════════

    public function test_role_tidak_valid_ditolak_422(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('kaprodi');

        $payload = [
            'assignments' => [
                ['id_user' => 10, 'id_indikator' => $data['indikator1'], 'role' => 'ADMIN'], // salah
            ],
        ];

        $response = $this->withToken($token)
            ->postJson("/api/v1/projects/{$data['project']}/mapping-tim", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['assignments.0.role']);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 3: Assignment tanpa field role → ditolak 422
    // ════════════════════════════════════════════════════════════════════════

    public function test_assignment_tanpa_role_ditolak_422(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('administrator');

        $payload = [
            'assignments' => [
                ['id_user' => 10, 'id_indikator' => $data['indikator1']], // tidak ada role
            ],
        ];

        $response = $this->withToken($token)
            ->postJson("/api/v1/projects/{$data['project']}/mapping-tim", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['assignments.0.role']);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 4: Mode single assignment → berhasil
    // ════════════════════════════════════════════════════════════════════════

    public function test_single_assignment_berhasil(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('administrator');

        $payload = [
            'id_user' => 15,
            'id_indikator' => $data['indikator2'],
            'role' => 'PIC',
        ];

        $response = $this->withToken($token)
            ->postJson("/api/v1/projects/{$data['project']}/mapping-tim", $payload);

        $response->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('mapping_tim_akreditasi', [
            'id_project' => $data['project'],
            'id_indikator' => $data['indikator2'],
            'id_user' => 15,
            'role' => 'PIC',
        ]);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 5: Dosen tidak bisa POST mapping (403)
    // ════════════════════════════════════════════════════════════════════════

    public function test_dosen_tidak_bisa_post_mapping_tim(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('dosen', $this->dummyDosenId);

        $payload = [
            'assignments' => [
                ['id_user' => $this->dummyDosenId, 'id_indikator' => $data['indikator1'], 'role' => 'PIC'],
            ],
        ];

        $response = $this->withToken($token)
            ->postJson("/api/v1/projects/{$data['project']}/mapping-tim", $payload);

        // Role 'dosen' tidak ada di middleware role:administrator,kaprodi
        $response->assertStatus(403);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 6: Tanpa token → 401
    // ════════════════════════════════════════════════════════════════════════

    public function test_tanpa_token_ditolak_401(): void
    {
        $response = $this->postJson('/api/v1/mapping-tim', []);
        $response->assertStatus(401);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 7: GET mapping-tim bisa diakses dosen (read-only)
    // ════════════════════════════════════════════════════════════════════════

    public function test_dosen_bisa_get_mapping_tim(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('dosen', $this->dummyDosenId);

        // Seed satu record dulu
        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => $this->dummyDosenId,
            'id_indikator' => $data['indikator1'],
            'role' => 'PIC',
        ]);

        $response = $this->withToken($token)
            ->getJson("/api/v1/mapping-tim?id_project={$data['project']}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data');
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 8: Upsert — assign ulang PJ yang sama mengupdate, tidak duplikat
    // ════════════════════════════════════════════════════════════════════════

    public function test_upsert_tidak_duplikat_role_yang_sama(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('kaprodi');

        // Assign pertama: PJ = user 10
        $this->withToken($token)->postJson("/api/v1/projects/{$data['project']}/mapping-tim", [
            'assignments' => [
                ['id_user' => 10, 'id_indikator' => $data['indikator1'], 'role' => 'PJ'],
            ],
        ]);

        // Assign ulang: PJ = user 11 (ganti PJ)
        $this->withToken($token)->postJson("/api/v1/projects/{$data['project']}/mapping-tim", [
            'assignments' => [
                ['id_user' => 11, 'id_indikator' => $data['indikator1'], 'role' => 'PJ'],
            ],
        ]);

        // Harus hanya ada 1 record PJ untuk indikator ini (bukan 2)
        $this->assertDatabaseCount('mapping_tim_akreditasi', 1);
        $this->assertDatabaseHas('mapping_tim_akreditasi', [
            'id_indikator' => $data['indikator1'],
            'role' => 'PJ',
            'id_user' => 11, // user terbaru
        ]);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 9: GET /dosen/my-assignments → dosen dapat daftar butirnya sendiri
    // ════════════════════════════════════════════════════════════════════════

    public function test_dosen_dapat_my_assignments_miliknya_saja(): void
    {
        $data = $this->seedMasterData();
        $dosenId = $this->dummyDosenId; // 88
        $token = $this->tokenFor('dosen', $dosenId);

        // Assign 2 indikator ke dosen ini
        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => $dosenId,
            'id_indikator' => $data['indikator1'],
            'role' => 'PJ',
        ]);
        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => $dosenId,
            'id_indikator' => $data['indikator2'],
            'role' => 'PIC',
        ]);

        // Assign indikator ke dosen LAIN (tidak boleh muncul di response)
        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => 999, // dosen lain
            'id_indikator' => $data['indikator1'],
            'role' => 'PIC',
        ]);

        $response = $this->withToken($token)->getJson('/api/v1/dosen/my-assignments');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            // Hanya 2 yang milik dosenId=88, bukan 3
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.id_user', (string) $dosenId);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 10: GET /dosen/my-assignments → response punya field yang benar
    // ════════════════════════════════════════════════════════════════════════

    public function test_my_assignments_response_memiliki_field_lengkap(): void
    {
        $data = $this->seedMasterData();
        $dosenId = $this->dummyDosenId;
        $token = $this->tokenFor('dosen', $dosenId);

        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => $dosenId,
            'id_indikator' => $data['indikator1'],
            'role' => 'PJ',
        ]);

        $response = $this->withToken($token)->getJson('/api/v1/dosen/my-assignments');

        $response->assertStatus(200);

        // Pastikan tiap item memiliki field-field yang dibutuhkan frontend
        $item = $response->json('data.0');
        $this->assertArrayHasKey('id_mapping', $item);
        $this->assertArrayHasKey('role', $item);
        $this->assertArrayHasKey('id_project', $item);
        $this->assertArrayHasKey('nama_project', $item);
        $this->assertArrayHasKey('id_indikator', $item);
        $this->assertArrayHasKey('kode_indikator', $item);
        $this->assertArrayHasKey('deskripsi', $item);
        $this->assertArrayHasKey('bobot', $item);
        $this->assertArrayHasKey('has_bukti', $item);
        $this->assertEquals('PJ', $item['role']);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 11: Reviewer tidak boleh akses /dosen/my-assignments (403)
    // ════════════════════════════════════════════════════════════════════════

    public function test_reviewer_tidak_bisa_akses_my_assignments(): void
    {
        $token = $this->tokenFor('reviewer');

        $response = $this->withToken($token)->getJson('/api/v1/dosen/my-assignments');

        $response->assertStatus(403);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 12: IndikatorAssignmentPolicy — Kaprodi bebas akses semua indikator
    // ════════════════════════════════════════════════════════════════════════

    public function test_policy_kaprodi_boleh_akses_semua_indikator(): void
    {
        $data = $this->seedMasterData();
        $token = $this->tokenFor('kaprodi');

        // Kaprodi tidak perlu terdaftar di mapping_tim — langsung boleh akses my-assignments
        $response = $this->withToken($token)->getJson('/api/v1/dosen/my-assignments');

        // Harus berhasil (200), bukan 403
        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 13: Policy — dosen tanpa assignment di indikator = has_bukti false
    // ════════════════════════════════════════════════════════════════════════

    public function test_my_assignments_has_bukti_false_jika_belum_ada_bukti(): void
    {
        $data = $this->seedMasterData();
        $dosenId = $this->dummyDosenId;
        $token = $this->tokenFor('dosen', $dosenId);

        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => $dosenId,
            'id_indikator' => $data['indikator1'],
            'role' => 'PIC',
        ]);

        $response = $this->withToken($token)->getJson('/api/v1/dosen/my-assignments');

        $response->assertStatus(200);
        // Belum ada self_assessment dengan rubrik → has_bukti harus false
        $this->assertFalse($response->json('data.0.has_bukti'));
    }

    // ════════════════════════════════════════════════════════════════════════
    // TEST 14: IndikatorAssignmentPolicy — Gate izin upload-evidence & edit-data
    // ════════════════════════════════════════════════════════════════════════

    public function test_indikator_assignment_policy_izin_upload_evidence_dan_edit_data(): void
    {
        $data = $this->seedMasterData();
        $indikator = Indikator::findOrFail($data['indikator1']);

        $adminUser = new JwtUser(['id' => 1, 'role' => 'ADMINISTRATOR']);
        $kaprodiUser = new JwtUser(['id' => 2, 'role' => 'KAPRODI']);
        $dosenPic = new JwtUser(['id' => 88, 'role' => 'DOSEN']);
        $dosenLain = new JwtUser(['id' => 99, 'role' => 'DOSEN']);

        // Assign indikator1 ke dosenPic (88)
        MappingTimAkreditasi::create([
            'id_project' => $data['project'],
            'id_user' => 88,
            'id_indikator' => $data['indikator1'],
            'role' => 'PIC',
        ]);

        // 1. Administrator: diizinkan upload dan edit
        $this->assertTrue(Gate::forUser($adminUser)->allows('uploadEvidence', $indikator));
        $this->assertTrue(Gate::forUser($adminUser)->allows('editData', $indikator));

        // 2. Kaprodi: diizinkan upload dan edit
        $this->assertTrue(Gate::forUser($kaprodiUser)->allows('uploadEvidence', $indikator));
        $this->assertTrue(Gate::forUser($kaprodiUser)->allows('editData', $indikator));

        // 3. Dosen PIC: diizinkan upload dan edit karena terdaftar di mapping_tim
        $this->assertTrue(Gate::forUser($dosenPic)->allows('uploadEvidence', $indikator));
        $this->assertTrue(Gate::forUser($dosenPic)->allows('editData', $indikator));

        // 4. Dosen Lain: DITOLAK karena tidak terdaftar sebagai PIC/PJ indikator ini
        $this->assertFalse(Gate::forUser($dosenLain)->allows('uploadEvidence', $indikator));
        $this->assertFalse(Gate::forUser($dosenLain)->allows('editData', $indikator));
    }
}
