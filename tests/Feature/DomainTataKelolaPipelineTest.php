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
use App\Models\SelfAssessment;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Database\Seeders\LamInfokomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainTataKelolaPipelineTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected string $adminToken;

    protected string $kaprodiToken;

    protected string $dosenToken;

    protected string $reviewerToken;

    protected ProjectAkreditasi $project;

    protected Indikator $indikatorAktif;

    protected Indikator $indikatorStatisK5;

    protected function setUp(): void
    {
        parent::setUp();

        $this->jwtService = app(JwtService::class);

        $this->adminToken = $this->jwtService->generateToken([
            'sub' => '1',
            'nama' => 'Admin Sistem',
            'email' => 'admin@polines.ac.id',
            'role' => 'ADMINISTRATOR',
            'permissions' => ['*'],
        ]);

        $this->kaprodiToken = $this->jwtService->generateToken([
            'sub' => '2',
            'nama' => 'Kaprodi TRK',
            'email' => 'kaprodi@polines.ac.id',
            'role' => 'KAPRODI',
            'permissions' => ['*'],
        ]);

        $this->dosenToken = $this->jwtService->generateToken([
            'sub' => '10',
            'nama' => 'Dosen TRK',
            'email' => 'dosen@polines.ac.id',
            'role' => 'DOSEN',
            'permissions' => ['read'],
        ]);

        $this->reviewerToken = $this->jwtService->generateToken([
            'sub' => '20',
            'nama' => 'Reviewer',
            'email' => 'reviewer@polines.ac.id',
            'role' => 'REVIEWER',
            'permissions' => ['read'],
        ]);

        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create([
            'nomor_versi' => '2.1',
            'id_lembaga' => $lembaga->id,
            'tanggal_berlaku' => '2026-01-25',
            'keterangan' => 'Instrumen Akreditasi Program Studi Sarjana Terapan TRK (Aktif)',
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Sarjana Terapan', 'kode_jenjang' => 'D4']);
        $versi->jenjangs()->attach($jenjang->id, ['status_aktif' => true]);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Program Studi']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria2 = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'K2',
            'nama_kriteria' => 'Kriteria 2: Relevansi Pendidikan',
        ]);

        $sub2 = Subkriteria::create([
            'id_kriteria' => $kriteria2->id,
            'kode_subkriteria' => '2.1',
            'nama_subkriteria' => 'Kurikulum OBE',
        ]);

        $this->indikatorAktif = Indikator::create([
            'id_subkriteria' => $sub2->id,
            'kode_indikator' => '2.1.B',
            'deskripsi_indikator' => 'Standar isi pembelajaran & kurikulum OBE KKNI Level 6',
            'bobot' => 4.00,
        ]);

        $kriteria5 = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'K5',
            'nama_kriteria' => 'Akuntabilitas (Tata Pamong, Keuangan, Sarpras)',
        ]);

        $sub5 = Subkriteria::create([
            'id_kriteria' => $kriteria5->id,
            'kode_subkriteria' => '5.1',
            'nama_subkriteria' => 'Standar Tata Kelola Otonom',
        ]);

        $this->indikatorStatisK5 = Indikator::create([
            'id_subkriteria' => $sub5->id,
            'kode_indikator' => '5.1.A',
            'deskripsi_indikator' => 'Indikator statis non-handle',
            'bobot' => 4.00,
        ]);

        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 1,
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi TRK 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'Draft',
        ]);
    }

    public function test_a1_versi_instrumen_returns_active_and_archive_versions_from_seeder(): void
    {
        $this->seed(LamInfokomSeeder::class);

        $response = $this->withToken($this->dosenToken)
            ->getJson('/api/v1/master/versi-instrumen');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $items = collect($response->json('data'));
        $v21 = $items->firstWhere('nomor_versi', '2.1');
        $v20 = $items->firstWhere('nomor_versi', '2.0');

        $this->assertNotNull($v21);
        $this->assertNotNull($v20);
        $this->assertTrue($v21['status_aktif']);
        $this->assertFalse($v20['status_aktif']);
        $this->assertEquals('LAM-INFOKOM', $v21['nama_lembaga']);
        $this->assertEquals('2022-06-01', $v20['tanggal_berlaku']);
        $this->assertNotEmpty($v20['keterangan']);
    }

    public function test_a2_placeholder_modules_returns_static_kriteria_5_details_and_404_on_missing_project(): void
    {
        $this->withToken($this->dosenToken)
            ->getJson("/api/v1/projects/{$this->project->id}/placeholder-modules")
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.1.kode_kriteria', 'C.5')
            ->assertJsonPath('data.1.total_bobot', 40)
            ->assertJsonPath('data.1.is_placeholder', true)
            ->assertJsonPath('data.1.subkriteria.0.is_editable', false);

        $this->withToken($this->dosenToken)
            ->getJson('/api/v1/projects/999999/placeholder-modules')
            ->assertStatus(404);
    }

    public function test_a3_batch_mapping_tim_rejects_static_k5_indicator_and_invalid_role_and_non_admin_kaprodi(): void
    {
        // Dosen ditolak 403
        $this->withToken($this->dosenToken)
            ->postJson("/api/v1/projects/{$this->project->id}/mapping-tim", [
                'assignments' => [
                    ['id_user' => 10, 'id_indikator' => $this->indikatorAktif->id, 'role' => 'PIC'],
                ],
            ])
            ->assertStatus(403);

        // Role selain PJ/PIC ditolak 422
        $this->withToken($this->kaprodiToken)
            ->postJson("/api/v1/projects/{$this->project->id}/mapping-tim", [
                'assignments' => [
                    ['id_user' => 10, 'id_indikator' => $this->indikatorAktif->id, 'role' => 'KETUA'],
                ],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['assignments.0.role']);

        // Indikator dari Kriteria 5 (non-handle) ditolak 422
        $this->withToken($this->kaprodiToken)
            ->postJson("/api/v1/projects/{$this->project->id}/mapping-tim", [
                'assignments' => [
                    ['id_user' => 10, 'id_indikator' => $this->indikatorStatisK5->id, 'role' => 'PJ'],
                ],
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['assignments.0.id_indikator']);

        // Sukses 201 untuk indikator aktif
        $this->withToken($this->kaprodiToken)
            ->postJson("/api/v1/projects/{$this->project->id}/mapping-tim", [
                'assignments' => [
                    ['id_user' => 10, 'id_indikator' => $this->indikatorAktif->id, 'role' => 'PJ'],
                    ['id_user' => 12, 'id_indikator' => $this->indikatorAktif->id, 'role' => 'PIC'],
                ],
            ])
            ->assertStatus(201)
            ->assertJsonCount(2, 'data');
    }

    public function test_a4_my_assignments_excludes_static_k5_indicators_and_includes_status_fields(): void
    {
        MappingTimAkreditasi::create([
            'id_project' => $this->project->id,
            'id_user' => 10,
            'id_indikator' => $this->indikatorAktif->id,
            'role' => 'PIC',
        ]);

        // Even if K5 exists in DB, my-assignments must exclude it
        MappingTimAkreditasi::create([
            'id_project' => $this->project->id,
            'id_user' => 10,
            'id_indikator' => $this->indikatorStatisK5->id,
            'role' => 'PIC',
        ]);

        $response = $this->withToken($this->dosenToken)
            ->getJson('/api/v1/dosen/my-assignments');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id_indikator', $this->indikatorAktif->id)
            ->assertJsonPath('data.0.status_narasi', 'Belum Terisi')
            ->assertJsonPath('data.0.status_evidence', 'Belum Terunggah');
    }

    public function test_a5_penjelasan_prodi_enforces_kaprodi_admin_role_and_min_length(): void
    {
        $assessment = SelfAssessment::create([
            'id_project' => $this->project->id,
            'id_indikator' => $this->indikatorAktif->id,
            'catatan_reviewer' => 'Perlu tambahan berkas SK Kurikulum OBE terbaru.',
        ]);

        // Dosen ditolak 403
        $this->withToken($this->dosenToken)
            ->putJson("/api/v1/self-assessment/{$assessment->id}/penjelasan-prodi", [
                'tanggapan_kaprodi' => 'Tanggapan dari dosen yang tidak berhak',
            ])
            ->assertStatus(403)
            ->assertJsonPath('success', false);

        // Min 5 karakter ditolak 422
        $this->withToken($this->kaprodiToken)
            ->putJson("/api/v1/self-assessment/{$assessment->id}/penjelasan-prodi", [
                'tanggapan_kaprodi' => 'abc',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['tanggapan_kaprodi']);

        // Kaprodi sukses 200
        $this->withToken($this->kaprodiToken)
            ->putJson("/api/v1/self-assessment/{$assessment->id}/penjelasan-prodi", [
                'tanggapan_kaprodi' => 'SK Kurikulum OBE 2024 dan Berita Acara DUDIKA telah disematkan.',
            ])
            ->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_a6_and_a7_evidence_spmi_url_validation_dosen_access_and_overview_percentage(): void
    {
        // Reject javascript: dangerous scheme (422)
        $this->withToken($this->dosenToken)
            ->postJson('/api/v1/evidence-spmi', [
                'project_id' => $this->project->id,
                'link_bukti_evaluasi' => 'javascript:alert(1)',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['link_bukti_evaluasi']);

        // Dosen allowed to store valid URLs including alias fields (200)
        $this->withToken($this->dosenToken)
            ->postJson('/api/v1/evidence-spmi', [
                'project_id' => $this->project->id,
                'link_bukti_evaluasi' => 'https://drive.google.com/file/d/1abc/view',
                'deskripsi_bukti_evaluasi' => 'Laporan Hasil AMI 2024',
                'link_dokumen_kebijakan' => 'https://drive.google.com/file/d/2def/view',
                'link_dokumen_manual' => 'https://drive.google.com/file/d/3ghi/view',
            ])
            ->assertStatus(200)
            ->assertJsonPath('success', true);

        // A7: Overview shows 3/4 = 75.0% and evidence_pilar
        $this->withToken($this->dosenToken)
            ->getJson("/api/v1/projects/{$this->project->id}/evidence-overview")
            ->assertStatus(200)
            ->assertJsonPath('data.kelengkapan_pilar.total_pilar', 4)
            ->assertJsonPath('data.kelengkapan_pilar.terisi', 3)
            ->assertJsonPath('data.kelengkapan_pilar.persentase', '75.0%')
            ->assertJsonPath('data.evidence_pilar.pilar_1_evaluasi.status', 'Terisi')
            ->assertJsonPath('data.evidence_pilar.pilar_4_formulir.status', 'Belum Terisi');
    }

    public function test_a8_put_project_status_allows_admin_and_kaprodi_to_set_selesai_without_sk(): void
    {
        // Dosen ditolak 403
        $this->withToken($this->dosenToken)
            ->putJson("/api/v1/projects/{$this->project->id}/status", [
                'status_project' => 'Selesai',
            ])
            ->assertStatus(403);

        // Administrator sukses transisi ke Pengisian -> Selesai tanpa SK
        $this->withToken($this->adminToken)
            ->putJson("/api/v1/projects/{$this->project->id}/status", [
                'status_project' => 'Pengisian',
            ])
            ->assertStatus(200)
            ->assertJsonPath('data.status_project', 'Pengisian');

        $this->withToken($this->kaprodiToken)
            ->putJson("/api/v1/projects/{$this->project->id}/status", [
                'status_project' => 'Selesai',
                'nomor_sk' => null,
            ])
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status_project', 'Selesai');
    }
}
