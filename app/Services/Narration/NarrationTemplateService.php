<?php

namespace App\Services\Narration;

use App\Models\NarasiSubkriteria;
use App\Models\ProjectAkreditasi;
use App\Models\Subkriteria;
use App\Services\External\DosenApiService;
use App\Services\External\ProdiApiService;

class NarrationTemplateService
{
    /**
     * Menyuntikkan layanan data dosen dan program studi yang digunakan narasi.
     */
    public function __construct(
        protected DosenApiService $dosenApiService,
        protected ProdiApiService $prodiApiService,
    ) {}

    /**
     * Menghasilkan draft narasi beserta data agregasi dan status kelengkapannya.
     *
     * @return array<string, mixed>
     */
    public function generate(ProjectAkreditasi $project, Subkriteria $subkriteria): array
    {
        $aggregate = $this->getAggregation($project);
        $aggregate['nama_subkriteria'] = $subkriteria->nama_subkriteria;
        $prodi = $this->prodiApiService->getProdiById($project->id_prodi);
        $aggregate['nama_program_studi'] = $prodi['nama_prodi']
            ?? $prodi['nama']
            ?? $prodi['name']
            ?? '[Program Studi]';
        $template = $this->getTemplate($subkriteria);
        $draft = $this->fillTemplate($template, $aggregate);

        $saved = NarasiSubkriteria::query()
            ->where('id_project', $project->id)
            ->where('id_subkriteria', $subkriteria->id)
            ->first();

        return [
            'project_id' => $project->id,
            'subkriteria' => [
                'id' => $subkriteria->id,
                'kode_subkriteria' => $subkriteria->kode_subkriteria,
                'nama_subkriteria' => $subkriteria->nama_subkriteria,
            ],
            'template' => $template,
            'data_agregasi' => $aggregate,
            'draft_narasi' => $draft,
            'narasi_tersimpan' => $saved?->narasi,
            'catatan' => $aggregate['catatan'],
            'data_lengkap' => $aggregate['data_lengkap'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
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
        ];
    }

    /**
     * Menentukan template narasi yang sesuai dengan kode atau nama subkriteria.
     */
    public function getTemplate(Subkriteria $subkriteria): string
    {
        $code = strtoupper((string) $subkriteria->kode_subkriteria);
        $name = strtolower((string) $subkriteria->nama_subkriteria);

        if ($code === 'C.2.2'
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
        $placeholders = [
            '{jumlah_dosen_homebase}' => $this->formatValue($aggregate['jumlah_dosen_homebase'] ?? null),
            '{jumlah_doktor}' => $this->formatValue($aggregate['jumlah_doktor'] ?? null),
            '{jumlah_mahasiswa}' => $this->formatValue($aggregate['jumlah_mahasiswa'] ?? null),
            '{rasio_mahasiswa_per_dosen}' => $this->formatValue($aggregate['rasio_mahasiswa_per_dosen'] ?? null),
            '{nama_subkriteria}' => (string) ($aggregate['nama_subkriteria'] ?? '[Subkriteria]'),
            '{nama_program_studi}' => (string) ($aggregate['nama_program_studi'] ?? '[Program Studi]'),
        ];

        return strtr($template, $placeholders);
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
