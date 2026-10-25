<?php

namespace Database\Seeders;

use App\Models\DataSaranaProdi;
use App\Models\DataSarprasProdi;
use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\JenisPembiayaan;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\Rubrik;
use App\Models\StandarMutu;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Lembaga Akreditasi & Versi Instrumen
        $lembaga = LembagaAkreditasi::firstOrCreate(
            ['nama_lembaga' => 'LAM-INFOKOM'],
            ['keterangan' => 'Lembaga Akreditasi Mandiri Informatika dan Komputer']
        );

        $versi = VersiInstrumen::firstOrCreate(
            ['nomor_versi' => 'v2024.1', 'id_lembaga' => $lembaga->id],
            [
                'tanggal_berlaku' => '2024-01-01',
                'status_aktif' => true,
            ]
        );

        // 2. Jenjang & Jenis Instrumen
        $jenjang = Jenjang::firstOrCreate(['nama_jenjang' => 'S1']);
        $jenisInstrumen = JenisInstrumen::firstOrCreate(['nama_jenis' => 'Akreditasi Program Studi (APS)']);

        // 3. Central Bridge: Instrumen (UUID) - Disesuaikan dengan migrasi
        $instrumen = Instrumen::firstOrCreate([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjang->id,
            'id_jenis_instrumen' => $jenisInstrumen->id,
        ]);

        // 4. Struktur Kriteria, Subkriteria, Indikator (Terkoneksi ke Instrumen)
        $kriteria = Kriteria::firstOrCreate(
            ['kode_kriteria' => 'K-1', 'id_instrumen' => $instrumen->id],
            ['nama_kriteria' => 'Visi, Misi, Tujuan, dan Strategi']
        );

        $subkriteria = Subkriteria::firstOrCreate(
            ['kode_subkriteria' => 'SK-1.1', 'id_kriteria' => $kriteria->id],
            ['nama_subkriteria' => 'Kejelasan dan Ketercapaian VMTS']
        );

        $indikator = Indikator::firstOrCreate(
            ['kode_indikator' => 'IND-1.1.1', 'id_subkriteria' => $subkriteria->id],
            [
                'deskripsi_indikator' => 'Kesesuaian Visi, Misi, Tujuan dan Strategi Program Studi dengan UPPS',
                'bobot'               => 3.50, // <-- Disesuaikan ke kolom bobot baru
            ]
        );

        // 5. Rubrik Skor
        Rubrik::firstOrCreate(
            ['id_indikator' => $indikator->id, 'skor' => 4],
            ['deskripsi_rubrik' => 'Sangat Baik: VMTS sangat jelas, realistis, dan terdokumentasi lengkap']
        );

        Rubrik::firstOrCreate(
            ['id_indikator' => $indikator->id, 'skor' => 3],
            ['deskripsi_rubrik' => 'Baik: VMTS jelas dan memiliki bukti sosialisasi berkala']
        );

        // 6. Standar Mutu & Jenis Pembiayaan (Pending Module)
        StandarMutu::firstOrCreate(
            ['kode_standar' => 'STD-VMTS-01'],
            [
                'nama_standar' => 'Standar Perumusan dan Penetapan VMTS',
                'deskripsi' => 'Pedoman perumusan dan evaluasi ketercapaian VMTS',
            ]
        );

        JenisPembiayaan::firstOrCreate(['nama_pembiayaan' => 'Biaya Operasional Pendidikan']);
        JenisPembiayaan::firstOrCreate(['nama_pembiayaan' => 'Biaya Penelitian dan Pengabdian']);

        // 7. Project Akreditasi (Gunakan ID Prodi Dummy tanpa Model Prodi)
        $project = ProjectAkreditasi::firstOrCreate(
            ['nama_project' => 'Akreditasi S1 Teknik Informatika 2026'],
            [
                'id_prodi' => 101, // Simulasi ID Prodi dari API Kelompok 2
                'id_versi_instrumen' => $versi->id,
                'id_jenjang' => $jenjang->id,
                'id_jenis_instrumen' => $jenisInstrumen->id,
                'tahun_target_submit' => 2026,
                'status_project' => 'Draft',
            ]
        );

        // 8. Jalankan Seeder Komprehensif LAM-INFOKOM Versi 2.1 (Terakreditasi Unggul)
        $this->call(LamInfokomSeeder::class);
    }
}
