<?php

namespace App\Services\Akreditasi;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\Kriteria;
use App\Models\ProjectAkreditasi;
use App\Models\SelfAssessment;

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
        $assessments = SelfAssessment::with(['rubrik', 'indikator.subkriteria.kriteria'])
            ->where('id_project', $project->id)
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
     * @param  ProjectAkreditasi  $project
     * @param  \Illuminate\Support\Collection<int, SelfAssessment>  $assessments
     * @return \Illuminate\Support\Collection<int, Kriteria>
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
     * @param  Kriteria  $kriteria
     * @return \Illuminate\Support\Collection<int, Indikator>
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
}
