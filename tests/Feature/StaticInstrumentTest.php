<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\Rubrik;
use App\Models\SelfAssessment;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StaticInstrumentTest extends TestCase
{
    use RefreshDatabase;

    protected string $adminToken;

    protected string $kaprodiToken;

    protected function setUp(): void
    {
        parent::setUp();

        $jwtService = app(JwtService::class);

        $this->adminToken = $jwtService->generateToken([
            'sub' => '1',
            'nama' => 'Admin Akreditasi',
            'email' => 'admin@polines.ac.id',
            'role' => 'ADMINISTRATOR',
            'permissions' => ['*'],
        ]);

        $this->kaprodiToken = $jwtService->generateToken([
            'sub' => '2',
            'nama' => 'Kaprodi TRK',
            'email' => 'kaprodi.trk@polines.ac.id',
            'role' => 'KAPRODI',
            'permissions' => ['akreditasi:read', 'akreditasi:write'],
        ]);
    }

    /**
     * Helper untuk membuat struktur instrumen LAM-INFOKOM 2.1 TRK (Sarjana Terapan).
     */
    protected function createLamInfokomTrkInstrument(): array
    {
        $lembaga = LembagaAkreditasi::create([
            'nama_lembaga' => 'LAM-INFOKOM',
            'keterangan' => 'Lembaga Akreditasi Mandiri Informatika dan Komputer',
        ]);

        $versi = VersiInstrumen::create([
            'nomor_versi' => '2.1',
            'id_lembaga' => $lembaga->id,
            'tanggal_berlaku' => '2026-01-25',
        ]);

        $jenjang = Jenjang::create([
            'nama_jenjang' => 'Sarjana Terapan',
            'kode_jenjang' => 'D4',
        ]);

        $jenis = JenisInstrumen::create([
            'nama_jenis' => 'Instrumen APS untuk Status Terakreditasi Unggul',
        ]);

        DB::table('versi_instrumen_jenjang')->insert([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'C.1',
            'nama_kriteria' => 'Budaya Mutu',
        ]);

        $subkriteria = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'C.1.1',
            'nama_subkriteria' => 'Pelaksanaan Siklus PPEPP',
        ]);

        $indikator = Indikator::create([
            'id_subkriteria' => $subkriteria->id,
            'kode_indikator' => 'IND-C.1.1.1',
            'deskripsi_indikator' => 'Konsistensi pelaksanaan siklus PPEPP',
            'bobot' => 4.00,
        ]);

        $rubrik = Rubrik::create([
            'id_indikator' => $indikator->id,
            'skor' => 4,
            'deskripsi_rubrik' => 'Sangat Baik: Siklus PPEPP terlaksana konsisten',
        ]);

        return compact('lembaga', 'versi', 'jenjang', 'jenis', 'instrumen', 'kriteria', 'subkriteria', 'indikator', 'rubrik');
    }

    /**
     * 1. Test endpoint GET /api/v1/master/instrumen/active-static mengembalikan struktur lengkap LAM-INFOKOM 2.1 TRK.
     */
    public function test_get_active_static_instrument_returns_complete_hierarchy_for_lam_infokom_2_1_trk(): void
    {
        $setup = $this->createLamInfokomTrkInstrument();

        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/master/instrumen/active-static');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Struktur instrumen aktif LAM-INFOKOM 2.1 TRK berhasil diambil')
            ->assertJsonPath('data.id_instrumen', $setup['instrumen']->id)
            ->assertJsonPath('data.lembaga.nama', 'LAM-INFOKOM')
            ->assertJsonPath('data.versi_instrumen.nomor_versi', '2.1')
            ->assertJsonPath('data.jenjang.nama', 'Sarjana Terapan')
            ->assertJsonPath('data.jenis_instrumen.nama', 'Instrumen APS untuk Status Terakreditasi Unggul')
            ->assertJsonPath('data.kriteria.0.kode', 'C.1')
            ->assertJsonPath('data.kriteria.0.nama', 'Budaya Mutu')
            ->assertJsonPath('data.kriteria.0.subkriteria.0.kode', 'C.1.1')
            ->assertJsonPath('data.kriteria.0.subkriteria.0.indikator.0.kode', 'IND-C.1.1.1')
            ->assertJsonPath('data.kriteria.0.subkriteria.0.indikator.0.nama', 'Konsistensi pelaksanaan siklus PPEPP')
            ->assertJsonPath('data.kriteria.0.subkriteria.0.indikator.0.bobot', 4);

        // Memastikan rubrik tidak disarangkan di struktur hierarki (eliminasi kompleksitas rubrik bersarang)
        $this->assertArrayNotHasKey('rubrik', $response->json('data.kriteria.0.subkriteria.0.indikator.0'));

        // Memastikan direct alias /api/v1/instrumen/active-static juga berjalan identik
        $aliasResponse = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/instrumen/active-static');

        $aliasResponse->assertStatus(200)
            ->assertJsonPath('data.id_instrumen', $setup['instrumen']->id);
    }

    /**
     * 2. Test active-static mengembalikan 404 saat belum ada instrumen yang terdaftar.
     */
    public function test_get_active_static_instrument_returns_404_when_no_instrument_exists(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/master/instrumen/active-static');

        $response->assertStatus(404)
            ->assertJsonPath('success', false);
    }

    /**
     * 3. Test endpoint GET /api/v1/master/instrumen/{id}/hierarchy tetap berjalan optimal.
     */
    public function test_get_instrument_hierarchy_by_id_remains_functional(): void
    {
        $setup = $this->createLamInfokomTrkInstrument();

        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->getJson('/api/v1/master/instrumen/'.$setup['instrumen']->id.'/hierarchy');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id_instrumen', $setup['instrumen']->id)
            ->assertJsonPath('data.versi_instrumen.nomor_versi', '2.1')
            ->assertJsonPath('data.jenjang.nama', 'Sarjana Terapan');
    }

    /**
     * 4. Test soft guard proteksi hapus master Rubrik yang sudah digunakan transaksi penilaian aktif.
     */
    public function test_rubrik_delete_protection_guard_prevents_deleting_active_rubrik(): void
    {
        $setup = $this->createLamInfokomTrkInstrument();

        $project = ProjectAkreditasi::create([
            'nama_project' => 'Project Akreditasi TRK 2026',
            'id_prodi' => 202,
            'id_versi_instrumen' => $setup['versi']->id,
            'id_jenjang' => $setup['jenjang']->id,
            'id_jenis_instrumen' => $setup['jenis']->id,
            'tahun_target_submit' => 2026,
            'status_project' => 'In Progress',
        ]);

        SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $setup['indikator']->id,
            'id_rubrik' => $setup['rubrik']->id,
            'skor_terbobot' => 16.0,
            'reviewer_id' => 1,
            'catatan_reviewer' => 'Memenuhi standar unggul.',
        ]);

        // Coba hapus rubrik yang sedang dipakai penilaian
        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->deleteJson('/api/v1/master/rubrik/'.$setup['rubrik']->id);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Data tidak dapat dihapus karena telah digunakan dalam penilaian atau penugasan aktif.');

        $this->assertDatabaseHas('rubrik', ['id' => $setup['rubrik']->id]);
    }

    /**
     * 5. Test master Rubrik berhasil dihapus saat belum pernah digunakan pada transaksi penilaian.
     */
    public function test_rubrik_can_be_deleted_when_not_used_in_active_transactions(): void
    {
        $setup = $this->createLamInfokomTrkInstrument();

        $unusedRubrik = Rubrik::create([
            'id_indikator' => $setup['indikator']->id,
            'skor' => 2,
            'deskripsi_rubrik' => 'Cukup',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->deleteJson('/api/v1/master/rubrik/'.$unusedRubrik->id);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Rubrik berhasil dihapus');

        $this->assertDatabaseMissing('rubrik', ['id' => $unusedRubrik->id]);
    }

    /**
     * 6. Test soft guard proteksi hapus master Indikator yang sedang aktif digunakan transaksi.
     */
    public function test_indikator_delete_protection_guard_prevents_deleting_active_indikator(): void
    {
        $setup = $this->createLamInfokomTrkInstrument();

        $project = ProjectAkreditasi::create([
            'nama_project' => 'Project Akreditasi TRK 2026',
            'id_prodi' => 202,
            'id_versi_instrumen' => $setup['versi']->id,
            'id_jenjang' => $setup['jenjang']->id,
            'id_jenis_instrumen' => $setup['jenis']->id,
            'tahun_target_submit' => 2026,
            'status_project' => 'In Progress',
        ]);

        MappingTimAkreditasi::create([
            'id_project' => $project->id,
            'id_indikator' => $setup['indikator']->id,
            'id_user' => 10,
            'role' => 'PJ',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->deleteJson('/api/v1/master/indikator/'.$setup['indikator']->id);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Data tidak dapat dihapus karena telah digunakan dalam penilaian atau penugasan aktif.');

        $this->assertDatabaseHas('indikator', ['id' => $setup['indikator']->id]);
    }

    /**
     * 7. Test audit rute master data: Rute nonaktif (Lembar Prodi manual & rubrik dinamis) mengembalikan 404.
     */
    public function test_inactive_obsolete_master_routes_return_404(): void
    {
        // Form input manual lembar prodi telah ditiadakan
        $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->getJson('/api/v1/master/lembar-prodi')
            ->assertStatus(404);

        $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->postJson('/api/v1/master/lembar-prodi', ['data' => 'dummy'])
            ->assertStatus(404);

        // Rubrik dinamis multi-jenjang telah ditiadakan (digantikan active-static)
        $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->getJson('/api/v1/master/rubrik-dinamis')
            ->assertStatus(404);
    }

    /**
     * 8. Test clean code model scopes pada Instrumen, Kriteria, dan Indikator.
     */
    public function test_model_scopes_work_correctly_on_models(): void
    {
        $setup = $this->createLamInfokomTrkInstrument();

        $activeInstrumen = Instrumen::activeStatic()->completeHierarchy()->first();
        $this->assertNotNull($activeInstrumen);
        $this->assertEquals($setup['instrumen']->id, $activeInstrumen->id);

        $kriteriaHierarchy = Kriteria::completeHierarchy()->where('id_instrumen', $setup['instrumen']->id)->first();
        $this->assertNotNull($kriteriaHierarchy);
        $this->assertEquals('C.1', $kriteriaHierarchy->kode_kriteria);
        $this->assertTrue($kriteriaHierarchy->relationLoaded('subkriteria'));

        $indikatorHierarchy = Indikator::completeHierarchy()->where('id_subkriteria', $setup['subkriteria']->id)->first();
        $this->assertNotNull($indikatorHierarchy);
        $this->assertEquals('IND-C.1.1.1', $indikatorHierarchy->kode_indikator);
        $this->assertNotNull($indikatorHierarchy->target_sumber_data);
    }
}
