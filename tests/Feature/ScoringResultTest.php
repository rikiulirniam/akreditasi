<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\Rubrik;
use App\Models\SelfAssessment;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\Akreditasi\ScoringCalculationService;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScoringResultTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwtService = app(JwtService::class);
    }

    protected function generateToken(string $role, int $userId = 1): string
    {
        return $this->jwtService->generateToken([
            'sub' => (string) $userId,
            'nama' => 'Test '.ucfirst($role),
            'email' => strtolower($role).'@polines.ac.id',
            'role' => strtoupper($role),
            'permissions' => ['*'],
        ]);
    }

    protected function createBaseProject(): array
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create([
            'id_lembaga' => $lembaga->id,
            'nomor_versi' => '2.1',
            'tanggal_berlaku' => '2026-01-25',
            'status_aktif' => true,
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Sarjana Terapan']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Instrumen APS Akreditasi Unggul']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $project = ProjectAkreditasi::create([
            'id_prodi' => 202,
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi D4 Teknik Informatika',
            'tahun_target_submit' => 2026,
            'status_project' => 'In Progress',
        ]);

        return [$project, $instrumen];
    }

    protected function createIndikatorWithRubriks(
        Instrumen $instrumen,
        string $kodeKriteria,
        string $kodeSubkriteria,
        string $kodeIndikator,
        float $bobot
    ): Indikator {
        $kriteria = Kriteria::firstOrCreate(
            ['id_instrumen' => $instrumen->id, 'kode_kriteria' => $kodeKriteria],
            ['nama_kriteria' => 'Kriteria '.$kodeKriteria]
        );

        $subkriteria = Subkriteria::firstOrCreate(
            ['id_kriteria' => $kriteria->id, 'kode_subkriteria' => $kodeSubkriteria],
            ['nama_subkriteria' => 'Subkriteria '.$kodeSubkriteria]
        );

        $indikator = Indikator::create([
            'id_subkriteria' => $subkriteria->id,
            'kode_indikator' => $kodeIndikator,
            'deskripsi_indikator' => 'Deskripsi '.$kodeIndikator,
            'bobot' => $bobot,
        ]);

        foreach ([1, 2, 3, 4] as $skor) {
            Rubrik::create([
                'id_indikator' => $indikator->id,
                'skor' => $skor,
                'deskripsi_rubrik' => "Rubrik skor $skor untuk {$kodeIndikator}",
            ]);
        }

        return $indikator;
    }

    /**
     * Test 1: Endpoint accessible oleh seluruh role resmi dan ditolak jika unauthenticated (401).
     */
    public function test_endpoint_access_control_and_unauthenticated_rejection(): void
    {
        [$project, $instrumen] = $this->createBaseProject();
        $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.01', 10.0);

        // Unauthenticated -> 401
        $this->getJson("/api/v1/projects/{$project->id}/scoring-result")
            ->assertStatus(401);

        // Role aktif: ADMINISTRATOR, KAPRODI, DOSEN -> 200
        foreach (['ADMINISTRATOR', 'KAPRODI', 'DOSEN'] as $role) {
            $token = $this->generateToken($role);
            $this->withHeader('Authorization', 'Bearer '.$token)
                ->getJson("/api/v1/projects/{$project->id}/scoring-result")
                ->assertStatus(200);
        }

        // Role REVIEWER ditolak -> 403
        $reviewerToken = $this->generateToken('REVIEWER');
        $this->withHeader('Authorization', 'Bearer '.$reviewerToken)
            ->getJson("/api/v1/projects/{$project->id}/scoring-result")
            ->assertStatus(403);
    }

    /**
     * Test 2: Struktur respons JSON lengkap sesuai kontrak.
     */
    public function test_endpoint_returns_complete_json_structure(): void
    {
        [$project, $instrumen] = $this->createBaseProject();
        $indA = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.01', 50.0);
        $indD = $this->createIndikatorWithRubriks($instrumen, 'D', 'D.1', 'IND-D.01', 50.0);

        $rubrikA = Rubrik::where('id_indikator', $indA->id)->where('skor', 4)->first();
        $rubrikD = Rubrik::where('id_indikator', $indD->id)->where('skor', 4)->first();

        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $indA->id, 'id_rubrik' => $rubrikA->id]);
        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $indD->id, 'id_rubrik' => $rubrikD->id]);

        $token = $this->generateToken('ADMINISTRATOR');
        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/scoring-result");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Hasil simulasi akreditasi berhasil dihitung',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'project_id',
                    'nama_project',
                    'total_na',
                    'predikat',
                    'skor_per_subkriteria' => [
                        '*' => [
                            'id_subkriteria',
                            'kode_subkriteria',
                            'nama_subkriteria',
                            'total_skor_terbobot',
                            'jumlah_indikator',
                            'jumlah_dinilai',
                        ],
                    ],
                    'is_simulated',
                    'minimum_not_met',
                    'detail_simulasi',
                ],
            ])
            ->assertJsonPath('data.total_na', 400)
            ->assertJsonPath('data.predikat', ScoringCalculationService::PREDIKAT_UNGGUL)
            ->assertJsonPath('data.is_simulated', false)
            ->assertJsonPath('data.minimum_not_met', false);
    }

    /**
     * Test 3: is_simulated bernilai true ketika ada indikator non-data (pajangan) yang belum dinilai.
     */
    public function test_is_simulated_true_when_non_data_indicator_unassessed(): void
    {
        [$project, $instrumen] = $this->createBaseProject();
        // Buat indikator E.1.1 (kode non-data) tanpa penilaian
        $this->createIndikatorWithRubriks($instrumen, 'E', 'E.1', 'E.1.1', 10.0);

        $token = $this->generateToken('KAPRODI');
        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/scoring-result");

        $response->assertStatus(200)
            ->assertJsonPath('data.is_simulated', true)
            ->assertJsonPath('data.detail_simulasi.0.kode_indikator', 'E.1.1')
            ->assertJsonPath('data.detail_simulasi.0.skor_default', 3);

        // Skor 10.0 * 3 = 30.0
        $this->assertEquals(30.0, (float) $response->json('data.total_na'));
    }

    /**
     * Test 4: skor_per_subkriteria terkelompok dan terhitung dengan benar per subkriteria.
     */
    public function test_skor_per_subkriteria_grouping_and_calculation(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        // Subkriteria A.1: 2 indikator
        $indA1 = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1.1', 10.0);
        $indA2 = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1.2', 10.0);

        // Subkriteria B.1: 1 indikator
        $indB1 = $this->createIndikatorWithRubriks($instrumen, 'B', 'B.1', 'IND-B.1.1', 20.0);

        // Nilai indA1 (skor 4) -> terbobot = 40.0; indA2 tidak dinilai (skor 0)
        $rubrikA1 = Rubrik::where('id_indikator', $indA1->id)->where('skor', 4)->first();
        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $indA1->id, 'id_rubrik' => $rubrikA1->id]);

        // Nilai indB1 (skor 3) -> terbobot = 60.0
        $rubrikB1 = Rubrik::where('id_indikator', $indB1->id)->where('skor', 3)->first();
        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $indB1->id, 'id_rubrik' => $rubrikB1->id]);

        $token = $this->generateToken('KAPRODI');
        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/scoring-result");

        $response->assertStatus(200);

        $subkriteria = collect($response->json('data.skor_per_subkriteria'))->keyBy('kode_subkriteria');

        // Validasi Subkriteria A.1
        $this->assertTrue($subkriteria->has('A.1'));
        $this->assertEquals(2, $subkriteria['A.1']['jumlah_indikator']);
        $this->assertEquals(1, $subkriteria['A.1']['jumlah_dinilai']);
        $this->assertEquals(40.0, (float) $subkriteria['A.1']['total_skor_terbobot']);

        // Validasi Subkriteria B.1
        $this->assertTrue($subkriteria->has('B.1'));
        $this->assertEquals(1, $subkriteria['B.1']['jumlah_indikator']);
        $this->assertEquals(1, $subkriteria['B.1']['jumlah_dinilai']);
        $this->assertEquals(60.0, (float) $subkriteria['B.1']['total_skor_terbobot']);
    }
}
