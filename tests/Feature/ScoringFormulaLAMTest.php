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

class ScoringFormulaLAMTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwtService = app(JwtService::class);
    }

    /**
     * Helper untuk membuat JWT token pengujian berdasarkan role.
     */
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

    /**
     * Helper untuk membuat struktur awal instrumen dan project akreditasi.
     *
     * @return array{0: ProjectAkreditasi, 1: Instrumen}
     */
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

    /**
     * Helper untuk membuat kriteria, subkriteria, indikator, dan rubrik skor (1-4).
     */
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
     * Uji Kasus 1: Tepat 53 indikator dengan total bobot 100 dan semua skor 4 menghasilkan Total Skor 400 & Terakreditasi Unggul.
     */
    public function test_53_indicators_with_100_total_weight_all_score_4_yields_400_and_unggul(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        // Susun 53 indikator: 47 indikator bobot 2.0 (94.0) + 6 indikator bobot 1.0 (6.0) = 100.0 bobot total
        $allIndikators = [];

        // 46 indikator pada Kriteria A-C (bobot 2.0)
        for ($i = 1; $i <= 46; $i++) {
            $allIndikators[] = $this->createIndikatorWithRubriks(
                $instrumen,
                'A',
                'A.1',
                sprintf('IND-A.%02d', $i),
                2.00
            );
        }

        // 6 indikator pada Kriteria B (bobot 1.0)
        for ($i = 1; $i <= 6; $i++) {
            $allIndikators[] = $this->createIndikatorWithRubriks(
                $instrumen,
                'B',
                'B.1',
                sprintf('IND-B.%02d', $i),
                1.00
            );
        }

        // 1 indikator pada Kriteria D (bobot 2.0) -> Total indikator = 46 + 6 + 1 = 53 indikator
        $indikatorD = $this->createIndikatorWithRubriks(
            $instrumen,
            'D',
            'D.1',
            'IND-D.01',
            2.00
        );
        $allIndikators[] = $indikatorD;

        $this->assertCount(53, $allIndikators);
        $totalBobot = array_sum(array_map(fn ($i) => (float) $i->bobot, $allIndikators));
        $this->assertEquals(100.00, $totalBobot);

        // Berikan semua skor 4 pada seluruh 53 indikator
        foreach ($allIndikators as $ind) {
            $rubrik4 = Rubrik::where('id_indikator', $ind->id)->where('skor', 4)->first();
            SelfAssessment::create([
                'id_project' => $project->id,
                'id_indikator' => $ind->id,
                'id_rubrik' => $rubrik4->id,
                'skor_terbobot' => round($ind->bobot * 4, 2),
                'catatan_reviewer' => 'Sangat memuaskan',
            ]);
        }

        $token = $this->generateToken('ADMINISTRATOR');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200)
            ->assertJsonPath('data.total_skor', 400)
            ->assertJsonPath('data.predikat', ScoringCalculationService::PREDIKAT_UNGGUL)
            ->assertJsonPath('data.threshold_kriteria_d.terpenuhi', true)
            ->assertJsonPath('data.jumlah_total', 53)
            ->assertJsonPath('data.jumlah_dinilai', 53)
            ->assertJsonPath('data.jumlah_belum_dinilai', 0)
            ->assertJsonPath('data.persentase_kelengkapan', 100);

        $this->assertEmpty($response->json('data.butir_di_bawah_target'));
    }

    /**
     * Uji Kasus 2: Skor >= 361 tapi Threshold Kriteria D gagal (skor < 3) diturunkan ke "Terakreditasi Baik Sekali".
     */
    public function test_score_ge_361_with_failed_threshold_d_drops_to_baik_sekali(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        // 1 Indikator Kriteria A (bobot 95.0) dengan skor 4 -> skor = 380.0
        $indA = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1', 95.00);
        $rubrikA4 = Rubrik::where('id_indikator', $indA->id)->where('skor', 4)->first();
        SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $indA->id,
            'id_rubrik' => $rubrikA4->id,
        ]);

        // 1 Indikator Kriteria D (bobot 5.0) dengan skor 2 (gagal threshold D, karena butuh >= 3)
        $indD = $this->createIndikatorWithRubriks($instrumen, 'D', 'D.1', 'IND-D.1', 5.00);
        $rubrikD2 = Rubrik::where('id_indikator', $indD->id)->where('skor', 2)->first();
        SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $indD->id,
            'id_rubrik' => $rubrikD2->id,
        ]);

        // Total skor = (95 * 4) + (5 * 2) = 380 + 10 = 390.0 (melebihi 361)
        $token = $this->generateToken('REVIEWER');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200)
            ->assertJsonPath('data.total_skor', 390)
            ->assertJsonPath('data.threshold_kriteria_d.terpenuhi', false)
            ->assertJsonPath('data.predikat', ScoringCalculationService::PREDIKAT_BAIK_SEKALI);
    }

    /**
     * Uji Kasus 3: Batas predikat 301.0 - 360.0 menghasilkan "Terakreditasi Baik Sekali".
     */
    public function test_score_between_301_and_360_yields_baik_sekali(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        // Bobot 100 dengan skor 3.2 (misal 80 bobot skor 3 = 240, 20 bobot skor 4 = 80 -> total = 320)
        $ind1 = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1', 80.00);
        $ind2 = $this->createIndikatorWithRubriks($instrumen, 'D', 'D.1', 'IND-D.1', 20.00);

        $rubrik1 = Rubrik::where('id_indikator', $ind1->id)->where('skor', 3)->first();
        $rubrik2 = Rubrik::where('id_indikator', $ind2->id)->where('skor', 4)->first();

        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $ind1->id, 'id_rubrik' => $rubrik1->id]);
        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $ind2->id, 'id_rubrik' => $rubrik2->id]);

        $token = $this->generateToken('KAPRODI');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200)
            ->assertJsonPath('data.total_skor', 320)
            ->assertJsonPath('data.predikat', ScoringCalculationService::PREDIKAT_BAIK_SEKALI);
    }

    /**
     * Uji Kasus 4: Batas predikat 200.0 - 300.0 menghasilkan "Terakreditasi Baik".
     */
    public function test_score_between_200_and_300_yields_baik(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        $ind = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1', 80.00);
        $rubrik = Rubrik::where('id_indikator', $ind->id)->where('skor', 3)->first(); // 80 * 3 = 240.0
        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $ind->id, 'id_rubrik' => $rubrik->id]);

        $token = $this->generateToken('DOSEN');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200)
            ->assertJsonPath('data.total_skor', 240)
            ->assertJsonPath('data.predikat', ScoringCalculationService::PREDIKAT_BAIK);
    }

    /**
     * Uji Kasus 5: Batas predikat < 200.0 menghasilkan "Tidak Terakreditasi".
     */
    public function test_score_below_200_yields_tidak_terakreditasi(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        $ind = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1', 50.00);
        $rubrik = Rubrik::where('id_indikator', $ind->id)->where('skor', 3)->first(); // 50 * 3 = 150.0
        SelfAssessment::create(['id_project' => $project->id, 'id_indikator' => $ind->id, 'id_rubrik' => $rubrik->id]);

        $token = $this->generateToken('ADMINISTRATOR');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200)
            ->assertJsonPath('data.total_skor', 150)
            ->assertJsonPath('data.predikat', ScoringCalculationService::PREDIKAT_TIDAK_TERAKREDITASI);
    }

    /**
     * Uji Kasus 6: Butir belum dinilai dihitung 0 pada total dan TIDAK masuk daftar butir di bawah target.
     */
    public function test_unassessed_items_counted_as_zero_and_not_in_under_target_list(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        $indDinilai = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1', 10.00);
        $indBelumDinilai = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.2', 20.00);

        $rubrik3 = Rubrik::where('id_indikator', $indDinilai->id)->where('skor', 3)->first();
        SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $indDinilai->id,
            'id_rubrik' => $rubrik3->id,
        ]);

        $token = $this->generateToken('ADMINISTRATOR');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200)
            ->assertJsonPath('data.total_skor', 30) // 10 * 3 = 30.0; butir belum dinilai = 0.0
            ->assertJsonPath('data.jumlah_total', 2)
            ->assertJsonPath('data.jumlah_dinilai', 1)
            ->assertJsonPath('data.jumlah_belum_dinilai', 1)
            ->assertJsonPath('data.butir_di_bawah_target', []); // butir belum dinilai TIDAK boleh masuk ke list ini
    }

    /**
     * Uji Kasus 7: Butir yang dinilai dengan skor <= 2 masuk ke dalam daftar butir di bawah target.
     */
    public function test_items_with_score_le_2_included_in_under_target_list(): void
    {
        [$project, $instrumen] = $this->createBaseProject();

        $indRendah = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-RENDAH', 5.00);
        $indTinggi = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-TINGGI', 5.00);

        $rubrik2 = Rubrik::where('id_indikator', $indRendah->id)->where('skor', 2)->first();
        $rubrik4 = Rubrik::where('id_indikator', $indTinggi->id)->where('skor', 4)->first();

        SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $indRendah->id,
            'id_rubrik' => $rubrik2->id,
            'catatan_reviewer' => 'Dokumen belum lengkap',
        ]);

        SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $indTinggi->id,
            'id_rubrik' => $rubrik4->id,
        ]);

        $token = $this->generateToken('ADMINISTRATOR');

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/projects/{$project->id}/review-summary");

        $response->assertStatus(200);

        $underTarget = $response->json('data.butir_di_bawah_target');
        $this->assertCount(1, $underTarget);
        $this->assertEquals('IND-RENDAH', $underTarget[0]['kode_indikator']);
        $this->assertEquals(2, $underTarget[0]['skor_rubrik']);
        $this->assertEquals('Dokumen belum lengkap', $underTarget[0]['catatan_reviewer']);
    }

    /**
     * Uji Kasus 8: Endpoint PUT /api/v1/self-assessment/{id}/penjelasan-prodi hanya dapat diakses Kaprodi dan Administrator.
     */
    public function test_penjelasan_prodi_endpoint_authorization_and_update(): void
    {
        [$project, $instrumen] = $this->createBaseProject();
        $ind = $this->createIndikatorWithRubriks($instrumen, 'A', 'A.1', 'IND-A.1', 5.00);
        $rubrik2 = Rubrik::where('id_indikator', $ind->id)->where('skor', 2)->first();

        $assessment = SelfAssessment::create([
            'id_project' => $project->id,
            'id_indikator' => $ind->id,
            'id_rubrik' => $rubrik2->id,
            'catatan_reviewer' => 'Perlu bukti tambahan kerjasama DUDI.',
        ]);

        $kaprodiToken = $this->generateToken('KAPRODI');
        $reviewerToken = $this->generateToken('REVIEWER');
        $adminToken = $this->generateToken('ADMINISTRATOR');

        // 1. Role REVIEWER ditolak (403 Forbidden)
        $this->withHeader('Authorization', 'Bearer '.$reviewerToken)
            ->putJson("/api/v1/self-assessment/{$assessment->id}/penjelasan-prodi", [
                'tanggapan_kaprodi' => 'Tanggapan reviewer tidak diizinkan',
            ])
            ->assertStatus(403);

        // 2. Role KAPRODI berhasil memperbarui tanggapan (200 OK)
        $responseKaprodi = $this->withHeader('Authorization', 'Bearer '.$kaprodiToken)
            ->putJson("/api/v1/self-assessment/{$assessment->id}/penjelasan-prodi", [
                'tanggapan_kaprodi' => 'Bukti MoA dan dokumentasi magang terlampir pada Google Drive prodi.',
            ]);

        $responseKaprodi->assertStatus(200)
            ->assertJsonPath('data.tanggapan_kaprodi', 'Bukti MoA dan dokumentasi magang terlampir pada Google Drive prodi.');

        $this->assertDatabaseHas('self_assessment', [
            'id' => $assessment->id,
            'tanggapan_kaprodi' => 'Bukti MoA dan dokumentasi magang terlampir pada Google Drive prodi.',
        ]);

        // 3. Role ADMINISTRATOR juga berhasil mengupdate tanggapan prodi
        $this->withHeader('Authorization', 'Bearer '.$adminToken)
            ->putJson("/api/v1/self-assessment/{$assessment->id}/penjelasan-prodi", [
                'tanggapan_kaprodi' => 'Update resmi dari admin/kaprodi.',
            ])
            ->assertStatus(200)
            ->assertJsonPath('data.tanggapan_kaprodi', 'Update resmi dari admin/kaprodi.');
    }

    /**
     * Uji Kasus 9: storeOrUpdate() di SelfAssessmentController menghitung skor terbobot otomatis melalui ScoringCalculationService.
     */
    public function test_store_or_update_calculates_skor_terbobot_via_service(): void
    {
        [$project, $instrumen] = $this->createBaseProject();
        $ind = $this->createIndikatorWithRubriks($instrumen, 'B', 'B.1', 'IND-B.1', 3.50);
        $rubrik3 = Rubrik::where('id_indikator', $ind->id)->where('skor', 3)->first();

        $token = $this->generateToken('REVIEWER');

        // Submit assessment: skor terbobot otomatis = 3.50 * 3 = 10.50
        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/self-assessment', [
                'id_project' => $project->id,
                'id_indikator' => $ind->id,
                'id_rubrik' => $rubrik3->id,
                'catatan_reviewer' => 'Pelaksanaan PPEPP sudah terdokumentasi dengan baik.',
                'reviewer_id' => 10,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.skor_terbobot', '10.50')
            ->assertJsonPath('data.id_rubrik', $rubrik3->id);

        $this->assertDatabaseHas('self_assessment', [
            'id_project' => $project->id,
            'id_indikator' => $ind->id,
            'id_rubrik' => $rubrik3->id,
            'skor_terbobot' => 10.50,
        ]);
    }

    /**
     * Uji Kasus 10: Endpoint GET /api/v1/projects/{id}/review-summary dapat diakses seluruh role resmi dan menolak unauthenticated.
     */
    public function test_review_summary_accessible_by_all_authenticated_roles_and_rejects_unauthenticated(): void
    {
        [$project] = $this->createBaseProject();

        // 1. Tanpa token otentikasi -> 401 Unauthenticated
        $this->getJson("/api/v1/projects/{$project->id}/review-summary")
            ->assertStatus(401);

        // 2. Seluruh role resmi (ADMINISTRATOR, KAPRODI, REVIEWER, DOSEN) dapat mengakses (200 OK)
        foreach (['ADMINISTRATOR', 'KAPRODI', 'REVIEWER', 'DOSEN'] as $role) {
            $token = $this->generateToken($role);

            $this->withHeader('Authorization', 'Bearer '.$token)
                ->getJson("/api/v1/projects/{$project->id}/review-summary")
                ->assertStatus(200)
                ->assertJsonPath('success', true);
        }
    }
}
