<?php

namespace Tests\Feature;

use App\Models\DataSarprasProdi;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\LembagaAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScoringSimulationTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected string $adminToken;

    protected string $kaprodiToken;

    protected string $dosenToken;

    protected ProjectAkreditasi $project;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();

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
            'sub' => '3',
            'nama' => 'Dosen TRK',
            'email' => 'dosen@polines.ac.id',
            'role' => 'DOSEN',
            'permissions' => ['read'],
        ]);

        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create([
            'nomor_versi' => '2.1',
            'id_lembaga' => $lembaga->id,
            'tanggal_berlaku' => '2026-01-25',
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Sarjana Terapan']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Program Studi']);

        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 101,
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi D4 TRK 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'On Progress',
        ]);

        DataSarprasProdi::create([
            'id_project' => $this->project->id,
            'kapasitas' => 120,
            'keterangan' => 'Laboratorium Komputasi Terapan TRK',
        ]);
    }

    /**
     * Uji endpoint simulasi skor menolak request tanpa token (401).
     */
    public function test_scoring_simulation_rejects_unauthenticated(): void
    {
        $this->getJson("/api/v1/projects/{$this->project->id}/scoring-simulation")
            ->assertStatus(401);
    }

    /**
     * Uji endpoint simulasi skor mengembalikan 404 jika project tidak ditemukan.
     */
    public function test_scoring_simulation_returns_404_when_project_not_found(): void
    {
        $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/projects/99999/scoring-simulation')
            ->assertStatus(404)
            ->assertJsonPath('success', false);
    }

    /**
     * Uji perhitungan RMD, PDS3, PJLK dengan data dosen memenuhi batas minimum (>= 5 dosen homebase).
     */
    public function test_scoring_simulation_calculates_scores_when_minimum_dosen_met(): void
    {
        // 6 dosen tetap homebase:
        // - 3 Doktor (S3) -> PDS3 = 3/6 = 50.0% -> Skor = 4.0
        // - 3 Lektor Kepala & Guru Besar -> PJLK = 3/6 = 50.0% -> Skor = 2.0 + 2.0*(50/70) = 3.43
        // - Jumlah mahasiswa = 120 (dari sarpras), DTH = 6 -> RMD = 120/6 = 20.0 -> Skor = 4.0
        // - Total NA = (4.0 + 4.0 + 3.43) / 3 = 3.81
        Http::fake([
            '*/dosen' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'nip_nidn' => '197501',
                        'nama_lengkap' => 'Prof. Dr. Andi Wijaya',
                        'gelar' => 'Doktor (S3)',
                        'jabatan_fungsional' => 'Guru Besar',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '197502',
                        'nama_lengkap' => 'Dr. Siti Rahmawati',
                        'gelar' => 'Doktor (S3)',
                        'jabatan_fungsional' => 'Lektor Kepala',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '197503',
                        'nama_lengkap' => 'Dr. Hendra Gunawan',
                        'gelar' => 'Doktor (S3)',
                        'jabatan_fungsional' => 'Lektor Kepala',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '197504',
                        'nama_lengkap' => 'Budi Santoso, M.Kom.',
                        'gelar' => 'Magister (S2)',
                        'jabatan_fungsional' => 'Lektor',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '197505',
                        'nama_lengkap' => 'Ahmad Fauzi, M.T.',
                        'gelar' => 'Magister (S2)',
                        'jabatan_fungsional' => 'Asisten Ahli',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '197506',
                        'nama_lengkap' => 'Rina Melati, M.Kom.',
                        'gelar' => 'Magister (S2)',
                        'jabatan_fungsional' => 'Tenaga Pengajar',
                        'status_homebase' => true,
                    ],
                    // 1 dosen non-homebase (tidak boleh dihitung)
                    [
                        'nip_nidn' => '197507',
                        'nama_lengkap' => 'Dewi Lestari, M.Kom.',
                        'gelar' => 'Magister (S2)',
                        'jabatan_fungsional' => 'Tenaga Pengajar',
                        'status_homebase' => false,
                    ],
                ],
            ], 200),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson("/api/v1/projects/{$this->project->id}/scoring-simulation");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_simulated', true)
            ->assertJsonPath('data.minimum_not_met', false)
            ->assertJsonPath('data.skor_per_subkriteria.rmd.nilai', 20)
            ->assertJsonPath('data.skor_per_subkriteria.rmd.skor', 4)
            ->assertJsonPath('data.skor_per_subkriteria.pds3.persentase', 50)
            ->assertJsonPath('data.skor_per_subkriteria.pds3.skor', 4)
            ->assertJsonPath('data.skor_per_subkriteria.pjlk.persentase', 50)
            ->assertJsonPath('data.skor_per_subkriteria.pjlk.skor', 3.43)
            ->assertJsonPath('data.total_na', 3.81);
    }

    /**
     * Uji flag minimum_not_met bernilai true saat dosen tetap homebase kurang dari 5 (< 5).
     */
    public function test_scoring_simulation_flags_minimum_not_met_when_homebase_under_5(): void
    {
        // Hanya 3 dosen tetap homebase (< 5)
        Http::fake([
            '*/dosen' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'nip_nidn' => '198001',
                        'nama_lengkap' => 'Dr. Andi',
                        'gelar' => 'Doktor (S3)',
                        'jabatan_fungsional' => 'Lektor Kepala',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '198002',
                        'nama_lengkap' => 'Budi, M.Kom.',
                        'gelar' => 'Magister (S2)',
                        'jabatan_fungsional' => 'Lektor',
                        'status_homebase' => true,
                    ],
                    [
                        'nip_nidn' => '198003',
                        'nama_lengkap' => 'Citra, M.Kom.',
                        'gelar' => 'Magister (S2)',
                        'jabatan_fungsional' => 'Asisten Ahli',
                        'status_homebase' => true,
                    ],
                ],
            ], 200),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->getJson("/api/v1/projects/{$this->project->id}/scoring-simulation");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.minimum_not_met', true)
            ->assertJsonPath('data.is_simulated', true);

        $this->assertNotNull($response->json('data.warning'));
        $this->assertStringContainsString('kurang dari 5', $response->json('data.warning'));
    }

    /**
     * Uji simulasi skor dengan parameter query jumlah_mahasiswa kustom.
     */
    public function test_scoring_simulation_supports_custom_jumlah_mahasiswa_query(): void
    {
        Http::fake([
            '*/dosen' => Http::response([
                'success' => true,
                'data' => [
                    ['nip_nidn' => '01', 'nama_lengkap' => 'D1', 'gelar' => 'S2', 'jabatan_fungsional' => 'AA', 'status_homebase' => true],
                    ['nip_nidn' => '02', 'nama_lengkap' => 'D2', 'gelar' => 'S2', 'jabatan_fungsional' => 'AA', 'status_homebase' => true],
                    ['nip_nidn' => '03', 'nama_lengkap' => 'D3', 'gelar' => 'S2', 'jabatan_fungsional' => 'AA', 'status_homebase' => true],
                    ['nip_nidn' => '04', 'nama_lengkap' => 'D4', 'gelar' => 'S2', 'jabatan_fungsional' => 'AA', 'status_homebase' => true],
                    ['nip_nidn' => '05', 'nama_lengkap' => 'D5', 'gelar' => 'S2', 'jabatan_fungsional' => 'AA', 'status_homebase' => true],
                ],
            ], 200),
        ]);

        // DTH = 5, jumlah_mahasiswa = 150 -> RMD = 150 / 5 = 30.0
        // Rumus RMD (25 < RMD <= 35): (35 - 30) / 2.5 = 2.0
        $response = $this->withHeader('Authorization', 'Bearer '.$this->dosenToken)
            ->getJson("/api/v1/projects/{$this->project->id}/scoring-simulation?jumlah_mahasiswa=150");

        $response->assertStatus(200)
            ->assertJsonPath('data.skor_per_subkriteria.rmd.nilai', 30)
            ->assertJsonPath('data.skor_per_subkriteria.rmd.skor', 2)
            ->assertJsonPath('data.minimum_not_met', false);
    }
}
