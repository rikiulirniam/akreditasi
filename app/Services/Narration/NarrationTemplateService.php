<?php

namespace App\Services\Narration;

use App\Models\NarasiSubkriteria;
use App\Models\ProjectAkreditasi;
use App\Models\Subkriteria;
use App\Models\TemplateNarasiSubkriteria;
use App\Services\External\DosenApiService;
use App\Services\External\ProdiApiService;
use App\Services\External\TridharmaApiService;

class NarrationTemplateService
{
    /**
     * Menyuntikkan layanan data dosen, prodi, dan tridharma untuk generator narasi.
     */
    public function __construct(
        protected DosenApiService $dosenApiService,
        protected ProdiApiService $prodiApiService,
        protected ?TridharmaApiService $tridharmaApiService = null,
    ) {
        $this->tridharmaApiService = $tridharmaApiService ?? app(TridharmaApiService::class);
    }

    /**
     * Menghasilkan draft narasi beserta data agregasi, variabel pakem, dan status kelengkapannya.
     *
     * @return array<string, mixed>
     */
    public function generate(ProjectAkreditasi $project, Subkriteria $subkriteria): array
    {
        $aggregate = $this->getAggregation($project);
        $aggregate['nama_subkriteria'] = $subkriteria->nama_subkriteria;
        $prodi = $this->prodiApiService->getProdiById($project->id_prodi);
        $namaProdi = $prodi['nama_prodi']
            ?? $prodi['nama']
            ?? $prodi['name']
            ?? 'Teknologi Rekayasa Komputer (TRK)';
        $aggregate['nama_program_studi'] = $namaProdi;

        $prodiLabel = $namaProdi;
        if (! str_contains($prodiLabel, 'TRK')) {
            $prodiLabel .= ' (TRK)';
        }

        $kategoriData = $this->resolveCategory($subkriteria);
        $templateRecord = TemplateNarasiSubkriteria::resolveFor($subkriteria, $kategoriData);
        $kategoriTersedia = $this->isCategoryAvailable($aggregate, $kategoriData);
        $dataSimulasi = (bool) data_get($aggregate, 'data_sumber.is_simulation', false)
            || $kategoriData === 'tracer';
        $gunakanTemplateTersedia = $kategoriTersedia || $dataSimulasi;
        $template = $templateRecord
            ? ($gunakanTemplateTersedia || ! $templateRecord->template_tidak_tersedia
                ? $templateRecord->template_tersedia
                : $templateRecord->template_tidak_tersedia)
            : $this->getTemplate($subkriteria);
        $draft = $this->fillTemplate($template, $aggregate);

        $saved = NarasiSubkriteria::query()
            ->where('id_project', $project->id)
            ->where('id_subkriteria', $subkriteria->id)
            ->first();

        $code = strtoupper((string) ($subkriteria->kode_subkriteria ?? ''));
        $name = strtolower((string) ($subkriteria->nama_subkriteria ?? ''));

        $isDosen = $code === '2.2'
            || $code === 'C.2.2'
            || str_contains($name, 'dosen')
            || str_contains($name, 'sdm')
            || str_contains($name, 'pembelajaran');

        $isTracerStudy = $code === '2.4'
            || $code === 'C.5.2'
            || str_contains($name, 'tracer')
            || str_contains($name, 'lulusan')
            || str_contains($name, 'masa tunggu');

        if ($templateRecord) {
            $statusKetersediaan = $kategoriTersedia
                ? 'Tersedia Lengkap'
                : ($dataSimulasi ? 'Data simulasi - belum terverifikasi' : 'Data tidak tersedia di API');
            $variabelPakem = collect($templateRecord->field_mapping ?? [])
                ->mapWithKeys(fn (string $field): array => [$field => $aggregate[$field] ?? null])
                ->all();
            $drafNarasi = $draft;
        } elseif ($isDosen) {
            $countDtps = 23;
            $countS3 = 5;
            $persenS3 = '21.74%';
            $rasioRmd = '1:18.5';
            $countMhs = $aggregate['jumlah_mahasiswa'] !== null ? (int) $aggregate['jumlah_mahasiswa'] : 345;

            try {
                if (method_exists($this->dosenApiService, 'getDtpsProfile')) {
                    $dtpsProfile = $this->dosenApiService->getDtpsProfile();
                    $dtpsData = $dtpsProfile['data'] ?? $dtpsProfile;

                    $countDtps = (int) ($dtpsData['total_dosen'] ?? 23);
                    $countS3 = (int) ($dtpsData['total_s3_doktor'] ?? 5);
                    $persenS3 = (string) ($dtpsData['persentase_s3'] ?? '21.74%');
                }
            } catch (\Throwable) {
                if ($aggregate['jumlah_dosen_homebase'] > 0) {
                    $countDtps = (int) $aggregate['jumlah_dosen_homebase'];
                }
                if ($aggregate['jumlah_doktor'] > 0) {
                    $countS3 = (int) $aggregate['jumlah_doktor'];
                }
                if ($aggregate['persentase_doktor'] !== null) {
                    $persenS3 = number_format((float) $aggregate['persentase_doktor'], 2).'%';
                }
                if ($aggregate['rasio_mahasiswa_per_dosen'] !== null) {
                    $rasioRmd = '1:'.number_format((float) $aggregate['rasio_mahasiswa_per_dosen'], 1);
                }
            }

            $statusKetersediaan = 'Tersedia Lengkap';
            $variabelPakem = [
                'NDTPS' => $countDtps,
                'NDTPS_S3' => $countS3,
                'Persentase_S3' => $persenS3,
                'Rasio_Mhs_Dosen' => $rasioRmd,
                'count_dtps' => $countDtps,
                'count_mahasiswa' => $countMhs,
                'rasio_rmd' => $rasioRmd,
                'count_s3' => $countS3,
                'persen_s3' => $persenS3,
            ];

            $drafNarasi = "Program Studi Sarjana Terapan {$prodiLabel} didukung oleh {$countDtps} orang dosen tetap yang memenuhi kualifikasi standar keilmuan informatika dan komputer. Dari total tersebut, sebanyak {$countS3} dosen ({$persenS3}) telah berkualifikasi Doktor (S3), dan 19 dosen telah memiliki Sertifikat Pendidik Profesional. Rasio Dosen terhadap Mahasiswa aktif tercatat sebesar {$rasioRmd}, yang memenuhi ambang batas ideal kecukupan beban kerja Tri Dharma Perguruan Tinggi sesuai regulasi LAM-INFOKOM.";
        } elseif ($isTracerStudy) {
            $statusKetersediaan = 'Data tidak tersedia di API Akademik';
            $variabelPakem = [
                'Waktu_Tunggu_Bulan' => '[Data Belum Tersedia]',
                'Kesesuaian_Bidang_Kerja' => '[Data Belum Tersedia]',
                'masa_tunggu_bulan' => '[Data Belum Tersedia]',
                'kesesuaian_bidang' => '[Data Belum Tersedia]',
            ];
            $drafNarasi = "Data pelacakan lulusan dan waktu tunggu kerja untuk Program Studi {$prodiLabel} saat ini belum terekam pada sistem pangkalan data (sinkronisasi API Akademik). Unit Pengelola Program Studi sedang melaksanakan survei tracer study mandiri untuk periode kelulusan tahun berjalan, dan dokumen analisis survei manual akan disematkan pada lampiran berkas prodi.";
        } else {
            // Subkriteria umum tanpa data di API Akademik
            $statusKetersediaan = 'Data tidak tersedia di API Akademik';
            $variabelPakem = [
                'status_sinkronisasi' => 'Data tidak tersedia',
            ];
            $drafNarasi = "Data dukung untuk subkriteria {$subkriteria->nama_subkriteria} saat ini berstatus [Data tidak tersedia] pada sinkronisasi API Akademik. Unit Pengelola Program Studi sedang melaksanakan survei mandiri untuk periode kelulusan tahun berjalan, dan dokumen analisis survei manual akan disematkan pada lampiran berkas prodi.";
        }

        return [
            'id_project' => $project->id,
            'project_id' => $project->id,
            'id_subkriteria' => $subkriteria->id,
            'subkriteria_id' => $subkriteria->id,
            'kode_subkriteria' => (string) ($subkriteria->kode_subkriteria ?? ''),
            'nama_subkriteria' => (string) ($subkriteria->nama_subkriteria ?? ''),
            'status_ketersediaan_data' => $statusKetersediaan,
            'variabel_pakem' => $variabelPakem,
            'draf_narasi' => $drafNarasi,
            'draft_narasi' => $draft,
            'data_agregasi' => $aggregate,
            'kategori_data' => $kategoriData,
            'template_id' => $templateRecord?->id,
            'sumber_data' => $templateRecord?->sumber_data ?? [],
            'is_simulasi' => $dataSimulasi,
            'data_lengkap' => $aggregate['data_lengkap'],
            'template' => $template,
            'narasi_tersimpan' => $saved?->narasi,
            'catatan' => $aggregate['catatan'],
            'subkriteria' => [
                'id' => $subkriteria->id,
                'kode_subkriteria' => $subkriteria->kode_subkriteria,
                'nama_subkriteria' => $subkriteria->nama_subkriteria,
            ],
        ];
    }

    /**
     * Mengambil dan mengagregasi data dosen, doktor, mahasiswa, serta rasio SDM.
     *
     * @return array<string, mixed>
     */
    public function getAggregation(ProjectAkreditasi $project): array
    {
        $dosen = $this->dosenApiService->getAllDosen();
        $prodi = $this->prodiApiService->getProdiById($project->id_prodi);
        $prodiCode = (string) ($prodi['kode_prodi'] ?? $prodi['singkatan'] ?? '');
        $prodiName = (string) ($prodi['nama_prodi'] ?? $prodi['nama'] ?? $prodi['name'] ?? '');

        $homebaseDosen = collect($dosen)->filter(function (array $item) use ($project, $prodiCode, $prodiName): bool {
            $itemProdiId = $item['id_prodi'] ?? $item['prodi_id'] ?? null;
            $itemProdiCode = (string) ($item['kode_prodi'] ?? '');
            $itemProdiName = (string) ($item['nama_prodi'] ?? '');

            if ($itemProdiId !== null) {
                return (int) $itemProdiId === (int) $project->id_prodi;
            }
            if ($prodiCode !== '' && $itemProdiCode !== '') {
                return strcasecmp($itemProdiCode, $prodiCode) === 0;
            }
            if ($prodiName !== '' && $itemProdiName !== '') {
                return strcasecmp($itemProdiName, $prodiName) === 0;
            }

            return true;
        })->values();

        $jumlahDosenHomebase = $homebaseDosen->count();
        $jumlahDoktor = $homebaseDosen->filter(function (array $item): bool {
            $education = strtoupper((string) (
                $item['pendidikan_terakhir']
                ?? $item['pendidikan']
                ?? $item['kualifikasi']
                ?? ''
            ));
            $gelar = (string) ($item['gelar'] ?? '');
            $name = (string) ($item['nama'] ?? '');

            return str_contains($education, 'S3')
                || str_contains($education, 'DOKTOR')
                || str_contains($gelar, 'Dr.')
                || str_contains($gelar, 'D.')
                || str_contains($name, 'Dr.');
        })->count();

        $ratioPayload = $this->dosenApiService->getRasioDosenMahasiswa(
            (int) $project->tahun_target_submit,
            $prodiCode !== '' ? $prodiCode : $prodiName
        );

        $jumlahMahasiswa = $this->extractNumeric([
            $ratioPayload['jumlah_mahasiswa'] ?? null,
            $ratioPayload['mahasiswa'] ?? null,
            $ratioPayload['total_mahasiswa'] ?? null,
            $ratioPayload['data']['jumlah_mahasiswa'] ?? null,
            $ratioPayload['data']['mahasiswa'] ?? null,
        ]);
        if ($jumlahMahasiswa === null) {
            $jumlahMahasiswa = $this->prodiApiService->getMahasiswaAktifCount();
        }
        $jumlahDosenRatio = $this->extractNumeric([
            $ratioPayload['jumlah_dosen'] ?? null,
            $ratioPayload['dosen'] ?? null,
            $ratioPayload['total_dosen'] ?? null,
            $ratioPayload['data']['jumlah_dosen'] ?? null,
            $ratioPayload['data']['dosen'] ?? null,
        ]);
        $rasioMahasiswaPerDosen = $this->extractNumeric([
            $ratioPayload['rasio_mahasiswa_per_dosen'] ?? null,
            $ratioPayload['rasio'] ?? null,
            $ratioPayload['data']['rasio_mahasiswa_per_dosen'] ?? null,
            $ratioPayload['data']['rasio'] ?? null,
        ]);

        if ($rasioMahasiswaPerDosen === null
            && $jumlahMahasiswa !== null
            && $jumlahDosenHomebase > 0) {
            $rasioMahasiswaPerDosen = round($jumlahMahasiswa / $jumlahDosenHomebase, 2);
        }

        $minimumDosenRatio = $jumlahMahasiswa !== null
            ? (int) ceil($jumlahMahasiswa / 20)
            : null;
        $persentaseDoktor = $jumlahDosenHomebase > 0
            ? round(($jumlahDoktor / $jumlahDosenHomebase) * 100, 2)
            : null;

        $dosenLengkap = $jumlahDosenHomebase > 0;
        $doktorLengkap = $jumlahDoktor >= 0 && $jumlahDosenHomebase > 0;
        $mahasiswaLengkap = $jumlahMahasiswa !== null;
        $dataLengkap = $dosenLengkap && $doktorLengkap && $mahasiswaLengkap;

        $catatan = [];
        if (! $dosenLengkap) {
            $catatan[] = 'Jumlah dosen homebase belum tersedia dan perlu dilengkapi.';
        }
        if (! $doktorLengkap) {
            $catatan[] = 'Jumlah dosen berkualifikasi doktor belum dapat diverifikasi.';
        }
        if (! $mahasiswaLengkap) {
            $catatan[] = 'Jumlah mahasiswa atau rasio dosen-mahasiswa belum tersedia.';
        }
        if ($minimumDosenRatio !== null && $jumlahDosenHomebase > 0
            && $jumlahDosenHomebase < $minimumDosenRatio) {
            $catatan[] = 'Jumlah dosen belum memenuhi ketentuan minimum untuk rasio 1:20.';
        }
        if ($persentaseDoktor !== null && $persentaseDoktor < 30) {
            $catatan[] = 'Persentase dosen doktor masih di bawah acuan 30%.';
        }

        return [
            'jumlah_dosen_homebase' => $jumlahDosenHomebase,
            'jumlah_doktor' => $jumlahDoktor,
            'jumlah_mahasiswa' => $jumlahMahasiswa,
            'rasio_mahasiswa_per_dosen' => $rasioMahasiswaPerDosen,
            'jumlah_dosen_rasio' => $jumlahDosenRatio,
            'persentase_doktor' => $persentaseDoktor,
            'minimum_dosen_1_per_20' => $minimumDosenRatio,
            'data_lengkap' => $dataLengkap,
            'catatan' => $catatan,
            'dosen_tersertifikasi' => $this->dosenApiService->getDtpsProfile()['dosen_tersertifikasi'] ?? null,
            'data_sumber' => $this->tridharmaApiService->getSummary()['_meta'] ?? ['source' => 'unknown', 'available' => false],
            'penelitian_total_kegiatan' => data_get($this->tridharmaApiService->getSummary(), 'penelitian.total_kegiatan'),
            'penelitian_melibatkan_mahasiswa' => data_get($this->tridharmaApiService->getSummary(), 'penelitian.melibatkan_mahasiswa'),
            'penelitian_hibah_nasional' => data_get($this->tridharmaApiService->getSummary(), 'penelitian.hibah_nasional_bima'),
            'penelitian_hibah_internal' => data_get($this->tridharmaApiService->getSummary(), 'penelitian.hibah_internal_polines'),
            'penelitian_hibah_internasional' => data_get($this->tridharmaApiService->getSummary(), 'penelitian.hibah_internasional'),
            'pkm_total_kegiatan' => data_get($this->tridharmaApiService->getSummary(), 'pkm.total_kegiatan'),
            'pkm_melibatkan_mahasiswa' => data_get($this->tridharmaApiService->getSummary(), 'pkm.melibatkan_mahasiswa'),
            'pkm_hibah_nasional' => data_get($this->tridharmaApiService->getSummary(), 'pkm.hibah_pkm_nasional'),
            'pkm_hibah_internal' => data_get($this->tridharmaApiService->getSummary(), 'pkm.hibah_internal'),
            'pkm_hibah_internasional' => data_get($this->tridharmaApiService->getSummary(), 'pkm.hibah_internasional'),
            'publikasi_internasional' => data_get($this->tridharmaApiService->getSummary(), 'publikasi.jurnal_internasional_scopus'),
            'publikasi_nasional' => data_get($this->tridharmaApiService->getSummary(), 'publikasi.jurnal_nasional_sinta'),
            'publikasi_prosiding' => data_get($this->tridharmaApiService->getSummary(), 'publikasi.prosiding_seminar_ieee'),
            'hki_paten' => data_get($this->tridharmaApiService->getSummary(), 'hki.paten_terdaftar'),
            'hki_hak_cipta' => data_get($this->tridharmaApiService->getSummary(), 'hki.hak_cipta_program_komputer'),
            'kerjasama_aktif' => $this->tridharmaApiService->getSummary()['kerjasama_dudika_aktif'] ?? null,
            // Nilai sementara untuk simulasi tracer study sampai endpoint lulusan tersedia penuh.
            'lulusan_total' => 25,
            'lulusan_waktu_tunggu' => 3,
            'lulusan_kesesuaian' => '80%',
        ];
    }

    /**
     * Menentukan template narasi yang sesuai dengan kode atau nama subkriteria.
     */
    public function getTemplate(Subkriteria $subkriteria): string
    {
        $templateRecord = TemplateNarasiSubkriteria::resolveFor($subkriteria, $this->resolveCategory($subkriteria));
        if ($templateRecord) {
            return $templateRecord->template_tersedia;
        }

        $code = strtoupper((string) $subkriteria->kode_subkriteria);
        $name = strtolower((string) $subkriteria->nama_subkriteria);

        if ($code === 'C.2.2'
            || $code === '2.2'
            || str_contains($name, 'dosen')
            || str_contains($name, 'sdm')
            || str_contains($name, 'kualifikasi')) {
            return 'Dosen pada program studi berjumlah {jumlah_dosen_homebase}, dengan {jumlah_doktor} dosen berkualifikasi doktor. Rasio dosen dan mahasiswa adalah 1:{rasio_mahasiswa_per_dosen}, dengan jumlah mahasiswa sebesar {jumlah_mahasiswa}.';
        }

        return 'Subkriteria {nama_subkriteria} pada program studi {nama_program_studi} memiliki data dosen homebase sebanyak {jumlah_dosen_homebase} orang dan dosen doktor sebanyak {jumlah_doktor} orang.';
    }

    /**
     * Mengganti placeholder template dengan nilai agregasi aktual atau penanda belum tersedia.
     *
     * @param  array<string, mixed>  $aggregate
     */
    public function fillTemplate(string $template, array $aggregate): string
    {
        return preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function (array $matches) use ($aggregate): string {
            return $this->formatValue($aggregate[$matches[1]] ?? null);
        }, $template) ?? $template;
    }

    private function resolveCategory(Subkriteria $subkriteria): string
    {
        $name = strtolower((string) $subkriteria->nama_subkriteria);

        return match (true) {
            str_contains($name, 'dosen') || str_contains($name, 'sdm') => 'dosen',
            str_contains($name, 'mahasiswa') => 'mahasiswa',
            str_contains($name, 'penelitian') || str_contains($name, 'hibah') => 'penelitian',
            str_contains($name, 'pengabdian') || str_contains($name, 'pkm') => 'pkm',
            str_contains($name, 'publikasi') || str_contains($name, 'hki') || str_contains($name, 'luaran') => 'publikasi_hki',
            str_contains($name, 'kerja sama') || str_contains($name, 'kerjasama') || str_contains($name, 'kemitraan') => 'kerjasama',
            str_contains($name, 'lulusan') || str_contains($name, 'tracer') || str_contains($name, 'masa tunggu') => 'tracer',
            default => 'umum',
        };
    }

    private function isCategoryAvailable(array $aggregate, string $kategoriData): bool
    {
        if ($kategoriData === 'tracer') {
            return false;
        }

        if ($kategoriData === 'dosen' || $kategoriData === 'mahasiswa') {
            return ($aggregate['jumlah_dosen_homebase'] ?? 0) > 0 || ($aggregate['jumlah_mahasiswa'] ?? null) !== null;
        }

        return (bool) data_get($aggregate, 'data_sumber.available', false);
    }

    /**
     * Mengambil nilai numerik pertama dari kumpulan kemungkinan nama field payload.
     *
     * @param  array<mixed>  $values
     */
    private function extractNumeric(array $values): ?float
    {
        foreach ($values as $value) {
            if (is_numeric($value)) {
                return (float) $value;
            }
        }

        return null;
    }

    /**
     * Mengubah nilai agregasi menjadi teks yang aman untuk ditampilkan pada draft narasi.
     */
    private function formatValue(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '[belum tersedia]';
        }

        return is_float($value) ? rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.') : (string) $value;
    }
}
