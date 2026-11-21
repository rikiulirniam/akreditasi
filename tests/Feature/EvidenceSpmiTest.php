<?php

namespace Tests\Feature;

use App\Models\EvidenceSpmi;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\LembagaAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvidenceSpmiTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected string $adminToken;

    protected string $kaprodiToken;

    protected string $reviewerToken;

    protected ProjectAkreditasi $project;

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
            'nama' => 'Kaprodi TI',
            'email' => 'kaprodi@polines.ac.id',
            'role' => 'KAPRODI',
            'permissions' => ['*'],
        ]);

        $this->reviewerToken = $this->jwtService->generateToken([
            'sub' => '3',
            'nama' => 'Reviewer Akreditasi',
            'email' => 'reviewer@polines.ac.id',
            'role' => 'REVIEWER',
            'permissions' => ['*'],
        ]);

        // Seed basic dependency for ProjectAkreditasi
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create([
            'nomor_versi' => '2.1',
            'id_lembaga' => $lembaga->id,
            'tanggal_berlaku' => '2026-01-25',
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Diploma Tiga', 'kode_jenjang' => 'D3']);
        $versi->jenjangs()->attach($jenjang->id, ['status_aktif' => true]);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Pertama']);

        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 1,
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi D3 TI 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'Draft',
        ]);
    }

    public function test_unauthenticated_request_is_rejected(): void
    {
        $response = $this->getJson('/api/v1/evidence-spmi?project_id='.$this->project->id);
        $response->assertStatus(401);

        $postResponse = $this->postJson('/api/v1/evidence-spmi', [
            'project_id' => $this->project->id,
        ]);
        $postResponse->assertStatus(401);
    }

    public function test_get_evidence_returns_200_with_null_when_project_has_no_evidence(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/evidence-spmi?project_id='.$this->project->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data evidence SPMI berhasil diambil',
                'data' => null,
            ]);
    }

    public function test_get_evidence_fails_with_422_when_project_id_is_missing(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/evidence-spmi');

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_kaprodi_can_create_evidence_spmi_with_partial_data(): void
    {
        $payload = [
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-ami',
            'deskripsi_bukti_evaluasi' => 'Laporan Hasil Audit Mutu Internal Semester Genap 2025/2026',
            // Kolom lainnya dikosongkan/opsional
        ];

        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->postJson('/api/v1/evidence-spmi', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Evidence SPMI berhasil disimpan',
                'data' => [
                    'project_id' => $this->project->id,
                    'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-ami',
                    'deskripsi_bukti_evaluasi' => 'Laporan Hasil Audit Mutu Internal Semester Genap 2025/2026',
                    'link_bukti_pengendalian' => null,
                    'deskripsi_bukti_pengendalian' => null,
                ],
            ]);

        $this->assertDatabaseHas('evidence_spmi', [
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-ami',
        ]);
    }

    public function test_post_evidence_updates_existing_record_with_update_or_create(): void
    {
        // 1. Simpan awal hanya bukti evaluasi
        $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->postJson('/api/v1/evidence-spmi', [
                'project_id' => $this->project->id,
                'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-v1',
                'deskripsi_bukti_evaluasi' => 'Versi 1',
            ])->assertStatus(200);

        $this->assertDatabaseCount('evidence_spmi', 1);

        // 2. Simpan kedua menambahkan bukti pengendalian dan memperbarui link evaluasi
        $updateResponse = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->postJson('/api/v1/evidence-spmi', [
                'project_id' => $this->project->id,
                'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-v2',
                'link_bukti_pengendalian' => 'https://drive.google.com/pengendalian',
                'deskripsi_bukti_pengendalian' => 'RTL dan tindak lanjut RTM',
                'link_bukti_dampak' => 'https://drive.google.com/dampak',
                'deskripsi_bukti_dampak' => 'Prestasi mahasiswa tingkat nasional',
                'link_dokumen_implementasi' => 'https://drive.google.com/implementasi',
                'deskripsi_dokumen_implementasi' => 'SOP pelaksanaan praktikum lab',
            ]);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'project_id' => $this->project->id,
                    'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-v2',
                    'link_bukti_pengendalian' => 'https://drive.google.com/pengendalian',
                    'deskripsi_bukti_pengendalian' => 'RTL dan tindak lanjut RTM',
                    'link_bukti_dampak' => 'https://drive.google.com/dampak',
                    'deskripsi_bukti_dampak' => 'Prestasi mahasiswa tingkat nasional',
                    'link_dokumen_implementasi' => 'https://drive.google.com/implementasi',
                    'deskripsi_dokumen_implementasi' => 'SOP pelaksanaan praktikum lab',
                ],
            ]);

        // Pastikan record tetap 1 (tidak duplikat)
        $this->assertDatabaseCount('evidence_spmi', 1);
        $this->assertDatabaseHas('evidence_spmi', [
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi-v2',
        ]);
    }

    public function test_get_evidence_returns_data_when_exists(): void
    {
        EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi',
            'deskripsi_bukti_evaluasi' => 'Laporan AMI',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->reviewerToken)
            ->getJson('/api/v1/evidence-spmi?project_id='.$this->project->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data evidence SPMI berhasil diambil',
                'data' => [
                    'project_id' => $this->project->id,
                    'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi',
                    'deskripsi_bukti_evaluasi' => 'Laporan AMI',
                ],
            ]);
    }

    public function test_post_evidence_fails_with_422_when_project_id_does_not_exist(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->postJson('/api/v1/evidence-spmi', [
                'project_id' => 99999, // Tidak ada di database
                'link_bukti_evaluasi' => 'https://example.com',
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => ['project_id'],
            ]);
    }

    public function test_relations_between_project_and_evidence_spmi(): void
    {
        $evidence = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/relasi-test',
        ]);

        // Test belongsTo Project (ProjectAkreditasi)
        $this->assertInstanceOf(ProjectAkreditasi::class, $evidence->project);
        $this->assertEquals($this->project->id, $evidence->project->id);

        // Test hasOne pada ProjectAkreditasi
        $projectAkreditasiModel = ProjectAkreditasi::find($this->project->id);
        $this->assertInstanceOf(EvidenceSpmi::class, $projectAkreditasiModel->evidenceSpmi);
        $this->assertEquals($evidence->id, $projectAkreditasiModel->evidenceSpmi->id);
    }

    // ==========================================
    // DELETE Evidence SPMI
    // ==========================================

    public function test_unauthenticated_delete_is_rejected(): void
    {
        $evidence = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/delete-test',
        ]);

        $response = $this->deleteJson('/api/v1/evidence-spmi/'.$evidence->id);

        $response->assertStatus(401);
        $this->assertDatabaseHas('evidence_spmi', ['id' => $evidence->id]);
    }

    public function test_admin_can_delete_evidence_spmi(): void
    {
        $evidence = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/delete-admin',
            'deskripsi_bukti_evaluasi' => 'Akan dihapus oleh admin',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->deleteJson('/api/v1/evidence-spmi/'.$evidence->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data evidence SPMI berhasil dihapus',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('evidence_spmi', ['id' => $evidence->id]);
    }

    public function test_kaprodi_can_delete_evidence_spmi(): void
    {
        $evidence = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/delete-kaprodi',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->deleteJson('/api/v1/evidence-spmi/'.$evidence->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Data evidence SPMI berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('evidence_spmi', ['id' => $evidence->id]);
    }

    public function test_delete_returns_404_when_evidence_not_found(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->deleteJson('/api/v1/evidence-spmi/99999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Data evidence SPMI tidak ditemukan.',
            ]);
    }

    public function test_reviewer_cannot_delete_evidence_spmi(): void
    {
        $evidence = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/reviewer-noaccess',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->reviewerToken)
            ->deleteJson('/api/v1/evidence-spmi/'.$evidence->id);

        // Reviewer seharusnya 403 karena route hanya untuk administrator,kaprodi
        $response->assertStatus(403);
        $this->assertDatabaseHas('evidence_spmi', ['id' => $evidence->id]);
    }

    // ==========================================
    // Local Scope & Helper
    // ==========================================

    public function test_scope_for_project_filters_correctly(): void
    {
        EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/scope-test',
        ]);

        $result = EvidenceSpmi::forProject($this->project->id)->first();

        $this->assertNotNull($result);
        $this->assertEquals($this->project->id, $result->project_id);

        // Non-existent project returns null
        $empty = EvidenceSpmi::forProject(99999)->first();
        $this->assertNull($empty);
    }

    public function test_count_filled_pilars_returns_correct_count(): void
    {
        // 0 pilar terisi
        $evidenceEmpty = EvidenceSpmi::create([
            'project_id' => $this->project->id,
        ]);
        $this->assertEquals(0, $evidenceEmpty->countFilledPilars());

        $evidenceEmpty->delete();

        // 2 pilar terisi
        $evidencePartial = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi',
            'link_bukti_dampak' => 'https://drive.google.com/dampak',
        ]);
        $this->assertEquals(2, $evidencePartial->countFilledPilars());

        $evidencePartial->delete();

        // 4 pilar terisi
        $evidenceFull = EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi',
            'link_bukti_pengendalian' => 'https://drive.google.com/pengendalian',
            'link_bukti_dampak' => 'https://drive.google.com/dampak',
            'link_dokumen_implementasi' => 'https://drive.google.com/implementasi',
        ]);
        $this->assertEquals(4, $evidenceFull->countFilledPilars());
    }
}
