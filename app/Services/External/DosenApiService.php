<?php

namespace App\Services\External;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DosenApiService
{
    protected string $baseUrl;

    protected ?string $token;

    /**
     * Menyiapkan URL API Tridharma dan token JWT dari request atau parameter.
     */
    public function __construct(?string $token = null)
    {
        $this->baseUrl = rtrim((string) config('services.external.tridharma_url'), '/');
        $this->token = $token ?? request()?->bearerToken();
    }

    /**
     * Mengambil daftar dosen ternormalisasi dari API Kelompok 2.
     * Mengekspos 5 field relevan:
     * 1. nip_nidn (dan nidn sebagai alias)
     * 2. nama_lengkap (dan nama sebagai alias)
     * 3. gelar (mendukung deteksi pendidikan S3 / Doktor)
     * 4. jabatan_fungsional (mendukung deteksi Lektor Kepala & Guru Besar)
     * 5. status_homebase (boolean indikator dosen tetap homebase)
     *
     * Dilengkapi mekanisme caching 10 menit, timeout 8 detik, dan fallback dummy data.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllDosen(?string $token = null): array
    {
        $authToken = $token ?? $this->token;
        $cacheKey = 'external_dosen_list_'.md5((string) $authToken);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($authToken) {
            try {
                $response = Http::timeout(8)
                    ->acceptJson()
                    ->when($authToken, fn ($http) => $http->withToken($authToken))
                    ->get("{$this->baseUrl}/dosen");

                if ($response->successful()) {
                    $payload = $response->json('data') ?? $response->json();

                    // Antisipasi jika API Kelompok 2 menggunakan format pagination (data.data)
                    if (isset($payload['data']) && is_array($payload['data'])) {
                        $payload = $payload['data'];
                    }

                    if (is_array($payload) && count($payload) > 0) {
                        return collect($payload)->map(function ($dosen) {
                            return $this->formatDosenItem($dosen);
                        })->values()->toArray();
                    }
                }
            } catch (Exception $e) {
                // Server Kelompok 2 unreachable / timeout -> lanjut ke fallback dummy
            }

            return $this->getFallbackDosen();
        });
    }

    /**
     * Memformat item data dosen menjadi 5 field standar dan atribut pendukung.
     *
     * @param  array<string, mixed>  $dosen
     * @return array<string, mixed>
     */
    protected function formatDosenItem(array $dosen): array
    {
        $nipNidn = (string) ($dosen['nip_nidn'] ?? $dosen['nidn'] ?? $dosen['nip'] ?? '-');
        $namaLengkap = (string) ($dosen['nama_lengkap'] ?? $dosen['nama'] ?? $dosen['nama_dosen'] ?? $dosen['name'] ?? '-');
        $gelar = (string) ($dosen['gelar'] ?? $dosen['gelar_akademik'] ?? $dosen['pendidikan'] ?? '-');
        $jabatanFungsional = (string) ($dosen['jabatan_fungsional'] ?? $dosen['jafung'] ?? $dosen['jabatan'] ?? '-');

        // Normalisasi status_homebase (default true jika tidak ditentukan)
        $statusHomebase = isset($dosen['status_homebase'])
            ? filter_var($dosen['status_homebase'], FILTER_VALIDATE_BOOLEAN)
            : (isset($dosen['is_homebase']) ? filter_var($dosen['is_homebase'], FILTER_VALIDATE_BOOLEAN) : true);

        return [
            'nip_nidn' => $nipNidn,
            'nidn' => $nipNidn,
            'nama_lengkap' => $namaLengkap,
            'nama' => $namaLengkap,
            'gelar' => $gelar,
            'jabatan_fungsional' => $jabatanFungsional,
            'status_homebase' => $statusHomebase,
            'email' => (string) ($dosen['email'] ?? '-'),
            'bidang_minat' => (string) ($dosen['bidang_minat'] ?? $dosen['keahlian'] ?? '-'),
        ];
    }

    /**
     * Data dummy/seeder fallback jika server Kelompok 2 tidak dapat dijangkau.
     * Berisi minimal 6 dosen dengan variasi gelar S3/Doktor, jabatan fungsional LK/GB,
     * serta status_homebase.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getFallbackDosen(): array
    {
        return [
            [
                'nip_nidn' => '197504122000031001',
                'nidn' => '0012048801',
                'nama_lengkap' => 'Prof. Dr. Andi Wijaya, S.Kom., M.T.',
                'nama' => 'Prof. Dr. Andi Wijaya, S.Kom., M.T.',
                'gelar' => 'Doktor (S3)',
                'jabatan_fungsional' => 'Guru Besar',
                'status_homebase' => true,
                'email' => 'andi.wijaya@kampus.ac.id',
                'bidang_minat' => 'Rekayasa Perangkat Lunak & Sistem Informasi',
                'id_prodi' => 1,
                'kode_prodi' => 'TRK',
                'nama_prodi' => 'Teknologi Rekayasa Komputer',
                'status_dosen' => 'Aktif',
                'pendidikan_terakhir' => 'S3',
                'gelar' => 'Dr.',
            ],
            [
                'nip_nidn' => '198208152005012002',
                'nidn' => '0023089002',
                'nama_lengkap' => 'Dr. Siti Rahmawati, S.T., M.Kom.',
                'nama' => 'Dr. Siti Rahmawati, S.T., M.Kom.',
                'gelar' => 'Doktor (S3)',
                'jabatan_fungsional' => 'Lektor Kepala',
                'status_homebase' => true,
                'email' => 'siti.rahmawati@kampus.ac.id',
                'bidang_minat' => 'Jaringan Komputer & Keamanan Siber',
                'id_prodi' => 1,
                'kode_prodi' => 'TRK',
                'nama_prodi' => 'Teknologi Rekayasa Komputer',
                'status_dosen' => 'Aktif',
                'pendidikan_terakhir' => 'S2',
                'gelar' => 'M.Kom.',
            ],
            [
                'nip_nidn' => '198511202008121003',
                'nidn' => '0015118503',
                'nama_lengkap' => 'Budi Santoso, S.Kom., M.Cs.',
                'nama' => 'Budi Santoso, S.Kom., M.Cs.',
                'gelar' => 'Magister (S2)',
                'jabatan_fungsional' => 'Lektor',
                'status_homebase' => true,
                'email' => 'budi.santoso@kampus.ac.id',
                'bidang_minat' => 'Internet of Things (IoT) & Sistem Tertanam',
                'id_prodi' => 1,
                'kode_prodi' => 'TRK',
                'nama_prodi' => 'Teknologi Rekayasa Komputer',
                'status_dosen' => 'Aktif',
                'pendidikan_terakhir' => 'S2',
                'gelar' => 'M.Cs.',
            ],
            [
                'nip_nidn' => '198801102010122004',
                'nidn' => '0010018804',
                'nama_lengkap' => 'Dr. Ir. Hendra Gunawan, M.T.',
                'nama' => 'Dr. Ir. Hendra Gunawan, M.T.',
                'gelar' => 'Doktor (S3)',
                'jabatan_fungsional' => 'Lektor Kepala',
                'status_homebase' => true,
                'email' => 'hendra.gunawan@kampus.ac.id',
                'bidang_minat' => 'Kecerdasan Buatan & Pengolahan Citra',
            ],
            [
                'nip_nidn' => '199003052014041005',
                'nidn' => '0005039005',
                'nama_lengkap' => 'Ahmad Fauzi, S.T., M.T.',
                'nama' => 'Ahmad Fauzi, S.T., M.T.',
                'gelar' => 'Magister (S2)',
                'jabatan_fungsional' => 'Asisten Ahli',
                'status_homebase' => true,
                'email' => 'ahmad.fauzi@kampus.ac.id',
                'bidang_minat' => 'Sains Data & Basis Data Terdistribusi',
            ],
            [
                'nip_nidn' => '199207222019032006',
                'nidn' => '0022079206',
                'nama_lengkap' => 'Dewi Lestari, S.Kom., M.Kom.',
                'nama' => 'Dewi Lestari, S.Kom., M.Kom.',
                'gelar' => 'Magister (S2)',
                'jabatan_fungsional' => 'Tenaga Pengajar',
                'status_homebase' => false,
                'email' => 'dewi.lestari@kampus.ac.id',
                'bidang_minat' => 'Interaksi Manusia dan Komputer',
            ],
        ];
    }

    /**
     * Mengambil rasio dosen terhadap mahasiswa dari API Tridharma.
     *
     * @return array<string, mixed>
     */
    public function getRasioDosenMahasiswa(?int $tahun = null, ?string $prodi = null): array
    {
        try {
            $response = Http::timeout(8)
                ->acceptJson()
                ->when($this->token, fn ($http) => $http->withToken($this->token))
                ->get("{$this->baseUrl}/v1/dosen/rasio", array_filter([
                    'tahun' => $tahun,
                    'prodi' => $prodi,
                ]));

            if ($response->successful()) {
                $payload = $response->json('data') ?? $response->json();

                if (is_array($payload)) {
                    return $payload;
                }
            }
        } catch (Exception) {
            // Fallback dibentuk oleh NarationTemplateService.
        }

        return [];
    }
}
