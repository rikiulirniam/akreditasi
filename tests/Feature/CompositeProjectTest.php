<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\ProjectIndicatorEvidence;
use App\Models\Rubrik;
use App\Models\SelfAssessment;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompositeProjectTest extends TestCase
{
    use RefreshDatabase;

    private string $token;

    private ProjectAkreditasi $project;

    /**
     * Menyiapkan master instrumen, project, dan sembilan kriteria untuk skenario composite.
     */
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
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Instrumen APS untuk Status Terakreditasi Unggul']);
        $instrument = Instrumen::create([
            'id_versi_instrumen' => $version->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);
        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 101,
            'id_versi_instrumen' => $version->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi TRK 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'Draft',
        ]);

        for ($number = 1; $number <= 9; $number++) {
            $criterion = Kriteria::create([
                'id_instrumen' => $instrument->id,
                'kode_kriteria' => 'C.'.$number,
                'nama_kriteria' => 'Kriteria '.$number,
            ]);
            $subcriterion = Subkriteria::create([
                'id_kriteria' => $criterion->id,
                'kode_subkriteria' => 'C.'.$number.'.1',
                'nama_subkriteria' => 'Subkriteria '.$number,
            ]);
            $indicator = Indikator::create([
                'id_subkriteria' => $subcriterion->id,
                'kode_indikator' => 'IND-C.'.$number.'.1',
                'deskripsi_indikator' => 'Indikator '.$number,
                'bobot' => 10,
            ]);

            if ($number <= 3) {
                ProjectIndicatorEvidence::create([
                    'id_project' => $this->project->id,
                    'id_indikator' => $indicator->id,
                    'link_evidence' => 'https://example.test/evidence/'.$number,
                ]);
            }

            $rubrik = Rubrik::create([
                'id_indikator' => $indicator->id,
                'skor' => 4,
                'deskripsi_rubrik' => 'Sangat Baik',
            ]);
            SelfAssessment::create([
                'id_project' => $this->project->id,
                'id_indikator' => $indicator->id,
                'id_rubrik' => $rubrik->id,
                'skor_terbobot' => 40,
            ]);
        }
    }

    /**
     * Memastikan composite mengembalikan profil, progress, evidence, dan simulasi skor.
     */
    public function test_composite_overview_returns_profile_progress_evidence_and_score(): void
    {
        $response = $this->withToken($this->token)
            ->getJson('/api/v1/projects/'.$this->project->id.'/composite-overview');

        $response->assertOk()
            ->assertJsonPath('data.profil_project.nama_project', 'Akreditasi TRK 2026')
            ->assertJsonPath('data.progress.total_indikator', 9)
            ->assertJsonPath('data.progress.indikator_terisi_bukti', 3)
            ->assertJsonPath('data.progress.progres_total_persen', 33.33)
            ->assertJsonCount(9, 'data.progress_9_kriteria')
            ->assertJsonCount(9, 'data.ringkasan_evidence_per_kriteria')
            ->assertJsonPath('data.ringkasan_evidence_per_kriteria.0.jumlah_evidence', 1)
            ->assertJsonPath('data.simulasi_skor.total_skor', 360)
            ->assertJsonPath('data.simulasi_skor.predikat', 'Terakreditasi Baik Sekali');
    }

    /**
     * Memastikan composite mengembalikan 404 untuk project yang tidak ada.
     */
    public function test_composite_overview_returns_not_found_for_missing_project(): void
    {
        $this->withToken($this->token)
            ->getJson('/api/v1/projects/999/composite-overview')
            ->assertNotFound();
    }
}
