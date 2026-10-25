<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\Rubrik;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstrumenDrilldownTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $jwtService = app(JwtService::class);
        $this->token = $jwtService->generateToken([
            'sub' => '1',
            'nama' => 'Admin Test',
            'email' => 'admin@polines.ac.id',
            'role' => 'ADMINISTRATOR',
            'permissions' => ['*'],
        ]);
    }

    public function test_get_instrumen_index_returns_instruments_with_jenis_and_jenjang_without_kriterias(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create(['nomor_versi' => '2.1', 'id_lembaga' => $lembaga->id, 'status_aktif' => true, 'tanggal_berlaku' => '2026-01-25']);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Diploma Tiga', 'kode_jenjang' => 'D3']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Pertama']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'A',
            'nama_kriteria' => 'Tata Pamong',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/instrumen');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'jenjang' => ['id', 'nama_jenjang'],
                        'jenis_instrumen' => ['id', 'nama_jenis'],
                        'kriterias_count',
                        'kriteria_count',
                    ],
                ],
            ])
            ->assertJsonPath('data.0.kriterias_count', 1)
            ->assertJsonPath('data.0.kriteria_count', 1);

        // Pastikan relasi kriterias tidak dimuat di index
        $this->assertArrayNotHasKey('kriterias', $response->json('data.0'));
    }

    public function test_get_instrumen_show_returns_all_kriteria_under_that_instrument(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create(['nomor_versi' => '2.1', 'id_lembaga' => $lembaga->id, 'status_aktif' => true, 'tanggal_berlaku' => '2026-01-25']);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Sarjana Terapan', 'kode_jenjang' => 'D4']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Reakreditasi Unggul']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteriaA = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'A',
            'nama_kriteria' => 'Kriteria Tata Pamong',
        ]);

        $kriteriaB = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'B',
            'nama_kriteria' => 'Kriteria Mahasiswa',
        ]);

        Subkriteria::create([
            'id_kriteria' => $kriteriaA->id,
            'kode_subkriteria' => 'A.1',
            'nama_subkriteria' => 'Subkriteria Tata Kelola',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/instrumen/'.$instrumen->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $instrumen->id)
            ->assertJsonPath('data.kriterias_count', 2)
            ->assertJsonPath('data.kriteria_count', 2)
            ->assertJsonCount(2, 'data.kriterias')
            ->assertJsonPath('data.kriterias.0.kode_kriteria', 'A')
            ->assertJsonPath('data.kriterias.0.subkriteria_count', 1)
            ->assertJsonPath('data.kriterias.1.kode_kriteria', 'B')
            ->assertJsonPath('data.kriterias.1.subkriteria_count', 0);
    }

    public function test_get_kriteria_index_and_show_returns_subkriteria_count(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create(['nomor_versi' => '2.1', 'id_lembaga' => $lembaga->id, 'status_aktif' => true, 'tanggal_berlaku' => '2026-01-25']);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Diploma Tiga', 'kode_jenjang' => 'D3']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Pertama']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'C',
            'nama_kriteria' => 'Kriteria Kurikulum',
        ]);

        $subkriteria = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'C.1',
            'nama_subkriteria' => 'Subkriteria Capaian Pembelajaran',
        ]);

        Indikator::create([
            'id_subkriteria' => $subkriteria->id,
            'kode_indikator' => 'IND-C.1.1',
            'deskripsi_indikator' => 'Kesesuaian CPL',
            'bobot' => 3.0,
        ]);

        // Test GET index
        $indexResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/kriteria?id_instrumen='.$instrumen->id);

        $indexResponse->assertStatus(200)
            ->assertJsonPath('data.0.subkriteria_count', 1);

        // Test GET show
        $showResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/kriteria/'.$kriteria->id);

        $showResponse->assertStatus(200)
            ->assertJsonPath('data.id', $kriteria->id)
            ->assertJsonPath('data.subkriteria_count', 1)
            ->assertJsonCount(1, 'data.subkriteria')
            ->assertJsonPath('data.subkriteria.0.kode_subkriteria', 'C.1')
            ->assertJsonPath('data.subkriteria.0.indikator_count', 1);
    }

    public function test_get_subkriteria_index_and_show_returns_indikator_count(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create(['nomor_versi' => '2.1', 'id_lembaga' => $lembaga->id, 'status_aktif' => true, 'tanggal_berlaku' => '2026-01-25']);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Diploma Tiga', 'kode_jenjang' => 'D3']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Pertama']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'C',
            'nama_kriteria' => 'Kriteria Kurikulum',
        ]);

        $subkriteria = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'C.1',
            'nama_subkriteria' => 'Subkriteria Capaian Pembelajaran',
        ]);

        $indikator = Indikator::create([
            'id_subkriteria' => $subkriteria->id,
            'kode_indikator' => 'IND-C.1.1',
            'deskripsi_indikator' => 'Struktur kurikulum selaras dengan CPL',
            'bobot' => 3.5,
        ]);

        Rubrik::create([
            'id_indikator' => $indikator->id,
            'skor' => 4,
            'deskripsi_rubrik' => 'Sangat Baik',
        ]);

        // Test GET index
        $indexResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/subkriteria?id_kriteria='.$kriteria->id);

        $indexResponse->assertStatus(200)
            ->assertJsonPath('data.0.indikator_count', 1);

        // Test GET show
        $showResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/subkriteria/'.$subkriteria->id);

        $showResponse->assertStatus(200)
            ->assertJsonPath('data.id', $subkriteria->id)
            ->assertJsonPath('data.indikator_count', 1)
            ->assertJsonCount(1, 'data.indikator')
            ->assertJsonPath('data.indikator.0.kode_indikator', 'IND-C.1.1')
            ->assertJsonPath('data.indikator.0.rubriks_count', 1);
    }

    public function test_get_indikator_index_and_show_returns_rubriks_count(): void
    {
        $lembaga = LembagaAkreditasi::create(['nama_lembaga' => 'LAM-INFOKOM']);
        $versi = VersiInstrumen::create(['nomor_versi' => '2.1', 'id_lembaga' => $lembaga->id, 'status_aktif' => true, 'tanggal_berlaku' => '2026-01-25']);
        $jenjang = Jenjang::create(['nama_jenjang' => 'Diploma Tiga', 'kode_jenjang' => 'D3']);
        $jenis = JenisInstrumen::create(['nama_jenis' => 'Akreditasi Pertama']);

        $instrumen = Instrumen::create([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
        ]);

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrumen->id,
            'kode_kriteria' => 'C',
            'nama_kriteria' => 'Kriteria Kurikulum',
        ]);

        $subkriteria = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => 'C.1',
            'nama_subkriteria' => 'Subkriteria Capaian Pembelajaran',
        ]);

        $indikator = Indikator::create([
            'id_subkriteria' => $subkriteria->id,
            'kode_indikator' => 'IND-C.1.1',
            'deskripsi_indikator' => 'Struktur kurikulum selaras dengan CPL',
            'bobot' => 3.5,
        ]);

        Rubrik::create([
            'id_indikator' => $indikator->id,
            'skor' => 4,
            'deskripsi_rubrik' => 'Sangat Baik (Unggul)',
        ]);

        // Test GET index
        $indexResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/indikator?id_subkriteria='.$subkriteria->id);

        $indexResponse->assertStatus(200)
            ->assertJsonPath('data.0.rubriks_count', 1)
            ->assertJsonPath('data.0.rubrik_count', 1);

        // Test GET show
        $showResponse = $this->withHeader('Authorization', 'Bearer '.$this->token)
            ->getJson('/api/v1/indikator/'.$indikator->id);

        $showResponse->assertStatus(200)
            ->assertJsonPath('data.id', $indikator->id)
            ->assertJsonPath('data.rubriks_count', 1)
            ->assertJsonPath('data.rubrik_count', 1)
            ->assertJsonCount(1, 'data.rubriks')
            ->assertJsonPath('data.rubriks.0.skor', 4);
    }
}
