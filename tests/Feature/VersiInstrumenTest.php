<?php

namespace Tests\Feature;

use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VersiInstrumenTest extends TestCase
{
    use RefreshDatabase;

    protected string $adminToken;

    protected string $dosenToken;

    protected function setUp(): void
    {
        parent::setUp();

        $jwtService = app(JwtService::class);
        $this->adminToken = $jwtService->generateToken([
            'sub' => '1',
            'nama' => 'Admin User',
            'email' => 'admin@polines.ac.id',
            'role' => 'ADMINISTRATOR',
            'permissions' => ['*'],
        ]);

        $this->dosenToken = $jwtService->generateToken([
            'sub' => '2',
            'nama' => 'Dosen User',
            'email' => 'dosen@polines.ac.id',
            'role' => 'DOSEN',
            'permissions' => ['read'],
        ]);
    }

    public function test_get_versi_instrumen_index_returns_list_with_lembaga_and_kriteria(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create([
            'nomor_versi' => 'v2026.1',
            'id_lembaga' => $lembaga->id,
            'status_aktif' => true,
            'tanggal_berlaku' => '2026-01-01',
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Sarjana Terapan', 'kode_jenjang' => 'D4']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Program Studi']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'C.1',
            'nama_kriteria' => 'Visi Misi Tujuan',
        ]);

        Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'C.1.1',
            'nama_subkriteria' => 'Kejelasan Visi Misi',
        ]);

        // Akses via /master/versi-instrumen
        $response = $this->withHeader('Authorization', 'Bearer '.$this->dosenToken)
            ->getJson('/api/v1/master/versi-instrumen');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'nomor_versi',
                        'lembaga',
                        'instrumen',
                        'kriteria',
                    ],
                ],
            ]);

        // Akses via direct alias /versi-instrumen
        $responseAlias = $this->withHeader('Authorization', 'Bearer '.$this->dosenToken)
            ->getJson('/api/v1/versi-instrumen');

        $responseAlias->assertStatus(200)
            ->assertJsonPath('data.0.nomor_versi', 'v2026.1');
    }

    public function test_get_versi_instrumen_show_returns_detail_with_nested_kriteria(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'BAN-PT']);
        $versi = VersiInstrumen::create([
            'nomor_versi' => 'v9.0',
            'id_lembaga' => $lembaga->id,
            'status_aktif' => true,
            'tanggal_berlaku' => '2026-01-01',
        ]);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Magister Terapan', 'kode_jenjang' => 'S2']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Reakreditasi']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'K.1',
            'nama_kriteria' => 'Tata Kelola',
        ]);

        Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'K.1.1',
            'nama_subkriteria' => 'Kepemimpinan',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->dosenToken)
            ->getJson('/api/v1/master/versi-instrumen/'.$versi->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.nomor_versi', 'v9.0')
            ->assertJsonPath('data.lembaga.nama_lembaga', 'BAN-PT')
            ->assertJsonPath('data.kriteria.0.kode_kriteria', 'K.1')
            ->assertJsonPath('data.kriteria.0.subkriteria.0.kode_subkriteria', 'K.1.1');
    }

    public function test_admin_can_create_update_and_delete_versi_instrumen(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-TEKNIK']);

        // Create
        $createResponse = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->postJson('/api/v1/master/versi-instrumen', [
                'id_lembaga' => $lembaga->id,
                'nomor_versi' => 'v2026.2',
                'tanggal_berlaku' => '2026-03-01',
                'status_aktif' => true,
            ]);

        $createResponse->assertStatus(201)
            ->assertJsonPath('data.nomor_versi', 'v2026.2');

        $versiId = $createResponse->json('data.id');

        // Update
        $updateResponse = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->putJson('/api/v1/master/versi-instrumen/'.$versiId, [
                'nomor_versi' => 'v2026.2-rev',
            ]);

        $updateResponse->assertStatus(200)
            ->assertJsonPath('data.nomor_versi', 'v2026.2-rev');

        // Delete
        $deleteResponse = $this->withHeader('Authorization', 'Bearer '.$this->adminToken)
            ->deleteJson('/api/v1/master/versi-instrumen/'.$versiId);

        $deleteResponse->assertStatus(200);

        $this->assertDatabaseMissing('versi_instrumen', ['id' => $versiId]);
    }
}
