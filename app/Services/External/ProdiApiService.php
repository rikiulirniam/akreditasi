<?php

namespace App\Services\External;

use Exception;
use Illuminate\Support\Facades\Http;

class ProdiApiService
{
    protected string $baseUrl;

    protected ?string $token;

    protected array $defaultProdi;

    /**
     * Saat instansiasi default, langsung menyiapkan data Program Studi TRK
     * sebagai state/default prodi.
     */
    public function __construct(?string $token = null)
    {
        $this->baseUrl = rtrim((string) config('services.external.akademik_url'), '/');
        $this->token = $token ?? request()?->bearerToken();
        $this->defaultProdi = $this->resolveDefaultTrkProdi();
    }

    /**
     * Mengambil daftar seluruh program studi resmi dari API Kelompok 1.
     */
    public function getAllProdi(?string $token = null): array
    {
        $authToken = $token ?? $this->token;

        try {
            $response = Http::timeout(8)
                ->acceptJson()
                ->when($authToken, fn ($http) => $http->withToken($authToken))
                ->get("{$this->baseUrl}/prodi");

            if ($response->successful()) {
                $payload = $response->json('data') ?? $response->json();

                // Antisipasi jika response menggunakan pagination (data.data)
                if (isset($payload['data']) && is_array($payload['data'])) {
                    return $payload['data'];
                }

                return is_array($payload) ? $payload : [];
            }
        } catch (Exception $e) {
            // Fallback ke default TRK jika server Kelompok 1 unreachable / timeout
        }

        return [$this->getFallbackTrk()];
    }

    /**
     * Helper untuk mengembalikan Program Studi default (TRK - Teknologi Rekayasa Komputer).
     */
    public function getDefaultProdi(): array
    {
        return $this->defaultProdi;
    }

    /**
     * Helper internal untuk mencari TRK dari API Kelompok 1,
     * atau menggunakan fallback TRK jika API belum bisa diakses.
     */
    protected function resolveDefaultTrkProdi(): array
    {
        $list = $this->getAllProdi($this->token);

        $trk = collect($list)->first(function ($item) {
            $nama = (string) ($item['nama_prodi'] ?? $item['nama'] ?? $item['name'] ?? '');
            $kode = strtoupper((string) ($item['kode_prodi'] ?? $item['kode'] ?? $item['singkatan'] ?? ''));

            return stripos($nama, 'Teknologi Rekayasa Komputer') !== false
                || $kode === 'TRK';
        });

        return $trk ?: $this->getFallbackTrk();
    }

    /**
     * Data fallback resmi untuk Program Studi TRK.
     */
    protected function getFallbackTrk(): array
    {
        return [
            'id' => 1,
            'kode_prodi' => 'TRK',
            'nama_prodi' => 'Teknologi Rekayasa Komputer',
            'jenjang' => 'D4',
        ];
    }
}
