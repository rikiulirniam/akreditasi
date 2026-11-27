<?php

namespace Database\Seeders;

use App\Models\TemplateNarasiSubkriteria;
use Illuminate\Database\Seeder;

class NarasiTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'kategori_data' => 'dosen',
                'nama_template' => 'SDM dan DTPS',
                'template_tersedia' => 'Program Studi {nama_program_studi} didukung oleh {jumlah_dosen_homebase} DTPS, terdiri atas {jumlah_doktor} dosen berkualifikasi doktor dan {dosen_tersertifikasi} dosen tersertifikasi. Jumlah mahasiswa aktif sebanyak {jumlah_mahasiswa} orang dengan rasio mahasiswa terhadap dosen {rasio_mahasiswa_per_dosen}.',
                'template_tidak_tersedia' => 'Data SDM/DTPS untuk Program Studi {nama_program_studi} belum tersedia dari API. Data dosen, kualifikasi, sertifikasi, dan rasio mahasiswa-dosen perlu dilengkapi melalui dokumen resmi program studi.',
                'sumber_data' => ['tridharma:/api/dosen', 'akademik:/api/mahasiswa'],
                'field_mapping' => ['jumlah_dosen_homebase', 'jumlah_doktor', 'dosen_tersertifikasi', 'jumlah_mahasiswa', 'rasio_mahasiswa_per_dosen'],
            ],
            [
                'kategori_data' => 'mahasiswa',
                'nama_template' => 'Mahasiswa aktif',
                'template_tersedia' => 'Program Studi {nama_program_studi} memiliki {jumlah_mahasiswa} mahasiswa aktif pada periode evaluasi yang digunakan.',
                'template_tidak_tersedia' => 'Data mahasiswa aktif untuk Program Studi {nama_program_studi} belum tersedia dari API Akademik dan perlu dilengkapi dari rekapitulasi akademik resmi.',
                'sumber_data' => ['akademik:/api/mahasiswa'],
                'field_mapping' => ['jumlah_mahasiswa'],
            ],
            [
                'kategori_data' => 'penelitian',
                'nama_template' => 'Penelitian dan hibah',
                'template_tersedia' => 'Pada periode evaluasi, Program Studi {nama_program_studi} melaksanakan {penelitian_total_kegiatan} kegiatan penelitian. Sebanyak {penelitian_melibatkan_mahasiswa} kegiatan melibatkan mahasiswa, dengan {penelitian_hibah_nasional} hibah nasional, {penelitian_hibah_internal} hibah internal/lokal, dan {penelitian_hibah_internasional} hibah internasional.',
                'template_tidak_tersedia' => 'Data penelitian dan hibah untuk Program Studi {nama_program_studi} belum tersedia dari API Tridharma. Rekap kegiatan, sumber pendanaan, dan bukti hibah perlu dilengkapi secara manual.',
                'sumber_data' => ['tridharma:/api/kegiatan?id_jenis_kegiatan=1', 'tridharma:/api/luaran'],
                'field_mapping' => ['penelitian_total_kegiatan', 'penelitian_melibatkan_mahasiswa', 'penelitian_hibah_nasional', 'penelitian_hibah_internal', 'penelitian_hibah_internasional'],
            ],
            [
                'kategori_data' => 'pkm',
                'nama_template' => 'Pengabdian kepada Masyarakat',
                'template_tersedia' => 'Program Studi {nama_program_studi} melaksanakan {pkm_total_kegiatan} kegiatan pengabdian kepada masyarakat, dengan keterlibatan mahasiswa pada {pkm_melibatkan_mahasiswa} kegiatan. Pendanaan terdiri atas {pkm_hibah_nasional} hibah nasional, {pkm_hibah_internal} hibah internal/lokal, dan {pkm_hibah_internasional} hibah internasional.',
                'template_tidak_tersedia' => 'Data pengabdian kepada masyarakat dan hibah PkM untuk Program Studi {nama_program_studi} belum tersedia dari API Tridharma. Rekap kegiatan dan bukti pendanaan perlu dilengkapi secara manual.',
                'sumber_data' => ['tridharma:/api/kegiatan?id_jenis_kegiatan=2', 'tridharma:/api/luaran'],
                'field_mapping' => ['pkm_total_kegiatan', 'pkm_melibatkan_mahasiswa', 'pkm_hibah_nasional', 'pkm_hibah_internal', 'pkm_hibah_internasional'],
            ],
            [
                'kategori_data' => 'publikasi_hki',
                'nama_template' => 'Publikasi dan HKI',
                'template_tersedia' => 'Luaran ilmiah dan kekayaan intelektual Program Studi {nama_program_studi} meliputi {publikasi_internasional} publikasi internasional, {publikasi_nasional} publikasi nasional, {publikasi_prosiding} prosiding, {hki_paten} paten terdaftar, dan {hki_hak_cipta} hak cipta program komputer.',
                'template_tidak_tersedia' => 'Data publikasi dan HKI untuk Program Studi {nama_program_studi} belum tersedia dari API Tridharma. Daftar luaran dan dokumen HKI perlu dilengkapi dari sumber resmi.',
                'sumber_data' => ['tridharma:/api/luaran'],
                'field_mapping' => ['publikasi_internasional', 'publikasi_nasional', 'publikasi_prosiding', 'hki_paten', 'hki_hak_cipta'],
            ],
            [
                'kategori_data' => 'kerjasama',
                'nama_template' => 'Kerja sama penelitian dan pendidikan',
                'template_tersedia' => 'Program Studi {nama_program_studi} memiliki {kerjasama_aktif} kerja sama aktif dengan mitra DUDIKA yang dapat mendukung pendidikan, penelitian, dan pengabdian kepada masyarakat.',
                'template_tidak_tersedia' => 'Data kerja sama aktif untuk Program Studi {nama_program_studi} belum tersedia dari API Tridharma. Daftar kerja sama, ruang lingkup, dan dokumen perjanjian perlu dilengkapi secara manual.',
                'sumber_data' => ['tridharma:/api/kerja-sama'],
                'field_mapping' => ['kerjasama_aktif'],
            ],
            [
                'kategori_data' => 'tracer',
                'nama_template' => 'Lulusan dan tracer study',
                'template_tersedia' => 'Data tracer study Program Studi {nama_program_studi} memuat {lulusan_total} lulusan, dengan waktu tunggu kerja rata-rata {lulusan_waktu_tunggu} bulan dan kesesuaian bidang kerja sebesar {lulusan_kesesuaian}.',
                'template_tidak_tersedia' => 'Data lulusan dan tracer study untuk Program Studi {nama_program_studi} belum tersedia pada API Akademik. Data perlu dilengkapi melalui survei tracer study dan dokumen analisis program studi.',
                'sumber_data' => ['akademik:/api/lulusan', 'akademik:/api/tracer-study'],
                'field_mapping' => ['lulusan_total', 'lulusan_waktu_tunggu', 'lulusan_kesesuaian'],
            ],
            [
                'kategori_data' => 'umum',
                'nama_template' => 'Template indikator umum',
                'template_tersedia' => 'Data dukung untuk subkriteria {nama_subkriteria} pada Program Studi {nama_program_studi} tersedia dan perlu disesuaikan dengan bukti resmi indikator.',
                'template_tidak_tersedia' => 'Data dukung untuk subkriteria {nama_subkriteria} pada Program Studi {nama_program_studi} belum tersedia dari API. Indikator tetap ditampilkan, tetapi evidence dan data pendukung harus dilengkapi secara manual.',
                'sumber_data' => [],
                'field_mapping' => [],
            ],
        ];

        foreach ($templates as $template) {
            TemplateNarasiSubkriteria::updateOrCreate(
                ['id_subkriteria' => null, 'kategori_data' => $template['kategori_data']],
                $template + ['prioritas' => 100, 'is_active' => true]
            );
        }
    }
}
