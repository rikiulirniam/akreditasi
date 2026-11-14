<?php

namespace Tests\Feature;

use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\LembagaAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\VersiInstrumen;
use App\Services\External\ProdiApiService;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProjectLifecycleTest extends TestCase
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

        // Seed basic dependency for ProjectAkreditasi
        $lembaga = LembagaAkreditasi::create([
            'nama_lembaga' => 'LAM-INFOKOM',
        ]);

        $versi = VersiInstrumen::create([
            'nomor_versi' => '2.1',
            'id_lembaga' => $lembaga->id,
            'status_aktif' => true,
            'tanggal_berlaku' => '2026-01-25',
        ]);

        $jenjang = Jenjang::create([
            'nama_jenjang' => 'Sarjana Terapan',
        ]);

        $jenis = JenisInstrumen::create([
            'nama_jenis' => 'Akreditasi Program Studi',
        ]);

        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 1,
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi D4 TRK 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'On Progress',
        ]);
    }

    public function test_unauthenticated_requests_are_rejected(): void
    {
        $this->getJson('/api/v1/external/dosen')->assertStatus(401);
        $this->getJson('/api/v1/external/prodi/default')->assertStatus(401);
        $this->patchJson("/api/v1/projects/{$this->project->id}/status", [
            'status_project' => 'Pending',
        ])->assertStatus(401);
    }

    public function test_prodi_api_service_defaults_to_trk_when_external_api_unreachable(): void
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $service = new ProdiApiService;
        $defaultProdi = $service->getDefaultProdi();

        $this->assertEquals('TRK', $defaultProdi['kode_prodi']);
        $this->assertStringContainsString('Teknologi Rekayasa Komputer', $defaultProdi['nama_prodi']);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->dosenToken)
            ->getJson('/api/v1/external/prodi/default');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.kode_prodi', 'TRK');
    }

    public function test_external_dosen_endpoint_returns_fallback_when_server_unreachable(): void
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->dosenToken)
            ->getJson('/api/v1/external/dosen');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['nidn', 'nama', 'email', 'bidang_minat'],
                ],
            ]);
    }

    public function test_external_dosen_endpoint_maps_external_data_when_api_reachable(): void
    {
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'data' => [
                    [
                        'nidn' => '0099887766',
                        'nama' => 'Dr. Rina Kusuma, M.Kom.',
                        'email' => 'rina@polines.ac.id',
                        'bidang_minat' => 'Kecerdasan Buatan',
                    ],
                ],
            ], 200),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->getJson('/api/v1/external/dosen');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.0.nidn', '0099887766')
            ->assertJsonPath('data.0.bidang_minat', 'Kecerdasan Buatan');
    }

    public function test_rejects_selesai_status_when_sk_or_verification_date_is_missing(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->patchJson("/api/v1/projects/{$this->project->id}/status", [
                'status_project' => 'Selesai',
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);

        $this->assertDatabaseHas('project_akreditasi', [
            'id' => $this->project->id,
            'status_project' => 'On Progress',
        ]);
    }

    public function test_allows_selesai_status_when_sk_and_verification_date_are_provided(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->kaprodiToken)
            ->patchJson("/api/v1/projects/{$this->project->id}/status", [
                'status_project' => 'Selesai',
                'tanggal_verifikasi_akreditasi' => '2026-11-13',
                'nomor_sk_akreditasi' => 'SK/LAM-INFOKOM/2026/099',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status_project', 'Selesai')
            ->assertJsonPath('data.nomor_sk_akreditasi', 'SK/LAM-INFOKOM/2026/099');

        $this->assertDatabaseHas('project_akreditasi', [
            'id' => $this->project->id,
            'status_project' => 'Selesai',
            'nomor_sk_akreditasi' => 'SK/LAM-INFOKOM/2026/099',
        ]);
    }

    public function test_rejects_invalid_lifecycle_status_value(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->patchJson("/api/v1/projects/{$this->project->id}/status", [
                'status_project' => 'StatusTidakValid',
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }
}
