<?php

namespace App\Services\Akreditasi;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\Kriteria;
use App\Models\ProjectAkreditasi;
use App\Models\SelfAssessment;
use App\Models\Subkriteria;
use App\Services\External\DosenApiService;
use App\Services\External\ProdiApiService;
use App\Services\External\TridharmaApiService;
use Illuminate\Support\Collection;

class ScoringCalculationService
{
    /**
     * Nama-nama predikat akreditasi LAM-INFOKOM.
     */
    public const PREDIKAT_UNGGUL = 'Terakreditasi Unggul';

    public const PREDIKAT_BAIK_SEKALI = 'Terakreditasi Baik Sekali';

    public const PREDIKAT_BAIK = 'Terakreditasi Baik';

    public const PREDIKAT_TIDAK_TERAKREDITASI = 'Tidak Terakreditasi';

    /**
     * Kode Kriteria Suplemen / Threshold D.
     */
    public const KRITERIA_D_CODE = 'D';

    /**
     * Skor rubrik minimum untuk memenuhi Threshold Kriteria D.
     */
    public const THRESHOLD_KRITERIA_D_MIN_SKOR = 3;

    /**
     * Batas minimum total skor untuk masing-masing predikat (desimal).
     */
    public const THRESHOLD_PREDIKAT_UNGGUL = 361.0;

    public const THRESHOLD_PREDIKAT_BAIK_SEKALI = 301.0;

    public const THRESHOLD_PREDIKAT_BAIK = 200.0;

    /**
     * Batas skor rubrik maksimum untuk kategori butir di bawah target.
     */
    public const SKOR_DI_BAWAH_TARGET_MAX = 2;

    /**
     * Skor default untuk indikator non-data (pajangan/simulasi).
     */
    public const SKOR_DEFAULT_SIMULASI = 3;

    /**
     * Daftar kode indikator non-data (pajangan).
     *
     * @var array<int, string>
     */
    public const NON_DATA_INDIKATOR_CODES = [
        'E.1.1', 'E.1.2', 'E.2.1', 'E.2.2',
        'F.1.1', 'F.1.2', 'F.2.1', 'F.2.2',
    ];

    /**
     * Menghitung skor terbobot untuk satu butir penilaian.
     *
     * @param  float|int|string  $bobot  Nilai bobot indikator
     * @param  int|null  $skorRubrik  Skor rubrik terpilih (1 - 4)
     * @return float|null Skor terbobot atau null jika belum dinilai
     */
    public function calculateItemScore(float|int|string $bobot, ?int $skorRubrik): ?float
    {
        if ($skorRubrik === null) {
            return null;
        }

        return round(((float) $bobot) * (int) $skorRubrik, 2);
    }

    /**
     * Menentukan predikat simulasi akreditasi berdasarkan total skor dan keterpenuhan Threshold D.
     * Menggunakan perbandingan desimal langsung tanpa pembulatan ke integer.
     *
     * @param  float  $totalSkor  Total akumulasi skor terbobot (skala 0 - 400)
     * @param  bool  $thresholdDMet  Status keterpenuhan ambang batas Kriteria D
     * @return string Label predikat akreditasi
     */
    public function determinePredikat(float $totalSkor, bool $thresholdDMet): string
    {
        if ($totalSkor >= self::THRESHOLD_PREDIKAT_UNGGUL) {
            return $thresholdDMet ? self::PREDIKAT_UNGGUL : self::PREDIKAT_BAIK_SEKALI;
        }

        if ($totalSkor >= self::THRESHOLD_PREDIKAT_BAIK_SEKALI) {
            return self::PREDIKAT_BAIK_SEKALI;
        }

        if ($totalSkor >= self::THRESHOLD_PREDIKAT_BAIK) {
            return self::PREDIKAT_BAIK;
        }

        return self::PREDIKAT_TIDAK_TERAKREDITASI;
    }

    /**
     * Mengkalkulasi rekapitulasi penilaian review (review-summary) untuk suatu project akreditasi.
     *
     * @param  ProjectAkreditasi|int  $project  Instance atau ID project akreditasi
     * @return array<string, mixed> Struktur data rekapitulasi skor, predikat, butir di bawah target, dan catatan reviewer
     */
    public function calculateProjectReviewSummary(ProjectAkreditasi|int $project): array
    {
        if (is_int($project)) {
            $project = ProjectAkreditasi::with(['versiInstrumen', 'jenjang', 'jenisInstrumen'])->findOrFail($project);
        }

        // Ambil seluruh penilaian self assessment yang ada untuk project ini
        $assessments = SelfAssessment::forProject($project->id)
            ->withRubrikAndIndikator()
            ->get()
            ->keyBy('id_indikator');

        // Dapatkan hierarki Kriteria -> Subkriteria -> Indikator untuk project ini
        $kriterias = $this->resolveKriteriasForProject($project, $assessments);

        $totalSkor = 0.0;
        $jumlahTotal = 0;
        $jumlahDinilai = 0;

        $rincianKriteria = [];
        $butirDiBawahTarget = [];
        $catatanReviewer = [];
        $tanggapanPenjelasanProdi = [];

        $detailSimulasi = [];
        $hasAnySimulated = false;

        $kriteriaDIndikatorCount = 0;
        $kriteriaDMetCount = 0;

        foreach ($kriterias as $kriteria) {
            $kriteriaKode = (string) $kriteria->kode_kriteria;
            $kriteriaNama = (string) $kriteria->nama_kriteria;
            $isKriteriaD = strtoupper(trim($kriteriaKode)) === self::KRITERIA_D_CODE;

            $kriteriaSkorTerbobot = 0.0;
            $kriteriaBobotTotal = 0.0;
            $kriteriaJumlahIndikator = 0;
            $kriteriaJumlahDinilai = 0;
            $indikatorList = [];

            // Kumpulkan seluruh indikator di bawah kriteria ini
            $kriteriaIndikators = $this->extractIndikatorsFromKriteria($kriteria);

            foreach ($kriteriaIndikators as $ind) {
                $jumlahTotal++;
                $kriteriaJumlahIndikator++;

                $bobot = (float) ($ind->bobot ?? 0.0);
                $kriteriaBobotTotal += $bobot;

                $kodeIndikator = (string) $ind->kode_indikator;
                $isNonData = in_array($kodeIndikator, self::NON_DATA_INDIKATOR_CODES, true);
                $indIsSimulated = false;

                $assessment = $assessments->get($ind->id);
                $hasRubrik = $assessment !== null && $assessment->id_rubrik !== null && $assessment->rubrik !== null;

                if ($hasRubrik) {
                    $skorRubrik = (int) $assessment->rubrik->skor;
                    $skorTerbobot = round($bobot * $skorRubrik, 2);
                    $status = 'dinilai';

                    $jumlahDinilai++;
                    $kriteriaJumlahDinilai++;
                    $totalSkor += $skorTerbobot;
                    $kriteriaSkorTerbobot += $skorTerbobot;

                    // Butir di bawah target (skor rubrik <= 2)
                    if ($skorRubrik <= self::SKOR_DI_BAWAH_TARGET_MAX) {
                        $butirDiBawahTarget[] = [
                            'id_assessment' => $assessment->id,
                            'id_indikator' => $ind->id,
                            'kode_indikator' => $ind->kode_indikator,
                            'deskripsi_indikator' => $ind->deskripsi_indikator,
                            'kode_kriteria' => $kriteriaKode,
                            'nama_kriteria' => $kriteriaNama,
                            'bobot' => $bobot,
                            'skor_rubrik' => $skorRubrik,
                            'skor_terbobot' => $skorTerbobot,
                            'catatan_reviewer' => $assessment->catatan_reviewer,
                            'tanggapan_kaprodi' => $assessment->tanggapan_kaprodi,
                        ];
                    }

                    // Pengecekan Threshold Kriteria D
                    if ($isKriteriaD) {
                        $kriteriaDIndikatorCount++;
                        if ($skorRubrik >= self::THRESHOLD_KRITERIA_D_MIN_SKOR) {
                            $kriteriaDMetCount++;
                        }
                    }
                } elseif ($isNonData) {
                    // Indikator non-data (pajangan) yang belum dinilai: gunakan SKOR_DEFAULT_SIMULASI
                    $skorRubrik = self::SKOR_DEFAULT_SIMULASI;
                    $skorTerbobot = round($bobot * self::SKOR_DEFAULT_SIMULASI, 2);
                    $status = 'simulasi';
                    $indIsSimulated = true;
                    $hasAnySimulated = true;

                    $totalSkor += $skorTerbobot;
                    $kriteriaSkorTerbobot += $skorTerbobot;

                    if ($isKriteriaD) {
                        $kriteriaDIndikatorCount++;
                        if ($skorRubrik >= self::THRESHOLD_KRITERIA_D_MIN_SKOR) {
                            $kriteriaDMetCount++;
                        }
                    }

                    $detailSimulasi[] = [
                        'id_indikator' => $ind->id,
                        'kode_indikator' => $ind->kode_indikator,
                        'nama_indikator' => $ind->deskripsi_indikator ?? $ind->kode_indikator,
                        'skor_default' => self::SKOR_DEFAULT_SIMULASI,
                        'keterangan' => 'Menggunakan skor default simulasi (indikator non-data)',
                    ];
                } else {
                    $skorRubrik = null;
                    $skorTerbobot = 0.0;
                    $status = 'belum_dinilai';

                    // Butir belum dinilai pada Kriteria D dihitung gagal memenuhi threshold
                    if ($isKriteriaD) {
                        $kriteriaDIndikatorCount++;
                    }
                }

                // Catatan reviewer
                if ($assessment && ! empty($assessment->catatan_reviewer)) {
                    $catatanReviewer[] = [
                        'id_assessment' => $assessment->id,
                        'id_indikator' => $ind->id,
                        'kode_indikator' => $ind->kode_indikator,
                        'deskripsi_indikator' => $ind->deskripsi_indikator,
                        'kode_kriteria' => $kriteriaKode,
                        'catatan_reviewer' => $assessment->catatan_reviewer,
                        'tanggapan_kaprodi' => $assessment->tanggapan_kaprodi,
                    ];
                }

                // Tanggapan / Penjelasan prodi
                if ($assessment && ! empty($assessment->tanggapan_kaprodi)) {
                    $tanggapanPenjelasanProdi[] = [
                        'id_assessment' => $assessment->id,
                        'id_indikator' => $ind->id,
                        'kode_indikator' => $ind->kode_indikator,
                        'deskripsi_indikator' => $ind->deskripsi_indikator,
                        'kode_kriteria' => $kriteriaKode,
                        'catatan_reviewer' => $assessment->catatan_reviewer,
                        'tanggapan_kaprodi' => $assessment->tanggapan_kaprodi,
                    ];
                }

                $indikatorList[] = [
                    'id_assessment' => $assessment?->id,
                    'id_indikator' => $ind->id,
                    'kode_indikator' => $ind->kode_indikator,
                    'deskripsi_indikator' => $ind->deskripsi_indikator,
                    'bobot' => $bobot,
                    'id_rubrik' => $hasRubrik ? $assessment->id_rubrik : null,
                    'skor_rubrik' => $skorRubrik,
                    'skor_terbobot' => $skorTerbobot,
                    'status' => $status,
                    'is_simulated' => $indIsSimulated,
                    'catatan_reviewer' => $assessment?->catatan_reviewer,
                    'tanggapan_kaprodi' => $assessment?->tanggapan_kaprodi,
                    'tanggal_penilaian' => $assessment?->tanggal_penilaian?->toISOString(),
                    'reviewer_id' => $assessment?->reviewer_id,
                ];
            }

            $rincianKriteria[] = [
                'id_kriteria' => $kriteria->id,
                'kode_kriteria' => $kriteriaKode,
                'nama_kriteria' => $kriteriaNama,
                'total_skor_terbobot' => round($kriteriaSkorTerbobot, 2),
                'total_bobot' => round($kriteriaBobotTotal, 2),
                'jumlah_indikator' => $kriteriaJumlahIndikator,
                'jumlah_dinilai' => $kriteriaJumlahDinilai,
                'jumlah_belum_dinilai' => $kriteriaJumlahIndikator - $kriteriaJumlahDinilai,
                'indikator' => $indikatorList,
            ];
        }

        // Kriteria D terpenuhi jika ada indikator Kriteria D dan seluruhnya berskor >= THRESHOLD_KRITERIA_D_MIN_SKOR
        $thresholdDMet = ($kriteriaDIndikatorCount > 0) && ($kriteriaDMetCount === $kriteriaDIndikatorCount);

        $totalSkorFinal = round($totalSkor, 2);
        $predikat = $this->determinePredikat($totalSkorFinal, $thresholdDMet);

        return [
            'project_id' => $project->id,
            'nama_project' => $project->nama_project,
            'tahun_target_submit' => $project->tahun_target_submit,
            'status_project' => $project->status_project,
            'total_skor' => $totalSkorFinal,
            'predikat' => $predikat,
            'is_simulated' => $hasAnySimulated,
            'detail_simulasi' => $detailSimulasi,
            'threshold_kriteria_d' => [
                'kode_kriteria' => self::KRITERIA_D_CODE,
                'terpenuhi' => $thresholdDMet,
                'skor_minimum' => self::THRESHOLD_KRITERIA_D_MIN_SKOR,
                'jumlah_indikator' => $kriteriaDIndikatorCount,
                'jumlah_memenuhi' => $kriteriaDMetCount,
                'keterangan' => $thresholdDMet
                    ? 'Memenuhi ambang batas wajib Kriteria D (seluruh butir berskor >= '.self::THRESHOLD_KRITERIA_D_MIN_SKOR.')'
                    : 'Belum memenuhi ambang batas wajib Kriteria D (minimal skor rubrik '.self::THRESHOLD_KRITERIA_D_MIN_SKOR.')',
            ],
            'jumlah_total' => $jumlahTotal,
            'jumlah_dinilai' => $jumlahDinilai,
            'jumlah_belum_dinilai' => $jumlahTotal - $jumlahDinilai,
            'persentase_kelengkapan' => $jumlahTotal > 0 ? round(($jumlahDinilai / $jumlahTotal) * 100, 2) : 0.0,
            'rincian_kriteria' => $rincianKriteria,
            'butir_di_bawah_target' => $butirDiBawahTarget,
            'catatan_reviewer' => $catatanReviewer,
            'tanggapan_penjelasan_prodi' => $tanggapanPenjelasanProdi,
        ];
    }

    /**
     * Mengumpulkan koleksi model Kriteria yang relevan untuk project.
     * Menggunakan hierarki instrumen dengan fallback ke kriteria pada self-assessment.
     *
     * @param  Collection<int, SelfAssessment>  $assessments
     * @return Collection<int, Kriteria>
     */
    protected function resolveKriteriasForProject(ProjectAkreditasi $project, $assessments)
    {
        // 1. Coba cari Instrumen yang cocok dengan konfigurasi project
        $instrumen = Instrumen::where('id_versi_instrumen', $project->id_versi_instrumen)
            ->where('id_jenjang', $project->id_jenjang)
            ->where('id_jenis_instrumen', $project->id_jenis_instrumen)
            ->first();

        if ($instrumen) {
            $kriterias = Kriteria::where('id_instrumen', $instrumen->id)
                ->with([
                    'subkriteria' => fn ($q) => $q->orderBy('kode_subkriteria'),
                    'subkriteria.indikator' => fn ($q) => $q->orderBy('kode_indikator'),
                ])
                ->orderBy('kode_kriteria')
                ->get();

            if ($kriterias->isNotEmpty()) {
                return $kriterias;
            }
        }

        // 2. Fallback: ambil kriteria berdasarkan indikator yang ada di self-assessment
        $indikatorIds = $assessments->keys()->all();
        if (! empty($indikatorIds)) {
            $kriterias = Kriteria::whereHas('subkriteria.indikator', function ($q) use ($indikatorIds) {
                $q->whereIn('id', $indikatorIds);
            })->with([
                'subkriteria' => fn ($q) => $q->orderBy('kode_subkriteria'),
                'subkriteria.indikator' => fn ($q) => $q->orderBy('kode_indikator'),
            ])->orderBy('kode_kriteria')->get();

            if ($kriterias->isNotEmpty()) {
                return $kriterias;
            }
        }

        // 3. Fallback umum: ambil seluruh kriteria yang ada di sistem
        return Kriteria::with([
            'subkriteria' => fn ($q) => $q->orderBy('kode_subkriteria'),
            'subkriteria.indikator' => fn ($q) => $q->orderBy('kode_indikator'),
        ])->orderBy('kode_kriteria')->get();
    }

    /**
     * Mengekstrak seluruh Indikator dari relasi Subkriteria pada Kriteria.
     *
     * @return Collection<int, Indikator>
     */
    protected function extractIndikatorsFromKriteria(Kriteria $kriteria)
    {
        $indikators = collect();

        foreach ($kriteria->subkriteria as $sub) {
            foreach ($sub->indikator as $ind) {
                $indikators->push($ind);
            }
        }

        return $indikators;
    }

    /**
     * Menghitung hasil simulasi akreditasi dengan rekapitulasi per subkriteria,
     * Nilai Akhir (total_na), predikat, flag simulasi, dan status minimum terpenuhi.
     *
     * @return array<string, mixed>
     */
    public function calculateScoringResult(ProjectAkreditasi|int $project): array
    {
        $summary = $this->calculateProjectReviewSummary($project);

        // Indeks data kalkulasi indikator dari review-summary
        $calculatedIndikators = [];
        foreach ($summary['rincian_kriteria'] as $kriteria) {
            foreach ($kriteria['indikator'] as $indItem) {
                $calculatedIndikators[$indItem['id_indikator']] = $indItem;
            }
        }

        $indikatorIds = array_keys($calculatedIndikators);

        // Query independen ke model Subkriteria untuk indikator project terkait
        $subkriterias = Subkriteria::whereHas('indikator', function ($q) use ($indikatorIds) {
            $q->whereIn('id', $indikatorIds);
        })->with(['indikator' => function ($q) use ($indikatorIds) {
            $q->whereIn('id', $indikatorIds)->orderBy('kode_indikator');
        }])->orderBy('kode_subkriteria')->get();

        $skorPerSubkriteria = [];
        foreach ($subkriterias as $sub) {
            $subSkorTerbobot = 0.0;
            $subJumlahIndikator = 0;
            $subJumlahDinilai = 0;

            foreach ($sub->indikator as $ind) {
                $calc = $calculatedIndikators[$ind->id] ?? null;
                if (! $calc) {
                    continue;
                }

                $subJumlahIndikator++;
                $subSkorTerbobot += (float) ($calc['skor_terbobot'] ?? 0.0);

                if (($calc['status'] ?? '') === 'dinilai') {
                    $subJumlahDinilai++;
                }
            }

            $skorPerSubkriteria[] = [
                'id_subkriteria' => (int) $sub->id,
                'kode_subkriteria' => (string) $sub->kode_subkriteria,
                'nama_subkriteria' => (string) $sub->nama_subkriteria,
                'total_skor_terbobot' => round($subSkorTerbobot, 2),
                'jumlah_indikator' => $subJumlahIndikator,
                'jumlah_dinilai' => $subJumlahDinilai,
            ];
        }

        return [
            'project_id' => (int) $summary['project_id'],
            'nama_project' => (string) $summary['nama_project'],
            'total_na' => (float) $summary['total_skor'],
            'predikat' => (string) $summary['predikat'],
            'skor_per_subkriteria' => $skorPerSubkriteria,
            'is_simulated' => (bool) $summary['is_simulated'],
            'minimum_not_met' => ! (bool) ($summary['threshold_kriteria_d']['terpenuhi'] ?? false),
            'detail_simulasi' => $summary['detail_simulasi'],
        ];
    }

    /**
     * Menjalankan simulasi skor kuantitatif SDM Dosen LAM-INFOKOM terintegrasi data live Kelompok 2.
     *
     * Menghitung 3 butir kuantitatif SDM Dosen LAM-INFOKOM pada skala skor 0 - 4:
     * 1. RMD  : Rasio Mahasiswa terhadap Dosen Tetap Homebase
     * 2. PDS3 : Persentase Dosen Tetap Homebase berpendidikan Doktor / S3
     * 3. PJLK : Persentase Dosen Tetap Homebase berpangkat Lektor Kepala & Guru Besar
     *
     * Kontrak Output JSON:
     * {
     *   "skor_per_subkriteria": {
     *     "rmd": { "nilai": 0, "skor": 0.0 },
     *     "pds3": { "persentase": 0, "skor": 0.0 },
     *     "pjlk": { "persentase": 0, "skor": 0.0 }
     *   },
     *   "total_na": 0.0,
     *   "is_simulated": true,
     *   "minimum_not_met": false
     * }
     *
     * Business Rule Homebase:
     * Jika total dosen tetap homebase < 5, minimum_not_met bernilai true dan disertakan pesan peringatan.
     *
     * @param  ProjectAkreditasi  $project  Instance project akreditasi
     * @param  int  $mahasiswaInput  Jumlah mahasiswa aktif (opsional / parameter override)
     * @return array{
     *     skor_per_subkriteria: array{
     *         rmd: array{nilai: float|int, skor: float},
     *         pds3: array{persentase: float|int, skor: float},
     *         pjlk: array{persentase: float|int, skor: float}
     *     },
     *     total_na: float,
     *     is_simulated: bool,
     *     minimum_not_met: bool,
     *     warning?: string
     * }
     */
    public function simulateDosenScoring(ProjectAkreditasi $project, int $mahasiswaInput = 0): array
    {
        $allDosen = app(DosenApiService::class)->getAllDosen();

        // Filter dosen tetap yang memiliki status homebase aktif
        $homebaseDosen = array_values(array_filter($allDosen, function ($dosen) {
            return filter_var($dosen['status_homebase'] ?? false, FILTER_VALIDATE_BOOLEAN);
        }));

        $totalDth = count($homebaseDosen);
        $minimumNotMet = $totalDth < 5;

        $jumlahMahasiswa = $this->resolveJumlahMahasiswa($project, $mahasiswaInput);

        $rmdResult = $this->calculateRmd($jumlahMahasiswa, $totalDth);
        $pds3Result = $this->calculatePds3($homebaseDosen, $totalDth);
        $pjlkResult = $this->calculatePjlk($homebaseDosen, $totalDth);

        $totalNa = round(($rmdResult['skor'] + $pds3Result['skor'] + $pjlkResult['skor']) / 3.0, 2);

        $tridharmaSummary = app(TridharmaApiService::class)->getSummary();
        $mkSummary = app(ProdiApiService::class)->getMataKuliahSummary();

        $rincianKuantitatif = $this->buildQuantitativeIndicatorsBreakdown(
            $totalDth,
            $totalNa,
            $rmdResult,
            $pds3Result,
            $tridharmaSummary,
            $mkSummary
        );

        $totalSkorKuantitatif = round(array_sum(array_column($rincianKuantitatif, 'skor_terbobot')), 2);
        $totalBobotKuantitatif = array_sum(array_column($rincianKuantitatif, 'bobot'));
        $skorMaksimalKuantitatif = round($totalBobotKuantitatif * 4.0, 2);
        $persentaseCapaian = $skorMaksimalKuantitatif > 0
            ? round(($totalSkorKuantitatif / $skorMaksimalKuantitatif) * 100.0, 2)
            : 0.0;

        // Proyeksi skala 400 dari proporsi capaian kuantitatif
        $proyeksiSkala400 = round(($persentaseCapaian / 100.0) * 400.0, 2);
        $publikasiButir = collect($rincianKuantitatif)->firstWhere('kode_butir', '3.2.C');
        $publikasiSkor = (float) ($publikasiButir['nilai_mentah'] ?? 0.0);
        $thresholdDtpsMet = $totalNa >= 3.5 && ! $minimumNotMet;
        $thresholdPublikasiMet = $publikasiSkor >= 3.5;
        $thresholdUnggulMet = $thresholdDtpsMet && $thresholdPublikasiMet;

        $response = [
            'skor_per_subkriteria' => [
                'rmd' => $rmdResult,
                'pds3' => $pds3Result,
                'pjlk' => $pjlkResult,
            ],
            'total_na' => $totalNa,
            'is_simulated' => true,
            'minimum_not_met' => $minimumNotMet,
            'rincian_butir_kuantitatif' => $rincianKuantitatif,
            'ringkasan_kuantitatif' => [
                'jumlah_butir_terhitung' => count($rincianKuantitatif),
                'total_bobot_kuantitatif' => $totalBobotKuantitatif,
                'total_skor_kuantitatif' => $totalSkorKuantitatif,
                'skor_maksimal_kuantitatif' => $skorMaksimalKuantitatif,
                'persentase_capaian' => $persentaseCapaian,
                'proyeksi_skor_skala_400' => $proyeksiSkala400,
                'predikat_proyeksi' => $this->determinePredikat($proyeksiSkala400, $thresholdUnggulMet),
                'threshold_syarat_unggul' => [
                    'terpenuhi' => $thresholdUnggulMet,
                    'dtps_ge_3_5' => $thresholdDtpsMet,
                    'publikasi_ge_3_5' => $thresholdPublikasiMet,
                ],
            ],
        ];

        if ($minimumNotMet) {
            $response['warning'] = 'Jumlah dosen tetap homebase kurang dari 5 (syarat minimum LAM-INFOKOM tidak terpenuhi).';
        }

        return $response;
    }

    /**
     * Menyusun rincian skor kuantitatif untuk seluruh indikator LAM-INFOKOM yang tersedia di API K1 & K2.
     *
     * @param  array{nilai: float|int, skor: float}  $rmdResult
     * @param  array{persentase: float|int, skor: float}  $pds3Result
     * @param  array<string, mixed>  $tridharma
     * @param  array<string, int>  $mkSummary
     * @return array<int, array<string, mixed>>
     */
    protected function buildQuantitativeIndicatorsBreakdown(
        int $totalDth,
        float $totalNaDosen,
        array $rmdResult,
        array $pds3Result,
        array $tridharma,
        array $mkSummary
    ): array {
        $penelitian = $tridharma['penelitian'] ?? [];
        $pkm = $tridharma['pkm'] ?? [];
        $publikasi = $tridharma['publikasi'] ?? [];
        $hki = $tridharma['hki'] ?? [];
        $kerjasamaAktif = (int) ($tridharma['kerjasama_dudika_aktif'] ?? 0);

        $penelitianScore = $this->calculatePenelitianScore($penelitian, $totalDth);
        $publikasiScore = $this->calculatePublikasiHkiScore($publikasi, $hki, $totalDth);
        $pkmScore = $this->calculatePkmScore($pkm, $hki, $totalDth);
        $diferensiasiScore = $this->calculateDiferensiasiScore($kerjasamaAktif);
        $suplemenScore = $this->calculateSuplemenScore($mkSummary, $hki);

        return [
            [
                'kode_butir' => '2.2.A',
                'elemen' => 'Dosen Tetap (DTPR), Rasio RMD, S3, & Jabatan Akademik',
                'bobot' => 9,
                'nilai_mentah' => $totalNaDosen,
                'skor_terbobot' => round(9 * $totalNaDosen, 2),
                'sumber_data' => 'API Tridharma (/api/dosen) & Akademik (/api/mahasiswa)',
                'formula' => "DTH={$totalDth}; RMD={$rmdResult['nilai']} (skor {$rmdResult['skor']}); S3={$pds3Result['persentase']}% (skor {$pds3Result['skor']})",
            ],
            [
                'kode_butir' => '3.2.A',
                'elemen' => 'Pelaksanaan Kegiatan Penelitian Dosen Sesuai Roadmap',
                'bobot' => 8,
                'nilai_mentah' => $penelitianScore['skor_pelaksanaan'],
                'skor_terbobot' => round(8 * $penelitianScore['skor_pelaksanaan'], 2),
                'sumber_data' => 'API Tridharma (/api/kegiatan?id_jenis_kegiatan=1)',
                'formula' => $penelitianScore['formula_pelaksanaan'],
            ],
            [
                'kode_butir' => '3.2.B',
                'elemen' => 'Pelibatan Mahasiswa dalam Penelitian Dosen',
                'bobot' => 6,
                'nilai_mentah' => $penelitianScore['skor_mahasiswa'],
                'skor_terbobot' => round(6 * $penelitianScore['skor_mahasiswa'], 2),
                'sumber_data' => 'API Tridharma (/api/kegiatan relasi anggota)',
                'formula' => $penelitianScore['formula_mahasiswa'],
            ],
            [
                'kode_butir' => '3.2.C',
                'elemen' => 'Produktivitas Publikasi Ilmiah (Scopus/SINTA/IEEE) & HKI',
                'bobot' => 18,
                'nilai_mentah' => $publikasiScore['skor'],
                'skor_terbobot' => round(18 * $publikasiScore['skor'], 2),
                'sumber_data' => 'API Tridharma (/api/luaran)',
                'formula' => $publikasiScore['formula'],
            ],
            [
                'kode_butir' => '4.2.A',
                'elemen' => 'Pelaksanaan Pengabdian kepada Masyarakat (PkM) Dosen',
                'bobot' => 7,
                'nilai_mentah' => $pkmScore['skor_pelaksanaan'],
                'skor_terbobot' => round(7 * $pkmScore['skor_pelaksanaan'], 2),
                'sumber_data' => 'API Tridharma (/api/kegiatan?id_jenis_kegiatan=2)',
                'formula' => $pkmScore['formula_pelaksanaan'],
            ],
            [
                'kode_butir' => '4.2.B',
                'elemen' => 'Pelibatan Mahasiswa dalam Kegiatan PkM',
                'bobot' => 6,
                'nilai_mentah' => $pkmScore['skor_mahasiswa'],
                'skor_terbobot' => round(6 * $pkmScore['skor_mahasiswa'], 2),
                'sumber_data' => 'API Tridharma (/api/kegiatan relasi anggota)',
                'formula' => $pkmScore['formula_mahasiswa'],
            ],
            [
                'kode_butir' => '4.2.C',
                'elemen' => 'Dampak & Luaran PkM (Publikasi PkM & HKI Teknologi Tepat Guna)',
                'bobot' => 15,
                'nilai_mentah' => $pkmScore['skor_luaran'],
                'skor_terbobot' => round(15 * $pkmScore['skor_luaran'], 2),
                'sumber_data' => 'API Tridharma (/api/luaran)',
                'formula' => $pkmScore['formula_luaran'],
            ],
            [
                'kode_butir' => '6.2',
                'elemen' => 'Pelaksanaan Tridarma Khas Keilmuan & Kemitraan DUDIKA',
                'bobot' => 8,
                'nilai_mentah' => $diferensiasiScore['skor'],
                'skor_terbobot' => round(8 * $diferensiasiScore['skor'], 2),
                'sumber_data' => 'API Tridharma (/api/kerja-sama)',
                'formula' => $diferensiasiScore['formula'],
            ],
            [
                'kode_butir' => 'Suplemen 1-5',
                'elemen' => 'Suplemen Program Sarjana Infokom (Inti, Domain TRK, Math, Capstone, Produk)',
                'bobot' => 20,
                'nilai_mentah' => $suplemenScore['skor'],
                'skor_terbobot' => round(20 * $suplemenScore['skor'], 2),
                'sumber_data' => 'API Akademik (/api/mata-kuliah) & Tridharma (/api/luaran)',
                'formula' => $suplemenScore['formula'],
            ],
        ];
    }

    /**
     * Menghitung skor Butir 3.2.A & 3.2.B (Penelitian & Pelibatan Mahasiswa).
     *
     * @param  array<string, mixed>  $penelitian
     * @return array{skor_pelaksanaan: float, skor_mahasiswa: float, formula_pelaksanaan: string, formula_mahasiswa: string}
     */
    protected function calculatePenelitianScore(array $penelitian, int $totalDth): array
    {
        $total = (int) ($penelitian['total_kegiatan'] ?? 0);
        $mhs = (int) ($penelitian['melibatkan_mahasiswa'] ?? 0);
        $hibahNasional = (int) ($penelitian['hibah_nasional_bima'] ?? 0);
        $divisor = max(1, $totalDth);

        // Rasio judul penelitian per dosen + bonus hibah nasional
        $rasioPerDosen = $total / $divisor;
        $skorPelaksanaan = min(4.0, round(2.0 + ($rasioPerDosen * 1.0) + min(0.8, $hibahNasional * 0.1), 2));

        $persenMhs = $total > 0 ? round(($mhs / $total) * 100.0, 2) : 0.0;
        $skorMahasiswa = $persenMhs >= 75.0
            ? 4.0
            : min(4.0, round(1.5 + ($persenMhs / 100.0) * 3.0, 2));

        return [
            'skor_pelaksanaan' => $skorPelaksanaan,
            'skor_mahasiswa' => $skorMahasiswa,
            'formula_pelaksanaan' => "Total riset={$total}, Hibah Nasional={$hibahNasional}, Rasio/DTPS=".round($rasioPerDosen, 2),
            'formula_mahasiswa' => "Riset libatkan mhs={$mhs}/{$total} ({$persenMhs}%)",
        ];
    }

    /**
     * Menghitung skor Butir 3.2.C (Produktivitas Publikasi Ilmiah & HKI).
     *
     * @param  array<string, mixed>  $publikasi
     * @param  array<string, mixed>  $hki
     * @return array{skor: float, formula: string}
     */
    protected function calculatePublikasiHkiScore(array $publikasi, array $hki, int $totalDth): array
    {
        $scopus = (int) ($publikasi['jurnal_internasional_scopus'] ?? 0);
        $sinta = (int) ($publikasi['jurnal_nasional_sinta'] ?? 0);
        $ieee = (int) ($publikasi['prosiding_seminar_ieee'] ?? 0);
        $paten = (int) ($hki['paten_terdaftar'] ?? 0);
        $hakCipta = (int) ($hki['hak_cipta_program_komputer'] ?? 0);

        $divisor = max(1, $totalDth);
        $poinTertimbang = ($scopus * 3.0) + ($sinta * 1.0) + ($ieee * 1.5) + ($paten * 3.0) + ($hakCipta * 1.0);
        $rasioProduktivitas = $poinTertimbang / $divisor;

        $skor = min(4.0, round(1.5 + min(2.5, $rasioProduktivitas * 0.35), 2));

        return [
            'skor' => $skor,
            'formula' => "Scopus={$scopus}, SINTA={$sinta}, IEEE={$ieee}, Paten={$paten}, Hak Cipta={$hakCipta} (Indeks/DTPS=".round($rasioProduktivitas, 2).')',
        ];
    }

    /**
     * Menghitung skor Butir 4.2.A, 4.2.B, & 4.2.C (PkM, Pelibatan Mhs, & Luaran Terapan).
     *
     * @param  array<string, mixed>  $pkm
     * @param  array<string, mixed>  $hki
     * @return array{skor_pelaksanaan: float, skor_mahasiswa: float, skor_luaran: float, formula_pelaksanaan: string, formula_mahasiswa: string, formula_luaran: string}
     */
    protected function calculatePkmScore(array $pkm, array $hki, int $totalDth): array
    {
        $total = (int) ($pkm['total_kegiatan'] ?? 0);
        $mhs = (int) ($pkm['melibatkan_mahasiswa'] ?? 0);
        $hibahNasional = (int) ($pkm['hibah_pkm_nasional'] ?? 0);
        $hakCipta = (int) ($hki['hak_cipta_program_komputer'] ?? 0);
        $divisor = max(1, $totalDth);

        $rasioPerDosen = $total / $divisor;
        $skorPelaksanaan = min(4.0, round(2.0 + ($rasioPerDosen * 1.2) + min(0.6, $hibahNasional * 0.15), 2));

        $persenMhs = $total > 0 ? round(($mhs / $total) * 100.0, 2) : 0.0;
        $skorMahasiswa = $persenMhs >= 75.0
            ? 4.0
            : min(4.0, round(1.5 + ($persenMhs / 100.0) * 3.0, 2));

        $skorLuaran = min(4.0, round(2.0 + min(2.0, ($hakCipta + $hibahNasional) * 0.08), 2));

        return [
            'skor_pelaksanaan' => $skorPelaksanaan,
            'skor_mahasiswa' => $skorMahasiswa,
            'skor_luaran' => $skorLuaran,
            'formula_pelaksanaan' => "Total PkM={$total}, Hibah Nasional={$hibahNasional}",
            'formula_mahasiswa' => "PkM libatkan mhs={$mhs}/{$total} ({$persenMhs}%)",
            'formula_luaran' => "HKI produk terapan={$hakCipta}, Hibah PkM Nasional={$hibahNasional}",
        ];
    }

    /**
     * Menghitung skor Butir 6.2 (Kemitraan DUDIKA aktif).
     *
     * @return array{skor: float, formula: string}
     */
    protected function calculateDiferensiasiScore(int $kerjasamaAktif): array
    {
        $skor = $kerjasamaAktif >= 10
            ? 4.0
            : min(4.0, round(1.5 + ($kerjasamaAktif * 0.25), 2));

        return [
            'skor' => $skor,
            'formula' => "Kerjasama DUDIKA aktif={$kerjasamaAktif} mitra",
        ];
    }

    /**
     * Menghitung skor Suplemen 1-5 (Kurikulum Inti, Domain TRK, Matematika, Capstone, & Produk Terapan).
     *
     * @param  array<string, int>  $mkSummary
     * @param  array<string, mixed>  $hki
     * @return array{skor: float, formula: string}
     */
    protected function calculateSuplemenScore(array $mkSummary, array $hki): array
    {
        $terpenuhi = 0;
        if (($mkSummary['mk_inti_komputasi'] ?? 0) >= 5) {
            $terpenuhi++;
        }
        if (($mkSummary['mk_domain_trk'] ?? 0) >= 3) {
            $terpenuhi++;
        }
        if (($mkSummary['mk_matematika'] ?? 0) >= 2) {
            $terpenuhi++;
        }
        if (($mkSummary['mk_capstone'] ?? 0) >= 1) {
            $terpenuhi++;
        }
        if (((int) ($hki['hak_cipta_program_komputer'] ?? 0) + (int) ($hki['paten_terdaftar'] ?? 0)) >= 1) {
            $terpenuhi++;
        }

        $skor = round(($terpenuhi / 5.0) * 4.0, 2);

        return [
            'skor' => $skor,
            'formula' => "Terpenuhi {$terpenuhi}/5 komponen suplemen (Inti={$mkSummary['mk_inti_komputasi']}, Domain={$mkSummary['mk_domain_trk']}, Math={$mkSummary['mk_matematika']}, Capstone={$mkSummary['mk_capstone']})",
        ];
    }

    /**
     * Menghitung RMD (Rasio Mahasiswa terhadap Dosen Tetap Homebase) dan skornya (0 - 4).
     *
     * @return array{nilai: float|int, skor: float}
     */
    protected function calculateRmd(int $jumlahMahasiswa, int $totalDth): array
    {
        if ($totalDth <= 0) {
            return [
                'nilai' => 0,
                'skor' => 0.0,
            ];
        }

        $rmd = round($jumlahMahasiswa / $totalDth, 2);

        if ($rmd >= 15 && $rmd <= 25) {
            $skor = 4.0;
        } elseif ($rmd < 15 && $rmd > 0) {
            $skor = round((4.0 * $rmd) / 15.0, 2);
        } elseif ($rmd > 25 && $rmd <= 35) {
            $skor = round((35.0 - $rmd) / 2.5, 2);
        } else {
            $skor = 0.0;
        }

        $skor = max(0.0, min(4.0, $skor));

        return [
            'nilai' => $rmd,
            'skor' => $skor,
        ];
    }

    /**
     * Menghitung PDS3 (Persentase Dosen S3/Doktor) dan skornya (0 - 4).
     *
     * @param  array<int, array<string, mixed>>  $homebaseDosen
     * @return array{persentase: float|int, skor: float}
     */
    protected function calculatePds3(array $homebaseDosen, int $totalDth): array
    {
        if ($totalDth <= 0) {
            return [
                'persentase' => 0,
                'skor' => 0.0,
            ];
        }

        $totalS3 = count(array_filter($homebaseDosen, fn ($d) => $this->isDoktor($d)));
        $persentase = round(($totalS3 / $totalDth) * 100.0, 2);

        if ($persentase >= 50.0) {
            $skor = 4.0;
        } else {
            $skor = round(2.0 + (4.0 * ($persentase / 100.0)), 2);
        }

        $skor = max(0.0, min(4.0, $skor));

        return [
            'persentase' => $persentase,
            'skor' => $skor,
        ];
    }

    /**
     * Menghitung PJLK (Persentase Dosen Lektor Kepala & Guru Besar) dan skornya (0 - 4).
     *
     * @param  array<int, array<string, mixed>>  $homebaseDosen
     * @return array{persentase: float|int, skor: float}
     */
    protected function calculatePjlk(array $homebaseDosen, int $totalDth): array
    {
        if ($totalDth <= 0) {
            return [
                'persentase' => 0,
                'skor' => 0.0,
            ];
        }

        $totalLkGb = count(array_filter($homebaseDosen, fn ($d) => $this->isLektorKepalaOrGuruBesar($d)));
        $persentase = round(($totalLkGb / $totalDth) * 100.0, 2);

        if ($persentase >= 70.0) {
            $skor = 4.0;
        } else {
            $skor = round(2.0 + (2.0 * ($persentase / 70.0)), 2);
        }

        $skor = max(0.0, min(4.0, $skor));

        return [
            'persentase' => $persentase,
            'skor' => $skor,
        ];
    }

    /**
     * Menentukan estimasi jumlah mahasiswa aktif untuk project akreditasi.
     */
    private function resolveJumlahMahasiswa(ProjectAkreditasi $project, int $mahasiswaInput): int
    {
        if ($mahasiswaInput > 0) {
            return $mahasiswaInput;
        }

        $sarprasKapasitas = (int) $project->dataSarprasProdi()->sum('kapasitas');
        if ($sarprasKapasitas > 0) {
            return $sarprasKapasitas;
        }

        $apiMahasiswaCount = app(ProdiApiService::class)->getMahasiswaAktifCount();

        return $apiMahasiswaCount > 0 ? $apiMahasiswaCount : 100;
    }

    /**
     * Mendeteksi kualifikasi akademik Doktor / S3 dari gelar atau nama lengkap dosen.
     *
     * @param  array<string, mixed>  $dosen
     */
    private function isDoktor(array $dosen): bool
    {
        $gelar = strtoupper((string) ($dosen['gelar'] ?? ''));
        $nama = strtoupper((string) ($dosen['nama_lengkap'] ?? $dosen['nama'] ?? ''));

        return str_contains($gelar, 'S3')
            || str_contains($gelar, 'DOKTOR')
            || str_contains($gelar, 'PH.D')
            || str_contains($gelar, 'DR.')
            || str_contains($nama, 'DR.')
            || str_contains($nama, 'PH.D');
    }

    /**
     * Mendeteksi jabatan fungsional Lektor Kepala atau Guru Besar / Profesor.
     *
     * @param  array<string, mixed>  $dosen
     */
    private function isLektorKepalaOrGuruBesar(array $dosen): bool
    {
        $jafung = strtoupper((string) ($dosen['jabatan_fungsional'] ?? ''));

        return str_contains($jafung, 'LEKTOR KEPALA')
            || str_contains($jafung, 'GURU BESAR')
            || str_contains($jafung, 'PROFESOR');
    }
}
