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
use App\Models\ProjectIndicatorEvidence;
use App\Models\SelfAssessment;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardMetricsTest extends TestCase
{
    use RefreshDatabase;

    private string $token;

    private ProjectAkreditasi $project;

    /**
     * @var array<int, Indikator>
     */
    private array $indicators = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = app(JwtService::class)->generateToken([
            'sub' => '20',
            'nama' => 'Kaprodi TRK',
            'email' => 'kaprodi@example.test',
            'role' => 'KAPRODI',
            'permissions' => ['*'],
        ]);

        $institution = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $version = VersiInstrumen::create([
            'id_lembaga' => $institution->id,
            'nomor_versi' => '2.1',
            'tanggal_berlaku' => '2026-01-25',
            'status_aktif' => true,
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Sarjana Terapan']);
        $jenisInstrumen = JenisInstrumen::create([
            'nama_jenis' => 'Instrumen APS untuk Status Terakreditasi Unggul',
        ]);
        $instrument = Instrumen::create([
            'id_versi_instrumen' => $version->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenisInstrumen->id,
        ]);

        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 101,
            'id_versi_instrumen' => $version->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenisInstrumen->id,
            'nama_project' => 'Akreditasi Program Studi TRK '.now()->year,
            'tahun_target_submit' => now()->year,
            'status_project' => 'Draft',
        ]);

        for ($criterionNumber = 1; $criterionNumber <= 9; $criterionNumber++) {
            $criterion = Kriteria::create([
                'id_instrumen' => $instrument->id,
                'kode_kriteria' => 'K-'.$criterionNumber,
                'nama_kriteria' => 'Kriteria '.$criterionNumber,
            ]);
            $subcriterion = Subkriteria::create([
                'id_kriteria' => $criterion->id,
                'kode_subkriteria' => 'SK-'.$criterionNumber.'.1',
                'nama_subkriteria' => 'Subkriteria '.$criterionNumber,
            ]);

            $this->indicators[] = Indikator::create([
                'id_subkriteria' => $subcriterion->id,
                'kode_indikator' => 'IND-'.$criterionNumber.'.1.1',
                'deskripsi_indikator' => 'Indikator '.$criterionNumber,
                'bobot' => 1,
            ]);

            if ($criterionNumber === 1) {
                $this->indicators[] = Indikator::create([
                    'id_subkriteria' => $subcriterion->id,
                    'kode_indikator' => 'IND-1.1.2',
                    'deskripsi_indikator' => 'Indikator tambahan',
                    'bobot' => 1,
                ]);
            }
        }
    }

    public function test_dashboard_progress_calculates_each_criterion_and_overall_percentage(): void
    {
        ProjectIndicatorEvidence::create([
            'id_project' => $this->project->id,
            'id_indikator' => $this->indicators[0]->id,
            'link_evidence' => 'https://example.test/evidence/1',
        ]);

        $response = $this->withToken($this->token)
            ->getJson('/api/v1/projects/'.$this->project->id.'/dashboard-progress');

        $response->assertOk()
            ->assertJsonPath('data.kriteria.0.total_indikator', 2)
            ->assertJsonPath('data.kriteria.0.indikator_terisi_bukti', 1)
            ->assertJsonPath('data.kriteria.0.progres_persen', 50)
            ->assertJsonPath('data.kriteria.1.progres_persen', 0)
            ->assertJsonPath('data.total_indikator', 10)
            ->assertJsonPath('data.indikator_terisi_bukti', 1)
            ->assertJsonPath('data.progres_total_persen', 10);
    }

    public function test_readiness_lists_missing_pic_evidence_and_reviewer_score(): void
    {
        $indicator = $this->indicators[0];
        MappingTimAkreditasi::create([
            'id_project' => $this->project->id,
            'id_user' => 55,
            'id_indikator' => $indicator->id,
            'role' => 'PIC',
        ]);
        ProjectIndicatorEvidence::create([
            'id_project' => $this->project->id,
            'id_indikator' => $indicator->id,
            'link_evidence' => 'https://example.test/evidence/1',
        ]);
        SelfAssessment::create([
            'id_project' => $this->project->id,
            'id_indikator' => $indicator->id,
            'skor_terbobot' => 0,
        ]);

        $response = $this->withToken($this->token)
            ->getJson('/api/v1/projects/'.$this->project->id.'/readiness');

        $response->assertOk()
            ->assertJsonPath('data.total_indikator_kritis', 10)
            ->assertJsonPath('data.jumlah_indikator_belum_siap', 9)
            ->assertJsonPath('data.siap_submit', false)
            ->assertJsonPath('data.indikator_belum_siap.0.belum_terpenuhi.0', 'pic')
            ->assertJsonPath('data.indikator_belum_siap.0.belum_terpenuhi.1', 'link_evidence')
            ->assertJsonPath('data.indikator_belum_siap.0.belum_terpenuhi.2', 'skor_reviewer');
    }

    public function test_quick_create_uses_active_21_instrument_and_defaults(): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/v1/projects/quick-create', ['id_prodi' => 202]);

        $response->assertCreated()
            ->assertJsonPath('data.id_prodi', 202)
            ->assertJsonPath('data.id_versi_instrumen', $this->project->id_versi_instrumen)
            ->assertJsonPath('data.id_jenjang', $this->project->id_jenjang)
            ->assertJsonPath('data.id_jenis_instrumen', $this->project->id_jenis_instrumen)
            ->assertJsonPath('data.nama_project', 'Akreditasi Program Studi TRK '.now()->year)
            ->assertJsonPath('data.tahun_target_submit', now()->year)
            ->assertJsonPath('data.status_project', 'Draft');
    }

    public function test_quick_create_requires_program_study_id(): void
    {
        $this->withToken($this->token)
            ->postJson('/api/v1/projects/quick-create')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['id_prodi']);
    }

    public function test_dashboard_and_readiness_return_not_found_for_missing_project(): void
    {
        $this->withToken($this->token)
            ->getJson('/api/v1/projects/999/dashboard-progress')
            ->assertNotFound();

        $this->withToken($this->token)
            ->getJson('/api/v1/projects/999/readiness')
            ->assertNotFound();
    }

    public function test_evidence_endpoint_updates_a_project_indicator_link(): void
    {
        $path = '/api/v1/projects/'.$this->project->id.'/indicators/'.$this->indicators[0]->id.'/evidence';

        $this->withToken($this->token)
            ->putJson($path, ['link_evidence' => 'https://example.test/evidence/new'])
            ->assertOk()
            ->assertJsonPath('data.link_evidence', 'https://example.test/evidence/new');

        $this->withToken($this->token)
            ->getJson($path)
            ->assertOk()
            ->assertJsonPath('data.link_evidence', 'https://example.test/evidence/new');
    }

    public function test_quick_create_fails_when_required_active_master_data_is_missing(): void
    {
        VersiInstrumen::whereKey($this->project->id_versi_instrumen)
            ->update(['status_aktif' => false]);

        $this->withToken($this->token)
            ->postJson('/api/v1/projects/quick-create', ['id_prodi' => 202])
            ->assertUnprocessable()
            ->assertJsonPath('success', false);
    }
}
