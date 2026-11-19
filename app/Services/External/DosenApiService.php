<?php

namespace App\Services\External;

use Exception;
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
     * Mengambil daftar dosen (NIDN, Nama, Email, Bidang Minat) dari API Kelompok 2.
     * Menggunakan fallback data dummy jika server Kelompok 2 unreachable.
     */
    public function getAllDosen(?string $token = null): array
    {
        $authToken = $token ?? $this->token;

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
                        return [
                            'nidn' => $dosen['nidn'] ?? '-',
                            'nama' => $dosen['nama'] ?? $dosen['nama_dosen'] ?? $dosen['name'] ?? '-',
                            'email' => $dosen['email'] ?? '-',
                            'bidang_minat' => $dosen['bidang_minat'] ?? $dosen['keahlian'] ?? '-',
                            'id_prodi' => $dosen['id_prodi'] ?? $dosen['prodi_id'] ?? null,
                            'kode_prodi' => $dosen['kode_prodi'] ?? $dosen['singkatan'] ?? null,
                            'nama_prodi' => $dosen['nama_prodi'] ?? $dosen['prodi'] ?? null,
                            'status_dosen' => $dosen['status_dosen'] ?? $dosen['status'] ?? null,
                            'pendidikan_terakhir' => $dosen['pendidikan_terakhir'] ?? $dosen['pendidikan'] ?? $dosen['kualifikasi'] ?? null,
                            'gelar' => $dosen['gelar'] ?? null,
                        ];
                    })->values()->toArray();
                }
            }
        } catch (Exception $e) {
            // Server Kelompok 2 unreachable / timeout -> lanjut ke fallback dummy
        }

        return $this->getFallbackDosen();
    }

    /**
     * Data dummy/seeder fallback jika server Kelompok 2 tidak dapat dijangkau.
     */
    public function getFallbackDosen(): array
    {
        return [
            [
                'nidn' => '0012048801',
                'nama' => 'Dr. Andi Wijaya, S.Kom., M.T.',
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
                'nidn' => '0023089002',
                'nama' => 'Siti Rahmawati, S.T., M.Kom.',
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
                'nidn' => '0015118503',
                'nama' => 'Budi Santoso, S.Kom., M.Cs.',
                'email' => 'budi.santoso@kampus.ac.id',
                'bidang_minat' => 'Internet of Things (IoT) & Sistem Tertanam',
                'id_prodi' => 1,
                'kode_prodi' => 'TRK',
                'nama_prodi' => 'Teknologi Rekayasa Komputer',
                'status_dosen' => 'Aktif',
                'pendidikan_terakhir' => 'S2',
                'gelar' => 'M.Cs.',
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
