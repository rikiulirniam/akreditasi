<?php

namespace Tests\Feature;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\NarasiSubkriteria;
use App\Models\ProjectAkreditasi;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use App\Services\External\DosenApiService;
use App\Services\External\ProdiApiService;
use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class NarasiTemplateTest extends TestCase
{
    use RefreshDatabase;

    private string $kaprodiToken;

    private string $dosenToken;

    private ProjectAkreditasi $project;

    private Subkriteria $subkriteria;

    /**
     * Menyiapkan token Kaprodi/Dosen serta struktur instrumen C.2.2.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->kaprodiToken = app(JwtService::class)->generateToken([
            'sub' => '20',
            'nama' => 'Kaprodi',
            'email' => 'kaprodi@example.test',
            'role' => 'KAPRODI',
            'permissions' => ['*'],
        ]);
        $this->dosenToken = app(JwtService::class)->generateToken([
            'sub' => '55',
            'nama' => 'Dosen PIC',
            'email' => 'dosen@example.test',
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
        $criterion = Kriteria::create([
            'id_instrumen' => $instrument->id,
            'kode_kriteria' => 'C.2',
            'nama_kriteria' => 'Relevansi Pendidikan',
        ]);
        $this->subkriteria = Subkriteria::create([
            'id_kriteria' => $criterion->id,
            'kode_subkriteria' => 'C.2.2',
            'nama_subkriteria' => 'Kualifikasi, Kecukupan, dan Kompetensi Dosen Tetap',
        ]);
        Indikator::create([
            'id_subkriteria' => $this->subkriteria->id,
            'kode_indikator' => 'IND-C.2.2.1',
            'deskripsi_indikator' => 'Rasio dosen terhadap mahasiswa',
            'bobot' => 4,
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
    }

    /**
     * Memasang mock data dosen dan mahasiswa agar test narasi deterministik.
     */
    private function mockAggregations(array $dosen, array $ratio): void
    {
        $dosenMock = Mockery::mock(DosenApiService::class);
        $dosenMock->shouldReceive('getAllDosen')->andReturn($dosen);
        $dosenMock->shouldReceive('getRasioDosenMahasiswa')->andReturn($ratio);
        $this->app->instance(DosenApiService::class, $dosenMock);

        $prodiMock = Mockery::mock(ProdiApiService::class);
        $prodiMock->shouldReceive('getProdiById')->andReturn([
            'id' => 101,
            'kode_prodi' => 'TRK',
            'nama_prodi' => 'Teknologi Rekayasa Komputer',
        ]);
        $this->app->instance(ProdiApiService::class, $prodiMock);
    }

    /**
     * Memastikan template mengisi placeholder dan status kelengkapan data.
     */
    public function test_template_fills_placeholders_and_reports_completion(): void
    {
        $this->mockAggregations([
            ['id_prodi' => 101, 'nama' => 'Dr. Satu', 'pendidikan_terakhir' => 'S3'],
            ['id_prodi' => 101, 'nama' => 'Dua', 'pendidikan_terakhir' => 'S2'],
            ['id_prodi' => 101, 'nama' => 'Tiga', 'pendidikan_terakhir' => 'S2'],
        ], ['jumlah_mahasiswa' => 60, 'rasio_mahasiswa_per_dosen' => 20]);

        $path = '/api/v1/projects/'.$this->project->id.'/subkriteria/'.$this->subkriteria->id.'/narasi-template';
        $this->withToken($this->kaprodiToken)
            ->getJson($path)
            ->assertOk()
            ->assertJsonPath('data.data_agregasi.jumlah_dosen_homebase', 3)
            ->assertJsonPath('data.data_agregasi.jumlah_doktor', 1)
            ->assertJsonPath('data.data_agregasi.jumlah_mahasiswa', 60)
            ->assertJsonPath('data.data_agregasi.rasio_mahasiswa_per_dosen', 20)
            ->assertJsonPath('data.data_lengkap', true)
            ->assertJsonFragment([
                'draft_narasi' => 'Dosen pada program studi berjumlah 3, dengan 1 dosen berkualifikasi doktor. Rasio dosen dan mahasiswa adalah 1:20, dengan jumlah mahasiswa sebesar 60.',
            ]);
    }

    /**
     * Memastikan template memiliki fallback aman saat data agregasi kosong.
     */
    public function test_template_handles_empty_aggregate_and_completion_note(): void
    {
        $this->mockAggregations([], []);

        $this->withToken($this->kaprodiToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/subkriteria/'.$this->subkriteria->id.'/narasi-template')
            ->assertOk()
            ->assertJsonPath('data.data_agregasi.jumlah_dosen_homebase', 0)
            ->assertJsonPath('data.data_lengkap', false)
            ->assertJsonFragment([
                'draft_narasi' => 'Dosen pada program studi berjumlah 0, dengan 0 dosen berkualifikasi doktor. Rasio dosen dan mahasiswa adalah 1:[belum tersedia], dengan jumlah mahasiswa sebesar [belum tersedia].',
            ]);
    }

    /**
     * Memastikan narasi tersimpan tidak mengubah snapshot agregasi aslinya.
     */
    public function test_kaprodi_can_save_narration_and_snapshot_is_not_changed(): void
    {
        $this->mockAggregations([
            ['id_prodi' => 101, 'nama' => 'Dr. Satu', 'pendidikan_terakhir' => 'S3'],
        ], ['jumlah_mahasiswa' => 20, 'rasio_mahasiswa_per_dosen' => 20]);

        $path = '/api/v1/projects/'.$this->project->id.'/subkriteria/'.$this->subkriteria->id.'/narasi';
        $this->withToken($this->kaprodiToken)
            ->putJson($path, ['narasi' => 'Narasi hasil edit Kaprodi yang lengkap dan masih dapat ditinjau.'])
            ->assertOk()
            ->assertJsonPath('data.narasi', 'Narasi hasil edit Kaprodi yang lengkap dan masih dapat ditinjau.')
            ->assertJsonPath('data.data_agregasi.jumlah_dosen_homebase', 1);

        $saved = NarasiSubkriteria::first();
        $this->assertSame(1, $saved->data_agregasi['jumlah_dosen_homebase']);

        $this->mockAggregations([
            ['id_prodi' => 101, 'nama' => 'Dr. Baru', 'pendidikan_terakhir' => 'S3'],
            ['id_prodi' => 101, 'nama' => 'Dosen Dua', 'pendidikan_terakhir' => 'S2'],
        ], ['jumlah_mahasiswa' => 40, 'rasio_mahasiswa_per_dosen' => 20]);

        $this->withToken($this->kaprodiToken)
            ->getJson('/api/v1/projects/'.$this->project->id.'/subkriteria/'.$this->subkriteria->id.'/narasi-template')
            ->assertOk()
            ->assertJsonPath('data.narasi_tersimpan', 'Narasi hasil edit Kaprodi yang lengkap dan masih dapat ditinjau.')
            ->assertJsonPath('data.data_agregasi.jumlah_dosen_homebase', 2);

        $saved->refresh();
        $this->assertSame(1, $saved->data_agregasi['jumlah_dosen_homebase']);
    }

    /**
     * Memastikan validasi narasi dan pembatasan role/penugasan dosen berjalan.
     */
    public function test_narration_validation_and_project_authorization(): void
    {
        $this->mockAggregations([], []);

        $path = '/api/v1/projects/'.$this->project->id.'/subkriteria/'.$this->subkriteria->id.'/narasi';
        $this->withToken($this->kaprodiToken)
            ->putJson($path, [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['narasi']);

        $this->withToken($this->dosenToken)
            ->putJson($path, ['narasi' => 'Narasi dosen yang belum ditugaskan sebagai PIC.'])
            ->assertForbidden();
    }
}
