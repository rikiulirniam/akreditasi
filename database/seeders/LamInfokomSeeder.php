<?php

namespace Database\Seeders;

use App\Models\DataKeuanganProdi;
use App\Models\DataSaranaProdi;
use App\Models\DataSarprasProdi;
use App\Models\DataSpmiAudit;
use App\Models\EvidenceSpmi;
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
use App\Models\Subkriteria;
use App\Models\VersiInstrumen;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LamInfokomSeeder extends Seeder
{
    /**
     * Run the database seeds for LAM-INFOKOM Versi 2.1 pada jenjang Sarjana Terapan.
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
        // 4. JENJANG PENDIDIKAN (Fokus: Sarjana Terapan / D4)
        // =========================================================================
        $jenjangSarjanaTerapan = Jenjang::firstOrCreate(['nama_jenjang' => 'Sarjana Terapan']);
        $jenjangDiploma = Jenjang::firstOrCreate(['nama_jenjang' => 'Program Diploma']);

        Jenjang::firstOrCreate(['nama_jenjang' => 'Sarjana']);
        Jenjang::firstOrCreate(['nama_jenjang' => 'Magister Terapan']);
        Jenjang::firstOrCreate(['nama_jenjang' => 'Magister']);
        Jenjang::firstOrCreate(['nama_jenjang' => 'Doktor']);

        // =========================================================================
        // 5. BRIDGE INSTRUMEN (UUID)
        // =========================================================================
        $instrumenSarjanaTerapan = Instrumen::firstOrCreate([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjangSarjanaTerapan->id,
            'id_jenis_instrumen' => $jenisUnggul->id,
        ]);

        $instrumenDiploma = Instrumen::firstOrCreate([
            'id_versi_instrumen' => $versi->id,
            'id_jenjang' => $jenjangDiploma->id,
            'id_jenis_instrumen' => $jenisUnggul->id,
        ]);

        $targetInstrumens = [$instrumenSarjanaTerapan, $instrumenDiploma];

        // =========================================================================
        // 6. STRUKTUR LENGKAP KRITERIA, SUBKRITERIA, INDIKATOR, DAN RUBRIK
        //    LAM-INFOKOM VERSI 2.1 SPESIFIK UNTUK JENJANG SARJANA TERAPAN (D4)
        // =========================================================================
        $kriteriaData = [
            // KRITERIA A: KONDISI EKSTERNAL
            [
                'kode_kriteria' => 'A',
                'nama_kriteria' => 'Kondisi Eksternal',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'A.1',
                        'nama_subkriteria' => 'Analisis Lingkungan Makro dan Mikro Industri TIK',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-A.1.1',
                                'deskripsi_indikator' => 'Ketajaman analisis lingkungan makro dan mikro (analisis SWOT) serta relevansinya dengan tren transformasi digital, revolusi Industri 4.0, kebutuhan talenta digital nasional/internasional, dan standar asosiasi profesi bidang informatika dan komputer.',
                                'bobot' => 2.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Analisis lingkungan makro dan mikro sangat tajam, komprehensif, berbasis data riil industri TIK terkini, dan secara eksplisit dijadikan rujukan utama dalam perumusan kurikulum vokasi Sarjana Terapan.',
                                    3 => 'Baik: Analisis lingkungan makro dan mikro komprehensif serta dijadikan dasar perumusan strategi prodi dengan data pendukung yang memadai.',
                                    2 => 'Cukup: Analisis lingkungan eksternal ada namun bersifat normatif/deskriptif umum dan belum terintegrasi utuh ke strategi pengembangan vokasi.',
                                    1 => 'Kurang: Tidak melakukan analisis lingkungan eksternal secara sistematis atau tidak memiliki dokumen pendukung yang sahih.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'A.2',
                        'nama_subkriteria' => 'Keselarasan Strategis Visi Keilmuan Vokasi',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-A.2.1',
                                'deskripsi_indikator' => 'Kejelasan dan keselarasan visi keilmuan program studi Sarjana Terapan dengan Renstra perguruan tinggi serta diferensiasi keunggulan spesifik di bidang teknologi rekayasa komputasi.',
                                'bobot' => 2.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Visi keilmuan sangat visioner, mencerminkan spesialisasi terapan komputasi tingkat lanjut yang unik, dan selaras 100% dengan rencana strategis institusi.',
                                    3 => 'Baik: Visi keilmuan jelas, realistis, dan selaras dengan rencana pengembangan institusi dan kebutuhan industri.',
                                    2 => 'Cukup: Visi keilmuan dirumuskan namun belum secara tegas menunjukkan kekhasan pendidikan Sarjana Terapan (level 6 KKNI).',
                                    1 => 'Kurang: Visi keilmuan tidak jelas atau tidak terdokumentasi secara legal.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA B: PROFIL UNIT PENGELOLA PROGRAM STUDI (UPPS)
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
                                'deskripsi_indikator' => 'Efektivitas sistem tata pamong yang kredibel, transparan, akuntabel, bertanggung jawab, dan adil (Good Department Governance) didukung sistem informasi manajemen terintegrasi untuk mendukung operasional Sarjana Terapan.',
                                'bobot' => 3.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Struktur organisasi UPPS berjalan sangat efektif, kepemimpinan visioner dan kolaboratif, seluruh operasional tata kelola berbasis digital (SIAKAD, SPMI, Keuangan), dan evaluasi berkala berjalan tanpa deviasi.',
                                    3 => 'Baik: Struktur tata pamong efektif, kepemimpinan fungsional berjalan baik, memiliki SOP lengkap dan laporan kinerja tahunan yang akuntabel.',
                                    2 => 'Cukup: Tata kelola berjalan namun evaluasi berkala dan sistem penjaminan transparansi publik belum berjalan optimal.',
                                    1 => 'Kurang: Struktur organisasi tidak berfungsi efektif atau tidak memiliki bukti pedoman tata pamong tertulis.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'B.2',
                        'nama_subkriteria' => 'Kerjasama Strategis Tridharma dengan DUDI TIK',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-B.2.1',
                                'deskripsi_indikator' => 'Kuantitas, kualitas, relevansi, dan keberlanjutan kemitraan strategis dengan Dunia Usaha Dunia Industri (DUDI) bidang Infokom dalam skema magang bersertifikat, kurikulum bersama, transfer teknologi, dan industrial teaching.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memiliki jejaring kemitraan aktif dengan industri TIK skala nasional dan global (> 15 mitra industri), 100% kerjasama memiliki implementasi nyata (magang 1-2 semester, beasiswa, hibah perangkat), dengan tingkat kepuasan mitra > 90%.',
                                    3 => 'Baik: Kerjasama dengan industri mitra berjalan aktif dengan bukti kegiatan Tridharma vokasi yang terdokumentasi rapi.',
                                    2 => 'Cukup: Memiliki dokumen MoU/MoA formal namun implementasi kegiatan terapan masih sporadis.',
                                    1 => 'Kurang: Tidak memiliki dokumen kerjasama aktif yang relevan dengan bidang keilmuan infokom terapan.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'B.3',
                        'nama_subkriteria' => 'Kerjasama Internasional dan Jejaring Asosiasi Profesi TIK',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-B.3.1',
                                'deskripsi_indikator' => 'Kemitraan strategis dengan institusi internasional dan asosiasi profesi (APTIKOM, IPKIN, IEEE, ACM) dalam rekognisi kurikulum, uji sertifikasi global, dan mobilitas akademik.',
                                'bobot' => 2.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memiliki kerjasama internasional aktif yang menghasilkan rekognisi internasional, pertukaran mahasiswa/dosen, atau program sertifikasi vendor bereputasi dunia (Cisco, AWS, Oracle, Google).',
                                    3 => 'Baik: Terlibat aktif dalam asosiasi profesi dan memiliki minimal 1 program kemitraan internasional yang berjalan.',
                                    2 => 'Cukup: Terdaftar sebagai anggota asosiasi namun keikutsertaan program kolaboratif masih terbatas.',
                                    1 => 'Kurang: Tidak memiliki rekognisi atau kerjasama jejaring profesi di bidang komputasi.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA C.1: BUDAYA MUTU
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
                                'deskripsi_indikator' => 'Konsistensi dan keterlaksanaan siklus PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan) dalam penjaminan mutu program studi Sarjana Terapan yang terintegrasi secara melembaga.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Siklus PPEPP terlaksana secara konsisten, terdokumentasi lengkap dalam sistem penjaminan mutu digital, rekomendasi RTM 100% ditindaklanjuti, dan terjadi peningkatan standar mutu berkelanjutan secara periodik.',
                                    3 => 'Baik: Siklus PPEPP terlaksana lengkap dengan dokumen standar mutu, laporan audit berkala, dan dokumen tindak lanjut perbaikan.',
                                    2 => 'Cukup: Penjaminan mutu baru berjalan pada tahap Penetapan dan Pelaksanaan; evaluasi dan pengendalian belum terdokumentasi periodik.',
                                    1 => 'Kurang: Tidak memiliki sistem penjaminan mutu internal atau siklus PPEPP tidak dijalankan.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.1.1.2',
                                'deskripsi_indikator' => 'Kualitas pelaksanaan Audit Mutu Internal (AMI) tahunan dan Rapat Tinjauan Manajemen (RTM) serta kecepatan penyelesaian temuan audit di lingkungan UPPS.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Audit Mutu Internal dilakukan rutin oleh auditor bersertifikat, temuan audit ditindaklanjuti tuntas (status Closed > 90%), dan hasil RTM menjadi landasan penyusunan anggaran tahun berikutnya.',
                                    3 => 'Baik: AMI dan RTM dilaksanakan secara teratur setiap tahun dengan laporan tindak lanjut yang memadai.',
                                    2 => 'Cukup: Audit internal dilaksanakan namun tindak lanjut temuan audit lambat atau berulang.',
                                    1 => 'Kurang: Tidak melaksanakan Audit Mutu Internal secara berkala.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.1.2',
                        'nama_subkriteria' => 'Sistem Umpan Balik dan Pengukuran Kepuasan Pemangku Kepentingan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.1.2.1',
                                'deskripsi_indikator' => 'Ketersediaan instrumen valid, keteraturan pengukuran kepuasan berkala berbasis digital terhadap mahasiswa, dosen, tenaga kependidikan, alumni, dan pengguna lulusan industri.',
                                'bobot' => 3.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Survei kepuasan dilakukan berkala berbasis web dengan instrumen tervalidasi, response rate > 85%, indeks kepuasan pemangku kepentingan > 85%, dan seluruh masukan dianalisis tuntas untuk perbaikan mutu.',
                                    3 => 'Baik: Survei kepuasan terlaksana secara teratur dan memiliki laporan hasil analisis tindak lanjut yang jelas.',
                                    2 => 'Cukup: Survei dilakukan berkala namun analisis mendalam dan tindak lanjut perbaikan belum terdokumentasi formal.',
                                    1 => 'Kurang: Tidak melakukan pengukuran kepuasan pemangku kepentingan secara valid.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA C.2: RELEVANSI PENDIDIKAN (SARJANA TERAPAN / D4)
            [
                'kode_kriteria' => 'C.2',
                'nama_kriteria' => 'Relevansi Pendidikan',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.2.1',
                        'nama_subkriteria' => 'Kurikulum Berbasis Outcome (OBE), KKNI Level 6, dan Pembelajaran Terapan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.2.1.1',
                                'deskripsi_indikator' => 'Relevansi kurikulum OBE dengan standar KKNI level 6 dan SKKNI bidang Infokom, ketepatan perumusan CPL-CPMK, serta pelibatan aktif pakar DUDI dalam restrukturisasi kurikulum.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Kurikulum OBE selaras penuh dengan standar KKNI level 6 dan industri global, matriks CPL terukur dengan asesmen autentik, dan ditinjau berkala bersama asosiasi profesi dan mitra industri TIK.',
                                    3 => 'Baik: Kurikulum OBE terstruktur baik sesuai capaian profil Sarjana Terapan, memiliki RPS lengkap, dan ditinjau secara berkala.',
                                    2 => 'Cukup: Kurikulum telah berorientasi capaian namun keselarasan CPL dengan kebutuhan industri terapan belum maksimal.',
                                    1 => 'Kurang: Kurikulum belum menerapkan prinsip OBE dan tidak memiliki dokumen RPS terstruktur.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.2.1.2',
                                'deskripsi_indikator' => 'Penerapan metode pembelajaran terapan berbasis proyek nyata (Project-Based Learning / PBL) dan pembelajaran berbasis kasus (Case Method) pada minimal 70% mata kuliah terapan dan capstone project.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Metode Project-Based Learning diterapkan menyeluruh (> 75% mata kuliah terapan), proyek bersumber dari persoalan riil mitra industri/masyarakat, dan menghasilkan produk perangkat lunak/sistem yang siap diuji terap.',
                                    3 => 'Baik: Metode PBL dan Case Method telah diterapkan pada mayoritas mata kuliah keahlian dengan rubrik penilaian proyek yang jelas.',
                                    2 => 'Cukup: Metode pembelajaran berbasis proyek ada namun porsinya masih di bawah 50% mata kuliah terapan.',
                                    1 => 'Kurang: Pembelajaran masih dominan teori konvensional tanpa penugasan proyek terapan yang terstruktur.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.2.1.3',
                                'deskripsi_indikator' => 'Pelaksanaan program magang industri intensif (minimal 1 hingga 2 semester setara 20-40 SKS) atau program MBKM terapan bersertifikat dengan monitoring dan pembimbingan ganda (dosen & mentor industri).',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: 100% mahasiswa Sarjana Terapan wajib mengikuti magang industri minimal 6 bulan - 1 tahun pada perusahaan TIK bereputasi, memiliki logbook digital, dibimbing mentor industri bersertifikat, dan rekognisi SKS berjalan lancar.',
                                    3 => 'Baik: Program magang industri berjalan teratur minimal 1 semester dengan instrumen monitoring dan evaluasi yang memadai.',
                                    2 => 'Cukup: Magang industri ada namun durasinya kurang dari 1 semester atau konversi SKS belum optimal.',
                                    1 => 'Kurang: Program magang industri tidak terstruktur atau tidak memiliki mitra industri tetap.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.2.2',
                        'nama_subkriteria' => 'Kualifikasi, Kecukupan, dan Kompetensi Dosen Tetap Vokasi',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.2.2.1',
                                'deskripsi_indikator' => 'Kecukupan rasio dosen tetap terhadap mahasiswa (maksimal 1:20 untuk pendidikan vokasi terapan) dan kesesuaian kualifikasi akademik minimal Magister/Magister Terapan (S2) bidang serumpun Infokom.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: 100% dosen tetap berkualifikasi S2/S3 bidang serumpun Infokom (> 30% bergelar Doktor/Doktor Terapan), rasio dosen-mahasiswa sangat ideal (1:15 s.d 1:20), dan memiliki jabatan fungsional Lektor/Lektor Kepala.',
                                    3 => 'Baik: Kualifikasi dosen memenuhi standar minimum LAM-INFOKOM, rasio dosen-mahasiswa memenuhi batas ketetapan vokasi.',
                                    2 => 'Cukup: Kualifikasi dasar terpenuhi namun rasio dosen terhadap mahasiswa melebihi ambang batas ideal.',
                                    1 => 'Kurang: Kualifikasi akademik atau jumlah dosen tetap tidak memenuhi persyaratan regulasi minimum.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.2.2.2',
                                'deskripsi_indikator' => 'Kepemilikan sertifikasi kompetensi profesional / sertifikasi industri bertaraf nasional (BNSP) atau internasional (Cisco, AWS, Oracle, Red Hat, Microsoft, Google, dll) yang masih berlaku oleh dosen tetap prodi.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: > 80% dosen tetap memiliki sertifikasi kompetensi keahlian industri TIK bertaraf internasional atau BNSP level skema advance yang masih berlaku dan relevan dengan mata kuliah yang diampu.',
                                    3 => 'Baik: > 60% dosen tetap memiliki sertifikasi kompetensi profesi/industri yang valid.',
                                    2 => 'Cukup: Persentase dosen bersertifikasi kompetensi antara 30% s.d 50%.',
                                    1 => 'Kurang: Kurang dari 30% dosen tetap yang memiliki sertifikasi kompetensi profesi.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.2.2.3',
                                'deskripsi_indikator' => 'Keterlibatan praktisi industri / tenaga ahli dari DUDI TIK dalam proses pembelajaran reguler, perkuliahan tamu, atau pembimbingan proyek akhir (Teaching Factory / Dosen Praktisi).',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Dosen praktisi industri mengajar secara berkala dengan kontribusi > 20% total SKS praktikum, terlibat dalam pengujian tugas akhir, dan menjadi mentor langsung pada Teaching Factory prodi.',
                                    3 => 'Baik: Keterlibatan dosen praktisi industri terjadwal rutin setiap semester pada mata kuliah keahlian terapan.',
                                    2 => 'Cukup: Dosen praktisi hadir hanya dalam bentuk kuliah tamu insidental (1-2 kali per semester).',
                                    1 => 'Kurang: Tidak ada keterlibatan praktisi industri dalam proses pembelajaran.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.2.3',
                        'nama_subkriteria' => 'Sarana dan Prasarana Laboratorium Komputasi Terapan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.2.3.1',
                                'deskripsi_indikator' => 'Ketersediaan, rasio kecukupan (1:1 per mahasiswa saat praktikum), dan kemutakhiran fasilitas laboratorium komputer terapan (PC workstation spesifikasi modern, server cloud lokal, IoT sandbox) yang memenuhi standar industri TIK.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Fasilitas laboratorium sangat modern, rasio workstation PC ke mahasiswa 1:1 (Intel Core i7/i9/Xeon, RAM 32-64GB, SSD NVMe, GPU discrete), server komputasi lokal, smart projector, dan lingkungan kerja ergonomis berstandar industri.',
                                    3 => 'Baik: Laboratorium komputasi memadai dengan kapasitas cukup, rasio 1:1, dan spesifikasi hardware relevan untuk pengembangan perangkat lunak modern.',
                                    2 => 'Cukup: Fasilitas laboratorium tersedia namun rasio atau spesifikasi hardware membutuhkan peremajaan berkala.',
                                    1 => 'Kurang: Sarana laboratorium tidak mencukupi untuk mendukung pelaksanaan kurikulum terapan.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.2.3.2',
                                'deskripsi_indikator' => 'Ketersediaan infrastruktur jaringan internet bandwidth tinggi (minimal 100 Mbps - 1 Gbps), lisensi perangkat lunak resmi/open-source terkelola, akses e-journal internasional (IEEE, ACM, ScienceDirect), dan LMS kampus.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Bandwidth internet dedicated sangat cepat (> 200 Mbps), akses e-journal internasional bereputasi lengkap, lisensi software/cloud tools resmi, dan sistem LMS terintegrasi dengan repository repositori Git kampus.',
                                    3 => 'Baik: Infrastruktur jaringan stabil, lisensi software resmi terpenuhi, dan akses jurnal ilmiah tersedia bagi dosen dan mahasiswa.',
                                    2 => 'Cukup: Akses internet dan software ada namun bandwidth atau ketersediaan langganan database jurnal masih terbatas.',
                                    1 => 'Kurang: Akses internet tidak stabil dan tidak memiliki lisensi software yang sah.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA C.3: RELEVANSI PENELITIAN
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
                                'deskripsi_indikator' => 'Produktivitas riset terapan dosen yang selaras dengan roadmap keilmuan infokom terapan, perolehan hibah penelitian bersaing (Kemendikbudristek/LPDP/Industri), dan pelibatan aktif mahasiswa Sarjana Terapan.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Produktivitas riset terapan dosen sangat tinggi (> 1 judul per dosen per tahun), didanai hibah kompetitif nasional/industri, dan > 70% penelitian melibatkan mahasiswa Sarjana Terapan sebagai bagian tugas akhir.',
                                    3 => 'Baik: Dosen produktif melaksanakan penelitian terapan sesuai roadmap keilmuan dan secara konsisten melibatkan mahasiswa.',
                                    2 => 'Cukup: Penelitian dosen ada namun pendanaan eksternal dan keterlibatan mahasiswa masih terbatas.',
                                    1 => 'Kurang: Produktivitas riset dosen sangat rendah dan tidak selaras dengan roadmap prodi.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.3.2',
                        'nama_subkriteria' => 'Luaran Penelitian Terapan, Publikasi, dan Hak Kekayaan Intelektual (HKI)',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.3.2.1',
                                'deskripsi_indikator' => 'Publikasi ilmiah hasil penelitian terapan dosen dan mahasiswa pada jurnal nasional terakreditasi (SINTA 1-3) atau prosiding/jurnal internasional bereputasi (Scopus / IEEE / ACM).',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Rata-rata publikasi artikel ilmiah pada jurnal terakreditasi SINTA 1-2 atau jurnal internasional bereputasi > 0.8 per dosen per tahun, dengan keterlibatan mahasiswa sebagai co-author pada mayoritas artikel.',
                                    3 => 'Baik: Publikasi ilmiah dosen dan mahasiswa memenuhi target standar tahunan pada forum terindeks nasional/internasional.',
                                    2 => 'Cukup: Publikasi ada namun dominan pada jurnal lokal non-akreditasi atau prosiding seminar internal.',
                                    1 => 'Kurang: Tidak ada publikasi ilmiah yang dihasilkan dalam kurun waktu evaluasi.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.3.2.2',
                                'deskripsi_indikator' => 'Perolehan Hak Kekayaan Intelektual (Hak Cipta Perangkat Lunak, Paten/Paten Sederhana) dan hilirisasi produk aplikasi/sistem cerdas yang diadopsi oleh industri atau masyarakat.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Perolehan HKI (Hak Cipta program komputer/paten) melampaui target (> 2 HKI per dosen tetap per tahun) dan terdapat produk perangkat lunak yang diadopsi secara komersial oleh industri/pemerintah.',
                                    3 => 'Baik: Perolehan sertifikat HKI program komputer terpenuhi dan produk terbukti dimanfaatkan oleh mitra institusi eksternal.',
                                    2 => 'Cukup: Memiliki perolehan HKI dasar namun hilirisasi atau adopsi oleh pihak eksternal belum terealisasi.',
                                    1 => 'Kurang: Tidak memiliki luaran HKI atau produk terapan yang terdaftar resmi.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA C.4: RELEVANSI PENGABDIAN KEPADA MASYARAKAT (PkM)
            [
                'kode_kriteria' => 'C.4',
                'nama_kriteria' => 'Relevansi Pengabdian kepada Masyarakat (PkM)',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.4.1',
                        'nama_subkriteria' => 'Dampak Implementasi PkM Berbasis Solusi Digital Terapan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.4.1.1',
                                'deskripsi_indikator' => 'Kualitas, relevansi, keberlanjutan, dan dampak nyata kegiatan PkM dosen bersama mahasiswa dalam mengentaskan persoalan digitalisasi pada UMKM, sekolah, organisasi nirlaba, atau pemerintahan daerah.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Kegiatan PkM berbasis digital terapan berdampak nyata, berkesinambungan (> 2 tahun pada mitra sasaran), menyelesaikan masalah krusial mitra UMKM/daerah, dan menghasilkan produk sistem yang aktif digunakan.',
                                    3 => 'Baik: Kegiatan PkM terencana sesuai roadmap keilmuan, melibatkan mahasiswa, dan memberikan solusi tepat guna kepada mitra.',
                                    2 => 'Cukup: PkM terlaksana rutin namun bersifat insidental tanpa program pendampingan pasca-kegiatan.',
                                    1 => 'Kurang: Kegiatan PkM tidak relevan dengan bidang keilmuan Infokom atau tidak memenuhi standar minimal.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA C.5: AKUNTABILITAS (FINANSIAL & LULUSAN)
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
                                'deskripsi_indikator' => 'Kecukupan alokasi dana operasional pendidikan per mahasiswa per tahun (> Rp 20 - 25 juta/mhs/tahun), alokasi dana riset/PkM terapan, transparansi, dan opini audit keuangan Wajar Tanpa Pengecualian (WTP).',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Biaya operasional pendidikan sangat memadai (> Rp 25 juta/mhs/tahun), alokasi riset/PkM > 10% total anggaran, laporan keuangan diaudit independen (opini WTP), dan memiliki diversifikasi pendapatan non-SPP yang sehat.',
                                    3 => 'Baik: Anggaran operasional memadai, audit internal berjalan tertib, dan alokasi dana Tridharma sesuai ketentuan standar mutu.',
                                    2 => 'Cukup: Pendanaan cukup untuk operasional minimum namun sangat bergantung pada pembayaran SPP mahasiswa.',
                                    1 => 'Kurang: Pengelolaan keuangan tidak transparan atau dana operasional tidak mencukupi untuk kelayakan proses pembelajaran.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'kode_subkriteria' => 'C.5.2',
                        'nama_subkriteria' => 'Masa Tunggu, Serapan Kerja, Keselarasan Karir, dan Sertifikasi Kompetensi Lulusan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.5.2.1',
                                'deskripsi_indikator' => 'Efektivitas pelaksanaan tracer study (response rate > 80%), rata-rata masa tunggu lulusan Sarjana Terapan memperoleh pekerjaan pertama di bidang TIK (< 3 bulan untuk Unggul), dan tingkat keselarasan horizontal-vertikal karir.',
                                'bobot' => 4.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Tracer study terlaksana sangat terstruktur (respon > 85%), rata-rata masa tunggu lulusan < 3 bulan, > 85% bekerja pada bidang yang relevan dengan keahlian TIK, dan rata-rata gaji pertama > 1.5 kali UMR wilayah.',
                                    3 => 'Baik: Tracer study berjalan baik, rata-rata masa tunggu 3-6 bulan, dan mayoritas lulusan bekerja pada sektor yang linier.',
                                    2 => 'Cukup: Masa tunggu rata-rata antara 6-12 bulan dan tingkat keselarasan karir belum optimal.',
                                    1 => 'Kurang: Tracer study tidak dilaksanakan secara valid atau masa tunggu lulusan melebihi 12 bulan.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.5.2.2',
                                'deskripsi_indikator' => 'Kepemilikan sertifikasi kompetensi industri TIK berstandar nasional (BNSP) atau internasional (Cisco, AWS, Oracle, Microsoft, Red Hat, dll) oleh lulusan Sarjana Terapan sebelum wisuda.',
                                'bobot' => 4.00,
                                'rubrik' => [
                                    4 => 'Sangat Baik: > 80% lulusan Sarjana Terapan memiliki minimal satu sertifikasi kompetensi keahlian profesional yang diakui secara nasional (BNSP) atau internasional yang masih berlaku saat wisuda.',
                                    3 => 'Baik: > 60% lulusan memiliki sertifikasi kompetensi keahlian industri sebelum wisuda.',
                                    2 => 'Cukup: Persentase lulusan bersertifikasi kompetensi antara 30% s.d 50%.',
                                    1 => 'Kurang: Kurang dari 30% lulusan yang memiliki sertifikasi kompetensi profesional.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA C.6: DIFERENSIASI MISI
            [
                'kode_kriteria' => 'C.6',
                'nama_kriteria' => 'Diferensiasi Misi',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'C.6.1',
                        'nama_subkriteria' => 'Keunggulan Spesifik dan Distingsi Program Studi Sarjana Terapan',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-C.6.1.1',
                                'deskripsi_indikator' => 'Bukti nyata keunggulan spesifik (distingsi) prodi Sarjana Terapan yang membedakannya dengan prodi akademik (S1) maupun prodi vokasi sejenis lainnya (misal: Center of Excellence Software Development, Teaching Factory Agile, inkubator startup teknologi vokasi).',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memiliki diferensiasi misi yang sangat jelas dan terbukti unggul di tingkat nasional/internasional, portofolio produk teknologi diakui industri, dan mahasiswa berprestasi juara kompetisi nasional secara rutin.',
                                    3 => 'Baik: Memiliki ciri khas keunggulan vokasi terapan yang terdefinisi baik dan didukung bukti prestasi mahasiswa tingkat wilayah/nasional.',
                                    2 => 'Cukup: Ada wacana diferensiasi spesialisasi prodi namun implementasi dan pembuktian prestasinya masih terbatas.',
                                    1 => 'Kurang: Tidak memiliki pembeda atau keunggulan spesifik dibanding program studi sejenis lainnya.',
                                ],
                            ],
                            [
                                'kode_indikator' => 'IND-C.6.1.2',
                                'deskripsi_indikator' => 'Capaian prestasi akademik dan non-akademik mahasiswa bidang TIK pada kompetisi bereputasi tingkat nasional dan internasional (Gemastik, KMHE, LKS Nasional, WorldSkills, AI Hackathon, kompetisi Cyber Security).',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Mahasiswa secara konsisten meraih prestasi juara 1-3 pada kompetisi bergengsi tingkat nasional (Gemastik, LKS, Hackathon nasional) atau tingkat internasional minimal 3 kejuaraan per tahun.',
                                    3 => 'Baik: Mahasiswa meraih prestasi juara pada kompetisi tingkat regional dan nasional secara berkala.',
                                    2 => 'Cukup: Mahasiswa berpartisipasi aktif dalam kompetisi namun prestasi juara masih terbatas di tingkat lokal.',
                                    1 => 'Kurang: Tidak memiliki catatan prestasi kompetisi mahasiswa dalam kurun waktu evaluasi.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // KRITERIA D: SUPLEMEN LAM-INFOKOM
            [
                'kode_kriteria' => 'D',
                'nama_kriteria' => 'Suplemen',
                'subkriteria' => [
                    [
                        'kode_subkriteria' => 'D.1',
                        'nama_subkriteria' => 'Pemenuhan Standar Suplemen Khusus dan Threshold LAM-INFOKOM',
                        'indikator' => [
                            [
                                'kode_indikator' => 'IND-D.1.1',
                                'deskripsi_indikator' => 'Pemenuhan ambang batas wajib (threshold requirements) LAM-INFOKOM mencakup kecukupan dosen berlatar belakang Infokom, ketiadaan plagiarisme (similarity index < 20%), ketersediaan repositori kode sumber institusional, dan kepatuhan lisensi komputasi.',
                                'bobot' => 3.50,
                                'rubrik' => [
                                    4 => 'Sangat Baik: Memenuhi 100% kriteria suplemen wajib LAM-INFOKOM dengan nilai sempurna, repositori open-source/institusional terkelola rapi, dan memiliki kode etik profesi komputasi yang ditegakkan dengan ketat.',
                                    3 => 'Baik: Seluruh persyaratan ambang batas suplemen LAM-INFOKOM terpenuhi tanpa catatan kekurangan.',
                                    2 => 'Cukup: Persyaratan dasar terpenuhi namun terdapat catatan perbaikan minor pada salah satu butir suplemen.',
                                    1 => 'Kurang: Gagal memenuhi salah satu ambang batas wajib (threshold) yang dipersyaratkan oleh instrumen LAM-INFOKOM.',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Seed Kriteria, Subkriteria, Indikator, dan Rubrik untuk target instrumen
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
        // 7. JENIS PEMBIAYAAN
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
        // 8. PROJECT AKREDITASI DEMO (FOKUS: SARJANA TERAPAN D4)
        // =========================================================================
        $idProdiD4 = 202;
        $idProdiD3 = 201;

        if (Schema::hasTable('prodi')) {
            try {
                $columns = Schema::getColumnListing('prodi');
                $namaCol = in_array('nama_prodi', $columns) ? 'nama_prodi' : (in_array('nama', $columns) ? 'nama' : null);

                $dataD4 = ['id' => 202];
                $dataD3 = ['id' => 201];
                if ($namaCol) {
                    $dataD4[$namaCol] = 'D4 Rekayasa Perangkat Lunak';
                    $dataD3[$namaCol] = 'D3 Teknik Informatika';
                }
                if (in_array('created_at', $columns)) {
                    $dataD4['created_at'] = now();
                    $dataD4['updated_at'] = now();
                    $dataD3['created_at'] = now();
                    $dataD3['updated_at'] = now();
                }
                DB::table('prodi')->insertOrIgnore([$dataD4, $dataD3]);
            } catch (\Throwable $e) {
                $firstProdi = DB::table('prodi')->value('id');
                if ($firstProdi) {
                    $idProdiD4 = $firstProdi;
                    $idProdiD3 = $firstProdi;
                }
            }
        }

        // Project Utama: Sarjana Terapan (D4 Rekayasa Perangkat Lunak)
        $projectSarjanaTerapan = ProjectAkreditasi::firstOrCreate(
            ['nama_project' => 'Akreditasi Program Studi Sarjana Terapan Rekayasa Perangkat Lunak 2026'],
            [
                'id_prodi' => $idProdiD4,
                'id_versi_instrumen' => $versi->id,
                'id_jenjang' => $jenjangSarjanaTerapan->id,
                'id_jenis_instrumen' => $jenisUnggul->id,
                'tahun_target_submit' => 2026,
                'status_project' => 'In Progress',
            ]
        );

        // Project Pendamping: Diploma Tiga (D3 Teknik Informatika)
        $projectDiploma = ProjectAkreditasi::firstOrCreate(
            ['nama_project' => 'Akreditasi Program Studi D3 Teknik Informatika 2026'],
            [
                'id_prodi' => $idProdiD3,
                'id_versi_instrumen' => $versi->id,
                'id_jenjang' => $jenjangDiploma->id,
                'id_jenis_instrumen' => $jenisUnggul->id,
                'tahun_target_submit' => 2026,
                'status_project' => 'Draft',
            ]
        );

        // =========================================================================
        // 9. DATA SARPRAS & SARANA PRODI DEMO (SARJANA TERAPAN)
        // =========================================================================
        $sarprasData = [
            [
                'project' => $projectSarjanaTerapan,
                'nama_lab' => 'Studio Rekayasa Perangkat Lunak & Sistem Cerdas (Software Engineering Lab)',
                'kapasitas' => 40,
                'sarana' => [
                    ['jumlah_unit' => 40, 'kondisi' => 'Sangat Baik', 'keterangan' => 'Workstation PC Intel Core i9-13900, RAM 64GB DDR5, SSD NVMe 2TB, Dual Display 27" 4K HDR'],
                    ['jumlah_unit' => 2, 'kondisi' => 'Sangat Baik', 'keterangan' => 'Local AI Inference & Build Server Dell PowerEdge R750 Dual Xeon, 128GB RAM'],
                    ['jumlah_unit' => 1, 'kondisi' => 'Baik', 'keterangan' => 'Interactive Smart Whiteboard 86" 4K Multi-touch untuk Agile Sprint Planning'],
                    ['jumlah_unit' => 2, 'kondisi' => 'Baik', 'keterangan' => 'AC Inverter Daikin 3 PK & Air Purifier Virus Doctor'],
                ],
            ],
            [
                'project' => $projectSarjanaTerapan,
                'nama_lab' => 'Laboratorium Jaringan Komputer, Keamanan Siber, & Cloud Computing',
                'kapasitas' => 36,
                'sarana' => [
                    ['jumlah_unit' => 36, 'kondisi' => 'Baik', 'keterangan' => 'PC Dual Gigabit NIC Intel Core i7 13700, 32GB RAM, SSD 1TB'],
                    ['jumlah_unit' => 8, 'kondisi' => 'Baik', 'keterangan' => 'Cisco Catalyst Managed Switch 2960 Series & Firewall Appliance Fortinet'],
                    ['jumlah_unit' => 25, 'kondisi' => 'Baik', 'keterangan' => 'IoT Edge Gateway Kit (Raspberry Pi 5 + ESP32 LoRa Array)'],
                ],
            ],
            [
                'project' => $projectDiploma,
                'nama_lab' => 'Laboratorium Rekayasa Basis Data & Komputasi Dasar',
                'kapasitas' => 35,
                'sarana' => [
                    ['jumlah_unit' => 35, 'kondisi' => 'Baik', 'keterangan' => 'Workstation Core i7, 16GB RAM, SSD 512GB, Monitor 24" Full HD'],
                    ['jumlah_unit' => 1, 'kondisi' => 'Baik', 'keterangan' => 'Projector Laser Full HD 4000 Lumens'],
                ],
            ],
        ];

        // Pastikan kolom kapasitas ada di data_sarpras_prodi jika belum ada
        if (Schema::hasTable('data_sarpras_prodi') && ! Schema::hasColumn('data_sarpras_prodi', 'kapasitas')) {
            try {
                Schema::table('data_sarpras_prodi', function (Blueprint $table) {
                    $table->integer('kapasitas')->nullable()->default(0);
                });
            } catch (\Throwable $e) {
                // Abaikan jika sudah ada
            }
        }

        foreach ($sarprasData as $data) {
            $insertMatch = [
                'id_project' => $data['project']->id,
                'keterangan' => $data['nama_lab'],
            ];
            $extraAttributes = [];

            if (Schema::hasColumn('data_sarpras_prodi', 'kapasitas')) {
                $extraAttributes['kapasitas'] = $data['kapasitas'] ?? 0;
            }

            $prasarana = DataSarprasProdi::firstOrCreate($insertMatch, $extraAttributes);

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
        // 10. DATA KEUANGAN PRODI (3 TAHUN ANGGARAN: 2024, 2025, 2026)
        // =========================================================================
        $years = [2024, 2025, 2026];
        $danaSampleSarjanaTerapan = [
            'Biaya Operasional Pendidikan (BOP)' => [1650000000, 1850000000, 2150000000],
            'Biaya Operasional Kemahasiswaan & Penalaran' => [220000000, 260000000, 310000000],
            'Biaya Penelitian Terapan Dosen & Mahasiswa' => [320000000, 380000000, 480000000],
            'Biaya Pengabdian kepada Masyarakat (PkM)' => [160000000, 190000000, 250000000],
            'Biaya Investasi Sarana & Prasarana Komputasi' => [800000000, 950000000, 1200000000],
            'Biaya Lisensi Software & Langganan Cloud' => [140000000, 175000000, 220000000],
            'Biaya Sertifikasi Kompetensi Internasional SDM' => [130000000, 160000000, 210000000],
        ];

        foreach ($pembiayaanModels as $pem) {
            if (isset($danaSampleSarjanaTerapan[$pem->nama_pembiayaan])) {
                foreach ($years as $idx => $year) {
                    DataKeuanganProdi::firstOrCreate(
                        [
                            'id_project' => $projectSarjanaTerapan->id,
                            'id_pembiayaan' => $pem->id,
                            'tahun_anggaran' => $year,
                        ],
                        [
                            'jumlah_dana' => $danaSampleSarjanaTerapan[$pem->nama_pembiayaan][$idx],
                        ]
                    );

                    DataKeuanganProdi::firstOrCreate(
                        [
                            'id_project' => $projectDiploma->id,
                            'id_pembiayaan' => $pem->id,
                            'tahun_anggaran' => $year,
                        ],
                        [
                            'jumlah_dana' => round($danaSampleSarjanaTerapan[$pem->nama_pembiayaan][$idx] * 0.8),
                        ]
                    );
                }
            }
        }

        // =========================================================================
        // 11. DATA SPMI AUDIT DEMO (SIKLUS PPEPP, AMI, RTM)
        // =========================================================================
        $firstIndikator = Indikator::first();
        $idIndikator = $firstIndikator ? $firstIndikator->id : null;

        DataSpmiAudit::firstOrCreate(
            [
                'id_project' => $projectSarjanaTerapan->id,
                'jenis_kegiatan' => 'AMI',
                'tahun_audit' => 2025,
            ],
            [
                'id_indikator' => $idIndikator,
                'tanggal_pelaksanaan' => '2025-11-15',
                'temuan' => 'Capaian Pembelajaran Lulusan (CPL) aspek rekayasa perangkat lunak berbasis cloud dan arsitektur microservices telah melampaui target minimum IKU.',
                'tindak_lanjut' => 'Penyesuaian silabus advance cloud engineering dan integrasi sertifikasi kompetensi AWS Certified Solutions Architect.',
                'status_penyelesaian' => 'Closed',
            ]
        );

        DataSpmiAudit::firstOrCreate(
            [
                'id_project' => $projectSarjanaTerapan->id,
                'jenis_kegiatan' => 'RTM',
                'tahun_audit' => 2025,
            ],
            [
                'id_indikator' => $idIndikator,
                'tanggal_pelaksanaan' => '2025-12-05',
                'temuan' => 'Metode pembelajaran Project-Based Learning (PBL) semester 6 memerlukan integrasi mentoring industri secara daring.',
                'tindak_lanjut' => 'Menandatangani MoA dengan 5 software house mitra untuk menjadi mentor industri pada mata kuliah Capstone Project.',
                'status_penyelesaian' => 'Closed',
            ]
        );

        DataSpmiAudit::firstOrCreate(
            [
                'id_project' => $projectSarjanaTerapan->id,
                'jenis_kegiatan' => 'PPEPP',
                'tahun_audit' => 2026,
            ],
            [
                'id_indikator' => $idIndikator,
                'tanggal_pelaksanaan' => '2026-01-20',
                'temuan' => 'Kebutuhan server GPU inference lokal untuk praktikum Deep Learning & NLP terapan meningkat signifikan.',
                'tindak_lanjut' => 'Realisasi penambahan 1 unit Server GPU pada alokasi belanja modal investasi triwulan I tahun anggaran 2026.',
                'status_penyelesaian' => 'Open',
            ]
        );

        // =========================================================================
        // 12. EVIDENCE SPMI PROJECT (4 PILAR PPEPP UNTUK SARJANA TERAPAN)
        // =========================================================================
        EvidenceSpmi::updateOrCreate(
            ['project_id' => $projectSarjanaTerapan->id],
            [
                'link_bukti_evaluasi' => 'https://drive.google.com/drive/folders/evaluasi-spmi-d4-rpl-2026',
                'deskripsi_bukti_evaluasi' => 'Laporan Audit Mutu Internal (AMI) Siklus 2024/2025, rekapitulasi evaluasi pembelajaran semester, dan laporan audit kesiapan akreditasi LAM-INFOKOM 2.1.',
                'link_bukti_pengendalian' => 'https://drive.google.com/drive/folders/pengendalian-spmi-d4-rpl-2026',
                'deskripsi_bukti_pengendalian' => 'Notula dan Berita Acara Rapat Tinjauan Manajemen (RTM) Jurusan, Lembar Pengendalian Temuan AMI, dan Rencana Tindak Lanjut (RTL) tertandatangani.',
                'link_bukti_dampak' => 'https://drive.google.com/drive/folders/dampak-spmi-d4-rpl-2026',
                'deskripsi_bukti_dampak' => 'Rekapitulasi ketercapaian 8 Indikator Kinerja Utama (IKU), sertifikat akreditasi internasional, dan laporan survei kepuasan mitra industri terhadap lulusan.',
                'link_dokumen_implementasi' => 'https://drive.google.com/drive/folders/implementasi-spmi-d4-rpl-2026',
                'deskripsi_dokumen_implementasi' => 'Manual Mutu SPMI, Buku Standar Pendidikan Vokasi Terapan, SOP Pembelajaran PBL, dan formulir pelaksanaan PPEPP program studi.',
            ]
        );

        // =========================================================================
        // 13. SELF ASSESSMENT REVIEWER SIMULASI (AKREDITASI UNGGUL)
        // =========================================================================
        $sampleIndikators = Indikator::whereHas('subkriteria.kriteria', function ($q) use ($instrumenSarjanaTerapan) {
            $q->where('id_instrumen', $instrumenSarjanaTerapan->id);
        })->take(8)->get();

        foreach ($sampleIndikators as $ind) {
            $rubrikUnggul = Rubrik::where('id_indikator', $ind->id)->where('skor', 4)->first();
            $bobotInd = (float) ($ind->bobot ?? 3.5);

            if ($rubrikUnggul) {
                SelfAssessment::firstOrCreate(
                    [
                        'id_project' => $projectSarjanaTerapan->id,
                        'id_indikator' => $ind->id,
                    ],
                    [
                        'id_rubrik' => $rubrikUnggul->id,
                        'skor_terbobot' => round(4.0 * $bobotInd, 2),
                        'catatan_reviewer' => 'Dokumen bukti dukung sangat komprehensif, implementasi kurikulum OBE dan pelibatan mitra industri terbukti melampaui SN-Dikti dengan capaian Terakreditasi Unggul.',
                        'tanggal_penilaian' => Carbon::now()->subDays(3),
                        'reviewer_id' => 10,
                    ]
                );
            }
        }

        // =========================================================================
        // 14. PENUGASAN TIM AKREDITASI (PJ & PIC)
        // =========================================================================
        if ($sampleIndikators->isNotEmpty()) {
            foreach ($sampleIndikators as $idx => $ind) {
                // Penanggung Jawab (PJ Kriteria)
                MappingTimAkreditasi::firstOrCreate(
                    [
                        'id_project' => $projectSarjanaTerapan->id,
                        'id_indikator' => $ind->id,
                        'role' => 'PJ',
                    ],
                    [
                        'id_user' => 101 + ($idx % 3),
                    ]
                );

                // Pelaksana (PIC Indikator)
                MappingTimAkreditasi::firstOrCreate(
                    [
                        'id_project' => $projectSarjanaTerapan->id,
                        'id_indikator' => $ind->id,
                        'role' => 'PIC',
                    ],
                    [
                        'id_user' => 104 + $idx,
                    ]
                );
            }
        }
    }
}
