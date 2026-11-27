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
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class Pengembang2AiniTest extends TestCase
{
    use RefreshDatabase;

    private string $adminToken;

    private string $kaprodiToken;

    private string $dosenPicToken;

    private string $dosenNonPicToken;

    private ProjectAkreditasi $project;

    private Subkriteria $subkriteriaDosen;

    private Subkriteria $subkriteriaTracer;

    private Indikator $indikatorDosen;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake(['*' => Http::response([], 503)]);

        $jwt = app(JwtService::class);

        $this->adminToken = $jwt->generateToken([
            'sub' => '1',
            'nama' => 'Administrator',
            'email' => 'admin@polines.ac.id',
            'role' => 'ADMINISTRATOR',
            'permissions' => ['*'],
        ]);

        $this->kaprodiToken = $jwt->generateToken([
            'sub' => '20',
            'nama' => 'Dr. Kaprodi TRK',
            'email' => 'kaprodi@polines.ac.id',
            'role' => 'KAPRODI',
            'permissions' => ['*'],
        ]);

        $this->dosenPicToken = $jwt->generateToken([
            'sub' => '55',
            'nama' => 'Dr. Eng. Riki Ulir, M.T.',
            'email' => 'riki.ulir@polines.ac.id',
            'role' => 'DOSEN',
            'permissions' => ['*'],
        ]);

        $this->dosenNonPicToken = $jwt->generateToken([
            'sub' => '99',
            'nama' => 'Dosen Luar Tim',
            'email' => 'dosen.luar@polines.ac.id',
            'role' => 'DOSEN',
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

        $kriteria = Kriteria::create([
            'id_instrumen' => $instrument->id,
            'kode_kriteria' => 'C.2',
            'nama_kriteria' => 'Kriteria dan Indikator',
        ]);

        $this->subkriteriaDosen = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => '2.2',
            'nama_subkriteria' => 'Dosen dan Tenaga Kependidikan',
        ]);

        $this->subkriteriaTracer = Subkriteria::create([
            'id_kriteria' => $kriteria->id,
            'kode_subkriteria' => '2.4',
            'nama_subkriteria' => 'Tracer Study dan Kepuasan Pengguna',
        ]);

        $this->indikatorDosen = Indikator::create([
            'id_subkriteria' => $this->subkriteriaDosen->id,
            'kode_indikator' => 'IND-2.2.1',
            'deskripsi_indikator' => 'Profil dan Rasio Dosen Tetap Program Studi (DTPS)',
            'bobot' => 4,
        ]);

        $this->project = ProjectAkreditasi::create([
            'id_prodi' => 101,
            'id_versi_instrumen' => $version->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenis->id,
            'nama_project' => 'Akreditasi Program Studi Sarjana Terapan TRK 2026',
            'tahun_target_submit' => 2026,
            'status_project' => 'On Progress',
        ]);

        // Assign Dosen PIC ke indikator dosen
        MappingTimAkreditasi::create([
            'id_project' => $this->project->id,
            'id_indikator' => $this->indikatorDosen->id,
            'id_user' => 55,
            'role' => 'PIC',
        ]);
    }

    /**
     * Test B1: Endpoint GET /api/v1/external/dosen
     */
    public function test_b1_get_dosen_dtps_profile_success(): void
    {
        $response = $this->withToken($this->kaprodiToken)
            ->getJson('/api/v1/external/dosen');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Data dosen DTPS berhasil diambil dari API Tridharma')
            ->assertJsonPath('data.total_dosen', 23)
            ->assertJsonPath('data.total_s3_doktor', 5)
            ->assertJsonPath('data.persentase_s3', '21.74%')
            ->assertJsonPath('data.jabatan_fungsional.guru_besar', 1)
            ->assertJsonPath('data.jabatan_fungsional.lektor_kepala', 6)
            ->assertJsonPath('data.jabatan_fungsional.lektor', 11)
            ->assertJsonPath('data.jabatan_fungsional.asisten_ahli', 5)
            ->assertJsonPath('data.dosen_tersertifikasi', 19)
            ->assertJsonCount(23, 'data.daftar_dosen')
            ->assertJsonPath('data.daftar_dosen.0.nidn', '0012058001')
            ->assertJsonPath('data.daftar_dosen.0.nama', 'Dr. Eng. Riki Ulir, M.T.')
            ->assertJsonPath('data.daftar_dosen.0.pendidikan_terakhir', 'S3')
            ->assertJsonPath('data.daftar_dosen.0.jabatan_akademik', 'Lektor Kepala')
            ->assertJsonPath('data.daftar_dosen.0.status_dosen', 'DTPS');
    }

    /**
     * Test B1 Unauthenticated: GET /api/v1/external/dosen requires token
     */
    public function test_b1_get_dosen_unauthenticated_fails(): void
    {
        $response = $this->getJson('/api/v1/external/dosen');
        $response->assertUnauthorized();
    }

    /**
     * Test B2: Endpoint GET /api/v1/external/tridharma-summary
     */
    public function test_b2_get_tridharma_summary_success(): void
    {
        $response = $this->withToken($this->kaprodiToken)
            ->getJson('/api/v1/external/tridharma-summary');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Ringkasan Tridharma berhasil diambil dari API Kelompok 2')
            ->assertJsonPath('data.penelitian.total_kegiatan', 42)
            ->assertJsonPath('data.penelitian.melibatkan_mahasiswa', 35)
            ->assertJsonPath('data.penelitian.hibah_nasional_bima', 8)
            ->assertJsonPath('data.penelitian.hibah_internal_polines', 26)
            ->assertJsonPath('data.penelitian.mandiri', 8)
            ->assertJsonPath('data.pkm.total_kegiatan', 28)
            ->assertJsonPath('data.pkm.melibatkan_mahasiswa', 24)
            ->assertJsonPath('data.pkm.hibah_pkm_nasional', 4)
            ->assertJsonPath('data.pkm.hibah_internal', 24)
            ->assertJsonPath('data.publikasi.jurnal_internasional_scopus', 18)
            ->assertJsonPath('data.publikasi.jurnal_nasional_sinta', 64)
            ->assertJsonPath('data.publikasi.prosiding_seminar_ieee', 32)
            ->assertJsonPath('data.publikasi.buku_isbn', 12)
            ->assertJsonPath('data.hki.paten_terdaftar', 3)
            ->assertJsonPath('data.hki.hak_cipta_program_komputer', 22)
            ->assertJsonPath('data.kerjasama_dudika_aktif', 15);
    }

    /**
     * Test B3: Endpoint GET /api/v1/projects/{id}/subkriteria/{subkriteria_id}/narasi-template (Subkriteria 2.2)
     */
    public function test_b3_generate_narasi_template_dosen_complete_data(): void
    {
        $url = "/api/v1/projects/{$this->project->id}/subkriteria/{$this->subkriteriaDosen->id}/narasi-template";

        $response = $this->withToken($this->kaprodiToken)
            ->getJson($url);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Template narasi subkriteria berhasil di-generate')
            ->assertJsonPath('data.kode_subkriteria', '2.2')
            ->assertJsonPath('data.status_ketersediaan_data', 'Tersedia Lengkap')
            ->assertJsonPath('data.variabel_pakem.NDTPS', 23)
            ->assertJsonPath('data.variabel_pakem.NDTPS_S3', 5)
            ->assertJsonPath('data.variabel_pakem.Persentase_S3', '21.74%')
            ->assertJsonPath('data.variabel_pakem.Rasio_Mhs_Dosen', '1:18.5');

        $this->assertStringContainsString('Teknologi Rekayasa Komputer (TRK)', $response->json('data.draf_narasi'));
        $this->assertStringContainsString('23 orang dosen tetap', $response->json('data.draf_narasi'));
    }

    /**
     * Test B3: Endpoint GET /api/v1/projects/{id}/subkriteria/{subkriteria_id}/narasi-template (Subkriteria 2.4 - Empty Data Graceful Fallback)
     */
    public function test_b3_generate_narasi_template_tracer_study_empty_data_fallback(): void
    {
        $url = "/api/v1/projects/{$this->project->id}/subkriteria/{$this->subkriteriaTracer->id}/narasi-template";

        $response = $this->withToken($this->kaprodiToken)
            ->getJson($url);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Template narasi dihasilkan dengan catatan data parsial')
            ->assertJsonPath('data.kode_subkriteria', '2.4')
            ->assertJsonPath('data.status_ketersediaan_data', 'Data tidak tersedia di API Akademik')
            ->assertJsonPath('data.variabel_pakem.Waktu_Tunggu_Bulan', '[Data Belum Tersedia]')
            ->assertJsonPath('data.variabel_pakem.Kesesuaian_Bidang_Kerja', '[Data Belum Tersedia]');

        $this->assertStringContainsString('saat ini belum terekam', $response->json('data.draf_narasi'));
    }

    /**
     * Test B4: Endpoint PUT /api/v1/projects/{id}/subkriteria/{subkriteria_id}/narasi (Kaprodi Success)
     */
    public function test_b4_kaprodi_can_update_narasi_successfully(): void
    {
        $url = "/api/v1/projects/{$this->project->id}/subkriteria/{$this->subkriteriaDosen->id}/narasi";

        $payload = [
            'narasi_disunting' => 'Program Studi Sarjana Terapan Teknologi Rekayasa Komputer memiliki 23 orang dosen tetap dengan kualifikasi terbaik.',
            'catatan_revisi' => 'Penyesuaian draft narasi rasio dosen pembimbing TA 2026',
        ];

        $response = $this->withToken($this->kaprodiToken)
            ->putJson($url, $payload);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Narasi subkriteria berhasil disimpan')
            ->assertJsonPath('data.narasi_final', $payload['narasi_disunting'])
            ->assertJsonPath('data.disunting_oleh', 'Dr. Kaprodi TRK')
            ->assertJsonPath('data.catatan_revisi', $payload['catatan_revisi']);
    }

    /**
     * Test B4: Endpoint PUT /api/v1/projects/{id}/subkriteria/{subkriteria_id}/narasi (Dosen PIC Success)
     */
    public function test_b4_dosen_pic_can_update_narasi_successfully(): void
    {
        $url = "/api/v1/projects/{$this->project->id}/subkriteria/{$this->subkriteriaDosen->id}/narasi";

        $payload = [
            'narasi_disunting' => 'Dosen PIC telah memvalidasi seluruh 23 dosen DTPS bersesuaian dengan portofolio akademik TRK.',
            'catatan_revisi' => 'Revisi oleh Dosen PIC setelah koordinasi internal',
        ];

        $response = $this->withToken($this->dosenPicToken)
            ->putJson($url, $payload);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.narasi_final', $payload['narasi_disunting'])
            ->assertJsonPath('data.disunting_oleh', 'Dr. Eng. Riki Ulir, M.T.')
            ->assertJsonPath('data.catatan_revisi', $payload['catatan_revisi']);
    }

    /**
     * Test B4: Dosen non-PIC dilarang menyimpan narasi (403 Forbidden)
     */
    public function test_b4_dosen_non_pic_forbidden(): void
    {
        $url = "/api/v1/projects/{$this->project->id}/subkriteria/{$this->subkriteriaDosen->id}/narasi";

        $payload = [
            'narasi_disunting' => 'Mencoba mengedit narasi tanpa assignment PIC/PJ yang sah.',
        ];

        $response = $this->withToken($this->dosenNonPicToken)
            ->putJson($url, $payload);

        $response->assertStatus(403);
    }

    /**
     * Test B4 Validation: Narasi minimal 20 karakter
     */
    public function test_b4_narasi_validation_minimum_length_fails(): void
    {
        $url = "/api/v1/projects/{$this->project->id}/subkriteria/{$this->subkriteriaDosen->id}/narasi";

        $payload = [
            'narasi_disunting' => 'Pendek sekali',
        ];

        $response = $this->withToken($this->kaprodiToken)
            ->putJson($url, $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['narasi_disunting']);
    }
}
