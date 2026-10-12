<?php

namespace Database\Seeders;

use App\Models\Bobot;
use App\Models\Indikator;
use App\Models\JenisBukti;
use App\Models\JenisInstrumen;
use App\Models\JenisPembiayaan;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\Prodi;
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
        // 1. Data Master Prodi
        $prodi = Prodi::firstOrCreate(
            ['kode_prodi' => 'IF-S1'],
            [
                'id_upps' => null,
                'nama_prodi' => 'Teknik Informatika (S1)',
                'akreditasi' => 'Unggul',
            ]
        );

        // 2. Lembaga Akreditasi & Versi Instrumen
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

        // 3. Jenjang & Jenis Instrumen
        $jenjang = Jenjang::firstOrCreate(['nama_jenjang' => 'S1']);
        $jenisInstrumen = JenisInstrumen::firstOrCreate(['nama_jenis' => 'Akreditasi Program Studi (APS)']);

        // 4. Struktur Kriteria, Subkriteria, Indikator
        $kriteria = Kriteria::firstOrCreate(
            ['kode_kriteria' => 'K-1', 'id_versi_instrumen' => $versi->id],
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
                'parameter_penilaian' => 'Dokumen VMTS, sosialisasi, dan ketercapaian target jangka panjang',
            ]
        );

        // 5. Rubrik Skor & Bobot
        Rubrik::firstOrCreate(
            ['id_indikator' => $indikator->id, 'skor' => 4],
            ['deskripsi_rubrik' => 'Sangat Baik: VMTS sangat jelas, realistis, dan terdokumentasi lengkap']
        );

        Rubrik::firstOrCreate(
            ['id_indikator' => $indikator->id, 'skor' => 3],
            ['deskripsi_rubrik' => 'Baik: VMTS jelas dan memiliki bukti sosialisasi berkala']
        );

        Bobot::firstOrCreate(
            [
                'id_indikator' => $indikator->id,
                'id_jenis_instrumen' => $jenisInstrumen->id,
                'id_jenjang' => $jenjang->id,
            ],
            ['nilai_bobot' => 3.50]
        );

        // 6. Standar Mutu, Jenis Bukti, & Jenis Pembiayaan
        StandarMutu::firstOrCreate(
            ['kode_standar' => 'STD-VMTS-01'],
            [
                'nama_standar' => 'Standar Perumusan dan Penetapan VMTS',
                'deskripsi' => 'Pedoman perumusan dan evaluasi ketercapaian VMTS',
            ]
        );

        JenisBukti::firstOrCreate(['nama_jenis_bukti' => 'Surat Keputusan (SK)']);
        JenisBukti::firstOrCreate(['nama_jenis_bukti' => 'Laporan Evaluasi Diri (LED)']);

        JenisPembiayaan::firstOrCreate(['nama_pembiayaan' => 'Biaya Operasional Pendidikan']);
        JenisPembiayaan::firstOrCreate(['nama_pembiayaan' => 'Biaya Penelitian dan Pengabdian']);
    }
}
