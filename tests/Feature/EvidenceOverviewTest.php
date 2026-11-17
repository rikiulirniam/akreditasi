<?php

namespace Tests\Feature;

use App\Models\DataSpmiAudit;
use App\Models\EvidenceSpmi;
use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvidenceOverviewTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected string $adminToken;

    protected string $kaprodiToken;

    protected string $reviewerToken;

    protected ProjectAkreditasi $project;

    protected Indikator $indikator;

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

        // Seed dependency chain: Lembaga > VersiInstrumen > Jenjang > JenisInstrumen > Instrumen > Kriteria > Subkriteria > Indikator
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create([
            'nomor_versi' => '2.1',
            'id_lembaga' => $lembaga->id,
            'status_aktif' => true,
            'tanggal_berlaku' => '2026-01-25',
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Diploma Tiga', 'kode_jenjang' => 'D3']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Pertama']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'K1',
            'nama_kriteria' => 'Kriteria Visi Misi',
        ]);

        $subkriteria = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'SK1.1',
            'nama_subkriteria' => 'Subkriteria Kejelasan Visi',
        ]);

        $this->indikator = Indikator::create([
            'id_subkriteria' => $subkriteria->id,
            'kode_indikator' => 'IK1.1.1',
            'deskripsi_indikator' => 'Kejelasan perumusan visi',
            'bobot' => 2.50,
        ]);

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

    public function test_unauthenticated_overview_request_is_rejected(): void
    {
        $response = $this->getJson('/api/v1/projects/'.$this->project->id.'/evidence-overview');

        $response->assertStatus(401);
    }

    public function test_overview_returns_404_for_nonexistent_project(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/projects/99999/evidence-overview');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_overview_returns_null_evidence_when_project_has_no_evidence(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/evidence-overview');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Rekapitulasi evidence overview berhasil diambil',
            ])
            ->assertJsonPath('data.project.id', $this->project->id)
            ->assertJsonPath('data.project.nama_project', 'Akreditasi D3 TI 2026')
            ->assertJsonPath('data.evidence', null)
            ->assertJsonPath('data.audit_summary.total', 0)
            ->assertJsonPath('data.audit_summary.open', 0)
            ->assertJsonPath('data.audit_summary.closed', 0);
    }

    public function test_overview_returns_full_data_with_evidence_and_audits(): void
    {
        // Buat evidence 4 pilar
        EvidenceSpmi::create([
            'project_id' => $this->project->id,
            'link_bukti_evaluasi' => 'https://drive.google.com/evaluasi',
            'deskripsi_bukti_evaluasi' => 'Laporan AMI',
            'link_bukti_pengendalian' => 'https://drive.google.com/pengendalian',
            'deskripsi_bukti_pengendalian' => 'Notulen RTM',
            'link_bukti_dampak' => 'https://drive.google.com/dampak',
            'deskripsi_bukti_dampak' => 'Capaian IKU',
            'link_dokumen_implementasi' => 'https://drive.google.com/implementasi',
            'deskripsi_dokumen_implementasi' => 'Manual Mutu',
        ]);

        // Buat mapping tim (penugasan PIC)
        MappingTimAkreditasi::create([
            'id_project' => $this->project->id,
            'id_user' => 10,
            'id_indikator' => $this->indikator->id,
            'role' => 'PIC',
        ]);

        // Buat temuan audit SPMI
        DataSpmiAudit::create([
            'id_project' => $this->project->id,
            'id_indikator' => $this->indikator->id,
            'jenis_kegiatan' => 'AMI',
            'tanggal_pelaksanaan' => '2026-06-15',
            'tahun_audit' => 2026,
            'temuan' => 'Dokumen SOP belum mutakhir',
            'tindak_lanjut' => 'Update SOP',
            'status_penyelesaian' => 'Open',
        ]);

        DataSpmiAudit::create([
            'id_project' => $this->project->id,
            'id_indikator' => $this->indikator->id,
            'jenis_kegiatan' => 'RTM',
            'tanggal_pelaksanaan' => '2026-07-20',
            'tahun_audit' => 2026,
            'temuan' => 'Tindak lanjut RTM sudah selesai',
            'tindak_lanjut' => 'Sudah dilaksanakan',
            'status_penyelesaian' => 'Closed',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->reviewerToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/evidence-overview');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Rekapitulasi evidence overview berhasil diambil',
            ]);

        $data = $response->json('data');

        // Verifikasi project info
        $this->assertEquals($this->project->id, $data['project']['id']);
        $this->assertEquals('Akreditasi D3 TI 2026', $data['project']['nama_project']);
        $this->assertEquals('Draft', $data['project']['status_project']);

        // Verifikasi 4 pilar evidence
        $this->assertNotNull($data['evidence']);
        $this->assertEquals('https://drive.google.com/evaluasi', $data['evidence']['pilar_1_evaluasi']['link']);
        $this->assertEquals('Laporan AMI', $data['evidence']['pilar_1_evaluasi']['deskripsi']);
        $this->assertEquals('https://drive.google.com/pengendalian', $data['evidence']['pilar_2_pengendalian']['link']);
        $this->assertEquals('https://drive.google.com/dampak', $data['evidence']['pilar_3_dampak']['link']);
        $this->assertEquals('https://drive.google.com/implementasi', $data['evidence']['pilar_4_implementasi']['link']);

        // Verifikasi indikator yang ditugaskan
        $this->assertCount(1, $data['assigned_indicators']);
        $this->assertEquals($this->indikator->id, $data['assigned_indicators'][0]['id_indikator']);
        $this->assertEquals(10, $data['assigned_indicators'][0]['id_user']);

        // Verifikasi rekapitulasi audit
        $this->assertEquals(2, $data['audit_summary']['total']);
        $this->assertEquals(1, $data['audit_summary']['open']);
        $this->assertEquals(1, $data['audit_summary']['closed']);

        // Verifikasi detail audit
        $this->assertCount(2, $data['audits']);
    }

    public function test_overview_accessible_by_all_authenticated_roles(): void
    {
        // Admin
        $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/evidence-overview')
            ->assertStatus(200);

        // Kaprodi
        $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/evidence-overview')
            ->assertStatus(200);

        // Reviewer
        $this->withHeader('Authorization', 'Bearer '.$this->reviewerToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/evidence-overview')
            ->assertStatus(200);
    }
}
