<?php

namespace Database\Seeders;

use App\Models\DataKeuanganProdi;
use App\Models\DataSaranaProdi;
use App\Models\DataSarprasProdi;
use App\Models\DataSpmiAudit;
use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\JenisInstrumen;
use App\Models\JenisPembiayaan;
use App\Models\Jenjang;
use App\Models\Kriteria;
use App\Models\LembagaAkreditasi;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\Rubrik;
use App\Models\SelfAssessment;
use App\Models\StandarMutu;
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LamInfokomSeeder extends Seeder
{
    /**
     * Run the database seeds for LAM-INFOKOM Versi 2.1 (Terakreditasi Unggul).
     */
    public function run(): void
    {
        // =========================================================================
        // 1. LEMBAGA AKREDITASI
        // =========================================================================
        $lembaga = LembagaAkreditasi::firstOrCreate(
            ['nama_lembaga' => 'LAM-INFOKOM'],
            ['keterangan' => 'Lembaga Akreditasi Mandiri Informatika dan Komputer']
        );

        // =========================================================================
        // 2. VERSI INSTRUMEN (2.1 - Diberlakukan 25 Januari 2026, Status Aktif)
        // =========================================================================
        $versi = VersiInstrumen::firstOrCreate(
            ['nomor_versi' => '2.1', 'id_lembaga' => $lembaga->id],
            [
                'tanggal_berlaku' => '2026-01-25',
                'status_aktif' => true,
            ]
        );

        // Pastikan status_aktif true jika sudah ada
        if (! $versi->status_aktif) {
            $versi->update(['status_aktif' => true, 'tanggal_berlaku' => '2026-01-25']);
        }

        // =========================================================================
        // 3. JENIS INSTRUMEN
        // =========================================================================
        $jenisUnggul = JenisInstrumen::firstOrCreate(
            ['nama_jenis' => 'Instrumen APS untuk Status Terakreditasi Unggul']
        );

        $jenisBiasa = JenisInstrumen::firstOrCreate(
            ['nama_jenis' => 'Instrumen APS untuk Status Terakreditasi']
        );

        // =========================================================================
        // 4. JENJANG PENDIDIKAN
        // =========================================================================
        $jenjangDiploma = Jenjang::firstOrCreate(['nama_jenjang' => 'Program Diploma']);
        $jenjangSarjanaTerapan = Jenjang::firstOrCreate(['nama_jenjang' => 'Sarjana Terapan']);

        // Tambahan jenjang umum agar master data lengkap
        Jenjang::firstOrCreate(['nama_jenjang' => 'Sarjana']);
        Jenjang::firstOrCreate(['nama_jenjang' => 'Magister Terapan']);
        Jenjang::firstOrCreate(['nama_jenjang' => 'Magister']);
        Jenjang::firstOrCreate(['nama_jenjang' => 'Doktor']);

        // =========================================================================
        // 5. BRIDGE INSTRUMEN (UUID)
        // =========================================================================
        $instrumenDiploma = Instrumen::firstOrCreate([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjangDiploma->id,
            'id_jenis_instrumen' => $jenisUnggul->id,
        ]);

        $instrumenSarjanaTerapan = Instrumen::firstOrCreate([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjangSarjanaTerapan->id,
            'id_jenis_instrumen' => $jenisUnggul->id,
        ]);

        // Daftar instrumen yang akan diisi kriteria dan indikator
        $targetInstrumens = [$instrumenDiploma, $instrumenSarjanaTerapan];

        // =========================================================================
        // 6. STRUKTUR KRITERIA, SUBKRITERIA, INDIKATOR, RUBRIK, DAN BOBOT
        // =========================================================================
        // Struktur Kriteria LAM-INFOKOM 2.1 Terakreditasi Unggul:
        // A, B, C1, C2, C3, C4, C5, C6, D
        $kriteriaData = [
            [
                'kode_kriteria' => 'A',
                'nama_kriteria' => 'Analisis Kondisi Eksternal',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'A.1',
                        'nama_subkriteria' => 'Analisis Lingkungan Makro dan Mikro',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-A.1.1',
                                'deskripsi_indikator' => 'Ketajaman analisis kondisi eksternal (analisis SWOT) dan relevansi dengan tren industri teknologi informasi dan komunikasi terkini.',
                                'parameter_penilaian' => 'Dokumen evaluasi diri yang memuat pemetaan peluang tantangan industri 4.0, kebutuhan talenta digital, dan keterkaitannya dengan keunggulan prodi.',
                                'bobot' => 2.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Analisis lingkungan makro dan mikro sangat tajam, komprehensif, berbasis data riil industri TIK, dan secara eksplisit menjadi rujukan strategis pengembangan kurikulum vokasi.',
                                    3 => 'Baik: Analisis lingkungan makro dan mikro komprehensif dan dijadikan dasar perumusan strategi prodi, didukung data pendukung yang relevan.',
                                    2 => 'Cukup: Analisis lingkungan eksternal ada namun bersifat deskriptif normatif dan belum terintegrasi utuh dalam strategi aksi prodi.',
                                    1 => 'Kurang: Tidak melakukan analisis lingkungan eksternal secara sistematis atau tidak ada dokumen pendukung yang sahih.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'B',
                'nama_kriteria' => 'Profil Unit Pengelola Program Studi (UPPS)',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'B.1',
                        'nama_subkriteria' => 'Tata Pamong, Kepemimpinan, dan Sistem Pengelolaan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-B.1.1',
                                'deskripsi_indikator' => 'Efektivitas sistem tata pamong dan kepemimpinan publik dalam mewujudkan tata kelola yang kredibel, transparan, akuntabel, bertanggung jawab, dan adil.',
                                'parameter_penilaian' => 'Struktur organisasi UPPS, SOP operasional tata pamong, laporan akuntabilitas kinerja instansi, serta bukti evaluasi kepemimpinan berkala.',
                                'bobot' => 3.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Struktur tata pamong sangat efektif, operasional berjalan transparan berbasis digital, kepemimpinan publik visioner, dan sistem pengelolaan berjalan tanpa deviasi.',
                                    3 => 'Baik: Struktur tata pamong efektif, kepemimpinan fungsional berjalan baik, memiliki SOP lengkap dan laporan kinerja tahunan yang akuntabel.',
                                    2 => 'Cukup: Tata kelola berjalan namun evaluasi berkala dan sistem penjaminan transparansi publik belum berjalan optimal.',
                                    1 => 'Kurang: Struktur organisasi tidak berfungsi efektif atau tidak memiliki bukti pedoman tata pamong tertulis.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'B.2',
                        'nama_subkriteria' => 'Kerjasama Strategis Tridharma Perguruan Tinggi',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-B.2.1',
                                'deskripsi_indikator' => 'Kuantitas, kualitas, relevansi, dan kepuasan kemitraan kerjasama Tridharma dengan industri TIK, institusi global, dan masyarakat.',
                                'parameter_penilaian' => 'MoU dan MoA aktif, bukti implementasi program magang industri bersertifikat, industrial teaching, dan hibah kemitraan.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memiliki jejaring kerjasama industri TIK bereputasi nasional dan internasional, 100% kerjasama memiliki implementasi riil (magang bersertifikat, kurikulum industri, riset bersama) dengan tingkat kepuasan mitra sangat tinggi.',
                                    3 => 'Baik: Kerjasama dengan industri dan instansi mitra berjalan aktif dengan bukti kegiatan Tridharma yang terdokumentasi rapi.',
                                    2 => 'Cukup: Kerjasama formal ada namun implementasi berkala belum optimal di tingkat program studi vokasi.',
                                    1 => 'Kurang: Tidak memiliki dokumen kerjasama aktif yang relevan dengan bidang keilmuan prodi.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'C.1',
                'nama_kriteria' => 'Budaya Mutu',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.1.1',
                        'nama_subkriteria' => 'Pelaksanaan Siklus PPEPP dan Penjaminan Mutu Internal',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.1.1.1',
                                'deskripsi_indikator' => 'Konsistensi dan efektivitas pelaksanaan siklus PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan) dalam penjaminan mutu program studi.',
                                'parameter_penilaian' => 'Ketersediaan dokumen standar mutu SPMI, laporan Audit Mutu Internal (AMI), bukti Rapat Tinjauan Manajemen (RTM), dan dokumen continuous improvement.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Siklus PPEPP berjalan secara konsisten, melembaga di seluruh unit prodi, didukung sistem audit digital, rekomendasi RTM 100% ditindaklanjuti, dan terjadi peningkatan standar mutu secara periodik.',
                                    3 => 'Baik: Siklus PPEPP terlaksana lengkap dengan laporan audit berkala dan dokumen tindak lanjut perbaikan.',
                                    2 => 'Cukup: Pelaksanaan SPMI baru sebatas tahap Penetapan dan Pelaksanaan, evaluasi/RTM belum dilakukan secara konsisten tahunan.',
                                    1 => 'Kurang: Tidak memiliki sistem penjaminan mutu internal atau siklus PPEPP tidak terlaksana.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.1.2',
                        'nama_subkriteria' => 'Umpan Balik dan Kepuasan Pemangku Kepentingan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.1.2.1',
                                'deskripsi_indikator' => 'Sistem pengukuran umpan balik berkala dan kepuasan mahasiswa, dosen, alumni, tenaga kependidikan, serta pengguna lulusan.',
                                'parameter_penilaian' => 'Instrumen survei kepuasan berkala berbasis web, analisis statistik kepuasan, dan publikasi laporan tindak lanjut perbaikan layanan mutu.',
                                'bobot' => 3.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Survei kepuasan dilakukan secara berkala dan menyeluruh dengan instrumen tervalidasi, tingkat kepuasan pemangku kepentingan > 85%, dan seluruh masukan ditindaklanjuti secara nyata.',
                                    3 => 'Baik: Survei kepuasan terlaksana teratur dan memiliki laporan tindak lanjut yang jelas.',
                                    2 => 'Cukup: Survei dilakukan berkala namun analisis dan tindak lanjut perbaikan belum terdokumentasi formal.',
                                    1 => 'Kurang: Tidak melakukan pengukuran kepuasan pemangku kepentingan secara valid.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'C.2',
                'nama_kriteria' => 'Relevansi Pendidikan',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.2.1',
                        'nama_subkriteria' => 'Kurikulum Berbasis Outcome (OBE) dan Pembelajaran Vokasi',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.2.1.1',
                                'deskripsi_indikator' => 'Relevansi kurikulum dengan KKNI, keselarasan CPL-CPMK dengan asosiasi profesi bidang Infokom, dan implementasi metode Project-Based Learning (PBL).',
                                'parameter_penilaian' => 'Buku kurikulum OBE, peta kurikulum, RPS berbasis proyek/kasus riil, portofolio hasil karya mahasiswa, dan keterlibatan praktisi industri dalam perancangan kurikulum.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Kurikulum OBE selaras penuh dengan standar KKNI dan pasar global, metode Project-Based Learning/Problem-Based Learning diterapkan menyeluruh (> 70% mata kuliah terapan), serta diverifikasi berkala oleh mitra industri TIK.',
                                    3 => 'Baik: Kurikulum OBE telah diimplementasikan dengan metode PBL yang terencana dan memiliki RPS serta penilaian CPL yang jelas.',
                                    2 => 'Cukup: Kurikulum telah berorientasi capaian namun implementasi metode pembelajaran vokasi berbasis proyek masih terbatas.',
                                    1 => 'Kurang: Kurikulum belum menerapkan prinsip OBE dan tidak memiliki dokumen RPS terstruktur.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.2.2',
                        'nama_subkriteria' => 'Kualifikasi, Kecukupan, dan Kompetensi Dosen Tetap',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.2.2.1',
                                'deskripsi_indikator' => 'Kecukupan rasio dosen tetap, kualifikasi akademik minimal Magister serumpun, kepemilikan sertifikasi kompetensi industri TIK berskala nasional/internasional, dan keterlibatan dosen praktisi.',
                                'parameter_penilaian' => 'Data dosen homebase, sertifikat BNSP/internasional (AWS, Cisco, Oracle, dsb), rasio dosen terhadap mahasiswa (maks 1:25 untuk vokasi), dan rekam jejak industri.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: 100% dosen tetap berkualifikasi S2/S3 bidang serumpun Infokom, > 80% dosen memiliki sertifikasi kompetensi profesional industri yang masih berlaku, rasio ideal (< 1:20), dan didukung dosen praktisi aktif industri.',
                                    3 => 'Baik: Kualifikasi dosen memenuhi standar LAM-INFOKOM, > 50% dosen bersertifikat kompetensi keahlian, dan rasio dosen-mahasiswa memenuhi batas ketetapan.',
                                    2 => 'Cukup: Kualifikasi dasar terpenuhi namun persentase dosen bersertifikasi industri masih di bawah 30%.',
                                    1 => 'Kurang: Kecukupan atau kualifikasi dosen tidak memenuhi standar regulasi minimum.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.2.3',
                        'nama_subkriteria' => 'Sarana dan Prasarana Pembelajaran Komputasi',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.2.3.1',
                                'deskripsi_indikator' => 'Kecukupan, aksesibilitas, dan kemutakhiran sarana laboratorium komputasi, infrastruktur jaringan berkecepatan tinggi, serta lisensi perangkat lunak penunjang praktek mahasiswa.',
                                'parameter_penilaian' => 'Data laboratorium komputer prodi, spesifikasi PC/server per workstation mahasiswa (rasio 1:1 saat praktikum), bandwidth internet minimal 100 Mbps, dan software tools resmi.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Fasilitas laboratorium sangat modern, rasio PC terhadap mahasiswa 1:1 dengan spesifikasi mutakhir, bandwidth internet sangat memadai, lingkungan cloud komputasi lengkap, dan tersedia sarana praktikum virtual 24/7.',
                                    3 => 'Baik: Laboratorium komputasi memadai dengan kapasitas memadai untuk seluruh mahasiswa, spesifikasi hardware relevan, dan koneksi internet stabil.',
                                    2 => 'Cukup: Fasilitas laboratorium tersedia namun rasio atau spesifikasi hardware membutuhkan peremajaan berkala.',
                                    1 => 'Kurang: Sarana laboratorium tidak mencukupi untuk mendukung pelaksanaan kurikulum terapan.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'C.3',
                'nama_kriteria' => 'Relevansi Penelitian',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.3.1',
                        'nama_subkriteria' => 'Produktivitas Penelitian Terapan dan Pelibatan Mahasiswa',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.3.1.1',
                                'deskripsi_indikator' => 'Produktivitas penelitian terapan dosen yang relevan dengan roadmap keilmuan infokom vokasi serta pelibatan aktif mahasiswa dalam riset terapan.',
                                'parameter_penilaian' => 'Jumlah publikasi jurnal nasional terakreditasi SINTA dan jurnal internasional bereputasi, laporan penelitian terapan, dan persentase pelibatan mahasiswa vokasi.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Dosen sangat produktif menghasilkan riset terapan bidang TIK berorientasi solusi industri, dipublikasikan pada jurnal bereputasi internasional/nasional, serta > 70% riset melibatkan mahasiswa secara aktif.',
                                    3 => 'Baik: Produktivitas riset terapan dosen memenuhi standar target tahunan, melibatkan mahasiswa, dan dipublikasikan pada forum/jurnal terindeks.',
                                    2 => 'Cukup: Penelitian dosen ada namun publikasi ilmiah bereputasi dan pelibatan mahasiswa masih terbatas.',
                                    1 => 'Kurang: Produktivitas penelitian dosen sangat minim dan tidak selaras dengan roadmap prodi.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.3.2',
                        'nama_subkriteria' => 'Luaran Hak Kekayaan Intelektual (HKI) dan Produk Terapan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.3.2.1',
                                'deskripsi_indikator' => 'Perolehan Hak Cipta Perangkat Lunak, Paten/Paten Sederhana, dan hilirisasi produk aplikasi/sistem cerdas yang digunakan oleh masyarakat atau industri.',
                                'parameter_penilaian' => 'Sertifikat HKI dari DJKI Kemenkumham atas nama dosen/mahasiswa, dokumen uji terap aplikasi, dan surat perjanjian lisensi pemanfaatan.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Jumlah perolehan HKI (Hak Cipta program komputer/paten) per dosen melampaui target (> 2 HKI per dosen per tahun), dan terdapat produk perangkat lunak yang diadopsi secara komersial oleh industri/pemerintah.',
                                    3 => 'Baik: Perolehan sertifikat HKI perangkat lunak terpenuhi dan produk terbukti dimanfaatkan oleh mitra institusi.',
                                    2 => 'Cukup: Memiliki perolehan HKI dasar namun hilirisasi atau adopsi oleh pihak eksternal belum terealisasi.',
                                    1 => 'Kurang: Tidak memiliki luaran HKI atau produk terapan yang terdaftar resmi.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'C.4',
                'nama_kriteria' => 'Relevansi Pengabdian kepada Masyarakat (PkM)',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.4.1',
                        'nama_subkriteria' => 'Dampak Implementasi PkM Berbasis Teknologi Digital',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.4.1.1',
                                'deskripsi_indikator' => 'Kualitas, relevansi, keberlanjutan, dan dampak kegiatan PkM dosen bersama mahasiswa dalam mengentaskan permasalahan transformasi digital di UMKM, sekolah, atau instansi pemerintahan daerah.',
                                'parameter_penilaian' => 'Laporan PkM terapan, bukti penyerahan produk aplikasi/sistem kepada masyarakat, testimoni kepuasan mitra PkM, dan liputan media.',
                                'bobot' => 3.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Kegiatan PkM berbasis digital terapan berdampak nyata, berkesinambungan (> 2 tahun pada mitra yang sama), menyelesaikan persoalan krusial mitra UMKM/daerah, dan menghasilkan luaran publikasi pengabdian berkala.',
                                    3 => 'Baik: Kegiatan PkM terencana sesuai roadmap keilmuan, melibatkan mahasiswa, dan memberikan solusi tepat guna kepada masyarakat sasaran.',
                                    2 => 'Cukup: PkM terlaksana secara rutin namun bersifat insidental tanpa program keberlanjutan pasca-kegiatan.',
                                    1 => 'Kurang: Kegiatan PkM tidak relevan dengan bidang ilmu Infokom atau tidak memenuhi standar minimal.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'C.5',
                'nama_kriteria' => 'Akuntabilitas',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.5.1',
                        'nama_subkriteria' => 'Pengelolaan Keuangan dan Keberlanjutan Finansial',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.5.1.1',
                                'deskripsi_indikator' => 'Kecukupan alokasi dana operasional pendidikan per mahasiswa per tahun, proporsi anggaran riset/PkM, transparansi audit keuangan, dan sustainability pendanaan prodi.',
                                'parameter_penilaian' => 'Laporan keuangan terperinci (3 tahun terakhir), bukti audit eksternal/internal wajar tanpa pengecualian (WTP), dan rasio dana operasional > Rp 20 juta/mhs/tahun.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Alokasi biaya operasional pendidikan sangat memadai (> Rp 25 juta/mhs/tahun), alokasi riset/PkM > 10% total anggaran, laporan keuangan diaudit secara independen (opini WTP), dan memiliki dana abadi/pendapatan non-SPP yang sehat.',
                                    3 => 'Baik: Anggaran operasional memadai, audit internal berjalan tertib, dan alokasi dana Tridharma sesuai ketentuan standar mutu.',
                                    2 => 'Cukup: Pendanaan cukup untuk operasional minimum namun sangat bergantung pada pembayaran SPP mahasiswa.',
                                    1 => 'Kurang: Pengelolaan keuangan tidak transparan atau dana operasional tidak mencukupi untuk kelayakan proses pembelajaran.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.5.2',
                        'nama_subkriteria' => 'Masa Tunggu, Serapan Kerja, dan Kualitas Lulusan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.5.2.1',
                                'deskripsi_indikator' => 'Efektivitas tracer study, rata-rata masa tunggu lulusan memperoleh pekerjaan pertama yang relevan, tingkat keselarasan horizontal-vertikal karir, dan standar penghasilan pertama lulusan.',
                                'parameter_penilaian' => 'Laporan tracer study dengan response rate > 80%, data waktu tunggu lulusan (< 3 bulan untuk Unggul), dan survei kepuasan atasan langsung pengguna lulusan.',
                                'bobot' => 4.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Tracer study terlaksana sangat terstruktur (respon > 85%), rata-rata masa tunggu lulusan < 3 bulan, > 85% bekerja pada bidang yang relevan dengan TIK, dan rata-rata gaji pertama > 1.5 kali UMR wilayah.',
                                    3 => 'Baik: Tracer study berjalan baik, rata-rata masa tunggu 3-6 bulan, dan mayoritas lulusan bekerja pada sektor yang linier.',
                                    2 => 'Cukup: Masa tunggu rata-rata antara 6-12 bulan dan tingkat keselarasan karir belum optimal.',
                                    1 => 'Kurang: Tracer study tidak dilaksanakan secara valid atau masa tunggu lulusan melebihi 12 bulan.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'C.6',
                'nama_kriteria' => 'Diferensiasi Misi',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.6.1',
                        'nama_subkriteria' => 'Keunggulan Spesifik dan Distingsi Program Studi Vokasi',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.6.1.1',
                                'deskripsi_indikator' => 'Bukti keunggulan distingtif (spesialisasi vokasi terapan komputasi), rekognisi kompetensi talenta digital di tingkat nasional/internasional, dan capaian prestasi mahasiswa bidang TIK.',
                                'parameter_penilaian' => 'Portofolio produk unggulan prodi (misal: Center of Excellence Software Engineering/AI Vokasi), medali kompetisi nasional (KMHE/KJI/LKS/Gemastik/PIMNAS/WorldSkills), dan rekognisi mitra industri.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memiliki diferensiasi misi yang sangat jelas dan terbukti unggul di tingkat nasional/internasional, memiliki portofolio produk teknologi yang diakui luas, dan mahasiswa meraih prestasi juara kompetisi bergengsi secara rutin.',
                                    3 => 'Baik: Memiliki ciri khas keunggulan vokasi yang terdefinisikan dengan baik dan didukung bukti prestasi mahasiswa tingkat wilayah/nasional.',
                                    2 => 'Cukup: Ada wacana diferensiasi spesialisasi prodi namun implementasi dan pembuktian prestasinya masih terbatas.',
                                    1 => 'Kurang: Tidak memiliki pembeda atau keunggulan spesifik dibanding program studi sejenis lainnya.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'kode_kriteria' => 'D',
                'nama_kriteria' => 'Suplemen',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'D.1',
                        'nama_subkriteria' => 'Pemenuhan Standar Suplemen Khusus LAM-INFOKOM',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-D.1.1',
                                'deskripsi_indikator' => 'Pemenuhan ambang batas wajib (threshold requirement) LAM-INFOKOM mencakup rasio dosen tetap, kepemilikan repositori digital kode sumber/aplikasi, dan etika profesi komputasi.',
                                'parameter_penilaian' => 'Checklist pemenuhan butir suplemen wajib LAM-INFOKOM, repositori Git institucional yang aktif, dan integrasi modul etika rekayasa perangkat lunak dalam kurikulum.',
                                'bobot' => 3.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memenuhi 100% kriteria suplemen wajib LAM-INFOKOM dengan nilai sempurna, repositori open-source / institucional termutakhirkan rapi, dan memiliki kode etik profesi komputasi yang ditegakkan dengan ketat.',
                                    3 => 'Baik: Seluruh persyaratan ambang batas suplemen LAM-INFOKOM terpenuhi tanpa catatan kekurangan.',
                                    2 => 'Cukup: Persyaratan dasar terpenuhi namun terdapat catatan perbaikan minor dari kriteria suplemen.',
                                    1 => 'Kurang: Gagal memenuhi salah satu ambang batas wajib (threshold) yang dipersyaratkan oleh instrumen LAM-INFOKOM.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Seed Kriteria, Subkriteria, Indikator, Rubrik, dan Bobot untuk masing-masing instrumen target (Program Diploma & Sarjana Terapan)
        foreach ($targetInstrumens as $instrumen) {
            foreach ($kriteriaData as $krit) {
                $kriteriaModel = Kriteria::firstOrCreate(
                    [
                        'id_instrumen' => $instrumen->id,
                        'kode_kriteria' => $krit['kode_kriteria'],
                    ],
                    [
                        'nama_kriteria' => $krit['nama_kriteria'],
                    ]
                );

                foreach ($krit['subkriteria'] as $sub) {
                    $subkriteriaModel = Subkriteria::firstOrCreate(
                        [
                            'id_kriteria' => $kriteriaModel->id,
                            'kode_subkriteria' => $sub['kode_subkriteria'],
                        ],
                        [
                            'nama_subkriteria' => $sub['nama_subkriteria'],
                        ]
                    );

                    foreach ($sub['indikator'] as $ind) {
                        $indikatorModel = Indikator::firstOrCreate(
                            [
                                'id_subkriteria' => $subkriteriaModel->id,
                                'kode_indikator' => $ind['kode_indikator'],
                            ],
                            [
                                'deskripsi_indikator' => $ind['deskripsi_indikator'],
                                'bobot' => $ind['bobot'],
                            ]
                        );

                        // Rubrik Skor 1 s.d 4
                        foreach ($ind['rubrik'] as $skor => $deskripsi) {
                            Rubrik::firstOrCreate(
                                [
                                    'id_indikator' => $indikatorModel->id,
                                    'skor' => $skor,
                                ],
                                [
                                    'deskripsi_rubrik' => $deskripsi,
                                ]
                            );
                        }
                    }
                }
            }
        }

        // =========================================================================
        // 7. STANDAR MUTU SPMI (LENGKAP SIKLUS PPEPP)
        // =========================================================================
        $standarMutuList = [
            ['kode_standar' => 'STD-INFOKOM-01', 'nama_standar' => 'Standar Kompetensi Lulusan Bidang Komputasi Vokasi', 'deskripsi' => 'Pedoman perumusan dan evaluasi CPL terapan selaras SKKNI dan standar global.'],
            ['kode_standar' => 'STD-INFOKOM-02', 'nama_standar' => 'Standar Isi Kurikulum & OBE Vokasi', 'deskripsi' => 'Struktur kurikulum berbasis capaian, RPS terintegrasi proyek, dan modular competency.'],
            ['kode_standar' => 'STD-INFOKOM-03', 'nama_standar' => 'Standar Pembelajaran Berbasis Proyek (Project-Based Learning)', 'deskripsi' => 'Ketentuan pelaksanaan praktikum kolaboratif pemecahan kasus riil industri.'],
            ['kode_standar' => 'STD-INFOKOM-04', 'nama_standar' => 'Standar Penilaian Capaian Pembelajaran', 'deskripsi' => 'Pedoman rubrik penilaian autentik dan pengukuran ketercapaian CPL tiap mahasiswa.'],
            ['kode_standar' => 'STD-INFOKOM-05', 'nama_standar' => 'Standar Dosen dan Tenaga Kependidikan Bidang TIK', 'deskripsi' => 'Kriteria kualifikasi akademik, sertifikasi keahlian industri, dan beban kerja dosen.'],
            ['kode_standar' => 'STD-INFOKOM-06', 'nama_standar' => 'Standar Sarana Laboratorium Komputasi dan Jaringan', 'deskripsi' => 'Spesifikasi rasio PC 1:1, bandwidth, cloud sandbox, dan lisensi perangkat lunak resmi.'],
            ['kode_standar' => 'STD-INFOKOM-07', 'nama_standar' => 'Standar Tata Pamong dan Akuntabilitas UPPS', 'deskripsi' => 'Prinsip good university governance, kepemimpinan visioner, dan manajemen risiko.'],
            ['kode_standar' => 'STD-INFOKOM-08', 'nama_standar' => 'Standar Pembiayaan Pembelajaran Vokasi', 'deskripsi' => 'Kecukupan dana operasional pendidikan minimal dan transparansi alokasi belanja modal.'],
            ['kode_standar' => 'STD-INFOKOM-09', 'nama_standar' => 'Standar Riset Terapan & Publikasi Bidang TIK', 'deskripsi' => 'Kewajiban publikasi jurnal, keterlibatan mahasiswa vokasi, dan hilirisasi riset.'],
            ['kode_standar' => 'STD-INFOKOM-10', 'nama_standar' => 'Standar Pengabdian kepada Masyarakat Berbasis IT', 'deskripsi' => 'Pemanfaatan solusi teknologi digital untuk transformasi masyarakat dan UMKM lokal.'],
            ['kode_standar' => 'STD-INFOKOM-11', 'nama_standar' => 'Standar Kerjasama Industri dan Kemitraan Strategis', 'deskripsi' => 'Kriteria kemitraan industri bersertifikat, kuota magang industri, dan teaching factory.'],
        ];

        foreach ($standarMutuList as $std) {
            StandarMutu::firstOrCreate(
                ['kode_standar' => $std['kode_standar']],
                [
                    'nama_standar' => $std['nama_standar'],
                    'deskripsi' => $std['deskripsi'],
                ]
            );
        }

        // =========================================================================
        // 8. JENIS PEMBIAYAAN
        // =========================================================================
        $jenisPembiayaanList = [
            'Biaya Operasional Pendidikan (BOP)',
            'Biaya Operasional Kemahasiswaan & Penalaran',
            'Biaya Penelitian Terapan Dosen & Mahasiswa',
            'Biaya Pengabdian kepada Masyarakat (PkM)',
            'Biaya Investasi Sarana & Prasarana Komputasi',
            'Biaya Lisensi Software & Langganan Cloud',
            'Biaya Sertifikasi Kompetensi Internasional SDM',
        ];

        $pembiayaanModels = [];
        foreach ($jenisPembiayaanList as $pem) {
            $pembiayaanModels[] = JenisPembiayaan::firstOrCreate(['nama_pembiayaan' => $pem]);
        }

        // =========================================================================
        // 9. PROJECT AKREDITASI DEMO (DIPLOMA & SARJANA TERAPAN)
        // =========================================================================
        // Lepas foreign key lama ke prodi jika masih menempel di MySQL
        if (DB::getDriverName() === 'mysql') {
            try {
                DB::statement('ALTER TABLE `project_akreditasi` DROP FOREIGN KEY `project_akreditasi_id_prodi_foreign`');
            } catch (\Throwable $e) {
                // Abaikan jika constraint sudah tidak ada
            }
        }

        // Jika tabel prodi lama masih ada di database, pastikan entri prodi ada agar tidak melanggar constraint
        $idProdiD3 = 201;
        $idProdiD4 = 202;
        if (Schema::hasTable('prodi')) {
            try {
                DB::table('prodi')->insertOrIgnore([
                    ['id' => 201, 'nama_prodi' => 'D3 Teknik Informatika', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 202, 'nama_prodi' => 'D4 Rekayasa Perangkat Lunak', 'created_at' => now(), 'updated_at' => now()],
                ]);
            } catch (\Throwable $e) {
                $firstProdi = DB::table('prodi')->value('id');
                if ($firstProdi) {
                    $idProdiD3 = $firstProdi;
                    $idProdiD4 = $firstProdi;
                }
            }
        }

        // Project 1: Program Diploma (D3 Teknik Informatika)
        $projectDiploma = ProjectAkreditasi::firstOrCreate(
            ['nama_project' => 'Akreditasi Program Studi D3 Teknik Informatika 2026'],
            [
                'id_prodi' => $idProdiD3, // ID Prodi
                'id_versi_instrumen' => $versi->id,
                'id_jenjang' => $jenjangDiploma->id,
                'id_jenis_instrumen' => $jenisUnggul->id,
                'tahun_target_submit' => 2026,
                'status_project' => 'In Progress',
            ]
        );

        // Project 2: Sarjana Terapan (D4 Teknologi Rekayasa Perangkat Lunak)
        $projectSarjanaTerapan = ProjectAkreditasi::firstOrCreate(
            ['nama_project' => 'Akreditasi Program Studi D4 Rekayasa Perangkat Lunak 2026'],
            [
                'id_prodi' => $idProdiD4, // ID Prodi
                'id_versi_instrumen' => $versi->id,
                'id_jenjang' => $jenjangSarjanaTerapan->id,
                'id_jenis_instrumen' => $jenisUnggul->id,
                'tahun_target_submit' => 2026,
                'status_project' => 'Draft',
            ]
        );

        // =========================================================================
        // 10. DATA SARPRAS & SARANA PRODI DEMO
        // =========================================================================
        $sarprasData = [
            [
                'project' => $projectDiploma,
                'nama_lab' => 'Laboratorium Rekayasa Perangkat Lunak & Basis Data',
                'kapasitas' => 40,
                'sarana' => [
                    ['jumlah_unit' => 40, 'kondisi' => 'Baik', 'keterangan' => 'PC Workstation Intel Core i7 13700, 32GB DDR5, SSD 1TB, Dual Monitor 24"'],
                    ['jumlah_unit' => 1, 'kondisi' => 'Baik', 'keterangan' => 'Smart Interactive Projector 4K Ultra HD & Motorized Screen'],
                    ['jumlah_unit' => 2, 'kondisi' => 'Baik', 'keterangan' => 'AC Inverter 2.5 PK & Air Purifier HEPA Filter'],
                ],
            ],
            [
                'project' => $projectDiploma,
                'nama_lab' => 'Laboratorium Jaringan Komputer, IoT, & Cloud Sandbox',
                'kapasitas' => 36,
                'sarana' => [
                    ['jumlah_unit' => 36, 'kondisi' => 'Baik', 'keterangan' => 'Workstation Dual-NIC Gigabit, 16GB RAM, SSD NVMe'],
                    ['jumlah_unit' => 6, 'kondisi' => 'Baik', 'keterangan' => 'Cisco Catalyst Switch 2960 Series & Router Rack Simulator'],
                    ['jumlah_unit' => 20, 'kondisi' => 'Baik', 'keterangan' => 'IoT Development Kit (Raspberry Pi 5 + ESP32 Sensor Array)'],
                ],
            ],
            [
                'project' => $projectSarjanaTerapan,
                'nama_lab' => 'Studio Pengembangan Kecerdasan Buatan & Multimedia',
                'kapasitas' => 35,
                'sarana' => [
                    ['jumlah_unit' => 35, 'kondisi' => 'Baik', 'keterangan' => 'High-End AI Workstation Core i9, GPU Nvidia RTX 4080 16GB, 64GB RAM'],
                    ['jumlah_unit' => 1, 'kondisi' => 'Baik', 'keterangan' => 'Local AI Inference Server Dell PowerEdge R750xa Dual Xeon'],
                ],
            ],
        ];

        foreach ($sarprasData as $data) {
            $prasarana = DataSarprasProdi::firstOrCreate(
                [
                    'id_project' => $data['project']->id,
                    'keterangan' => $data['nama_lab'],
                ],
                [
                    'kapasitas' => $data['kapasitas'],
                ]
            );

            foreach ($data['sarana'] as $sar) {
                DataSaranaProdi::firstOrCreate(
                    [
                        'id_prasarana' => $prasarana->id,
                        'keterangan' => $sar['keterangan'],
                    ],
                    [
                        'jumlah_unit' => $sar['jumlah_unit'],
                        'kondisi' => $sar['kondisi'],
                    ]
                );
            }
        }

        // =========================================================================
        // 11. DATA KEUANGAN PRODI DEMO (3 TAHUN TERAKHIR)
        // =========================================================================
        $years = [2024, 2025, 2026];
        $danaSample = [
            'Biaya Operasional Pendidikan (BOP)' => [1250000000, 1400000000, 1650000000],
            'Biaya Operasional Kemahasiswaan & Penalaran' => [150000000, 180000000, 220000000],
            'Biaya Penelitian Terapan Dosen & Mahasiswa' => [200000000, 250000000, 320000000],
            'Biaya Pengabdian kepada Masyarakat (PkM)' => [100000000, 120000000, 160000000],
            'Biaya Investasi Sarana & Prasarana Komputasi' => [500000000, 650000000, 800000000],
            'Biaya Lisensi Software & Langganan Cloud' => [90000000, 110000000, 140000000],
            'Biaya Sertifikasi Kompetensi Internasional SDM' => [80000000, 95000000, 130000000],
        ];

        foreach ($pembiayaanModels as $pem) {
            if (isset($danaSample[$pem->nama_pembiayaan])) {
                foreach ($years as $idx => $year) {
                    DataKeuanganProdi::firstOrCreate(
                        [
                            'id_project' => $projectDiploma->id,
                            'id_pembiayaan' => $pem->id,
                            'tahun_anggaran' => $year,
                        ],
                        [
                            'jumlah_dana' => $danaSample[$pem->nama_pembiayaan][$idx],
                        ]
                    );

                    DataKeuanganProdi::firstOrCreate(
                        [
                            'id_project' => $projectSarjanaTerapan->id,
                            'id_pembiayaan' => $pem->id,
                            'tahun_anggaran' => $year,
                        ],
                        [
                            'jumlah_dana' => $danaSample[$pem->nama_pembiayaan][$idx] * 1.15,
                        ]
                    );
                }
            }
        }

        // =========================================================================
        // 12. DATA SPMI AUDIT DEMO
        // =========================================================================
        $stdSpmi1 = StandarMutu::where('kode_standar', 'STD-INFOKOM-01')->first();
        $stdSpmi3 = StandarMutu::where('kode_standar', 'STD-INFOKOM-03')->first();
        $stdSpmi6 = StandarMutu::where('kode_standar', 'STD-INFOKOM-06')->first();

        if ($stdSpmi1) {
            DataSpmiAudit::firstOrCreate(
                [
                    'id_project' => $projectDiploma->id,
                    'id_standar' => $stdSpmi1->id,
                    'tahun_audit' => 2025,
                    'jenis_kegiatan' => 'AMI',
                ],
                [
                    'tanggal_pelaksanaan' => '2025-11-15',
                    'temuan' => 'Capaian Pembelajaran Lulusan (CPL) aspek rekayasa sistem berbasis cloud telah melampaui target minimum indikator kinerja utama.',
                    'tindak_lanjut' => 'Penyesuaian modul ajar advance cloud computing dan peningkatan sertifikasi AWS Cloud Practitioner bagi mahasiswa tingkat akhir.',
                    'status_penyelesaian' => 'Closed',
                ]
            );
        }

        if ($stdSpmi3) {
            DataSpmiAudit::firstOrCreate(
                [
                    'id_project' => $projectDiploma->id,
                    'id_standar' => $stdSpmi3->id,
                    'tahun_audit' => 2025,
                    'jenis_kegiatan' => 'RTM',
                ],
                [
                    'tanggal_pelaksanaan' => '2025-12-05',
                    'temuan' => 'Metode Project-Based Learning pada semester 5 memerlukan integrasi repository industri nyata.',
                    'tindak_lanjut' => 'Menjalin MoU dengan 3 software house mitra untuk menjadi mentor industri pada mata kuliah Capstone Project.',
                    'status_penyelesaian' => 'Closed',
                ]
            );
        }

        if ($stdSpmi6) {
            DataSpmiAudit::firstOrCreate(
                [
                    'id_project' => $projectSarjanaTerapan->id,
                    'id_standar' => $stdSpmi6->id,
                    'tahun_audit' => 2026,
                    'jenis_kegiatan' => 'PPEPP',
                ],
                [
                    'tanggal_pelaksanaan' => '2026-01-20',
                    'temuan' => 'Kebutuhan GPU server untuk praktikum Deep Learning dan Computer Vision meningkat.',
                    'tindak_lanjut' => 'Pengadaan server GPU tambahan pada alokasi anggaran investasi triwulan I 2026.',
                    'status_penyelesaian' => 'Open',
                ]
            );
        }

        // =========================================================================
        // 13. CONTOH SELF ASSESSMENT & PENILAIAN REVIEWER DEMO
        // =========================================================================
        // Ambil beberapa indikator untuk diisi penilaian demo
        $sampleIndikators = Indikator::take(5)->get();
        foreach ($sampleIndikators as $ind) {
            // Ambil rubrik skor 4 untuk indikator ini
            $rubrikUnggul = Rubrik::where('id_indikator', $ind->id)->where('skor', 4)->first();
            $bobotInd = (float) ($ind->bobot ?? 3.5);

            if ($rubrikUnggul) {
                SelfAssessment::firstOrCreate(
                    [
                        'id_project' => $projectDiploma->id,
                        'id_indikator' => $ind->id,
                    ],
                    [
                        'id_rubrik' => $rubrikUnggul->id,
                        'skor_terbobot' => round(4.0 * $bobotInd, 2),
                        'catatan_reviewer' => 'Dokumen bukti sahih sangat lengkap, keterlibatan mitra industri dan luaran nyata telah divalidasi dengan predikat Sangat Baik (Unggul).',
                        'tanggal_penilaian' => Carbon::now()->subDays(2),
                        'reviewer_id' => 10, // ID Reviewer simulasi
                    ]
                );
            }
        }

        // =========================================================================
        // 14. MAPPING TIM AKREDITASI DEMO
        // =========================================================================
        if ($sampleIndikators->isNotEmpty()) {
            foreach ($sampleIndikators as $idx => $ind) {
                MappingTimAkreditasi::firstOrCreate(
                    [
                        'id_project' => $projectDiploma->id,
                        'id_indikator' => $ind->id,
                    ],
                    [
                        'id_user' => 100 + $idx, // ID User dosen dari API Kelompok 2
                        'role' => ($idx === 0) ? 'Koordinator Kriteria' : 'Penyusun Butir',
                    ]
                );
            }
        }
    }
}
