<?php

namespace App\Services\External;

use Exception;
use Illuminate\Support\Facades\Http;

class DosenApiService
{
    protected string $baseUrl;

    protected ?string $token;

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
            ],
            [
                'nidn' => '0023089002',
                'nama' => 'Siti Rahmawati, S.T., M.Kom.',
                'email' => 'siti.rahmawati@kampus.ac.id',
                'bidang_minat' => 'Jaringan Komputer & Keamanan Siber',
            ],
            [
                'nidn' => '0015118503',
                'nama' => 'Budi Santoso, S.Kom., M.Cs.',
                'email' => 'budi.santoso@kampus.ac.id',
                'bidang_minat' => 'Internet of Things (IoT) & Sistem Tertanam',
            ],
        ];
    }
}
