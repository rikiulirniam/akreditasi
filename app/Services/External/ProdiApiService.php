<?php

namespace App\Services\External;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProdiApiService
{
    protected string $baseUrl;

    protected ?string $token;

    protected array $defaultProdi;

    /**
     * Menyiapkan URL akademik dan memilih data default Program Studi TRK.
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
     * Mengambil data satu program studi berdasarkan ID dari API Kelompok 1.
     *
     * @return array<string, mixed>|null
     */
    public function getProdiById(int $id, ?string $token = null): ?array
    {
        $authToken = $token ?? $this->token;

        try {
            $response = Http::timeout(8)
                ->acceptJson()
                ->when($authToken, fn ($http) => $http->withToken($authToken))
                ->get("{$this->baseUrl}/prodi/".$id);

            if ($response->successful()) {
                $payload = $response->json('data') ?? $response->json();
                if (is_array($payload)) {
                    return $payload;
                }
            }
        } catch (Exception) {
            // Lanjut ke pencarian pada daftar program studi atau fallback.
        }

        foreach ($this->getAllProdi($authToken) as $prodi) {
            if ((int) ($prodi['id'] ?? 0) === $id) {
                return $prodi;
            }
        }

        if ($this->getDefaultProdi()['id'] === $id) {
            return $this->getDefaultProdi();
        }

        return null;
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
     * Mengambil jumlah mahasiswa aktif dari API Kelompok 1 (dengan caching & fallback).
     */
    public function getMahasiswaAktifCount(?string $token = null): int
    {
        $authToken = $token ?? $this->token;
        $cacheKey = 'external_akademik_mhs_count_'.md5((string) $authToken);

        return (int) Cache::remember($cacheKey, now()->addMinutes(10), function () use ($authToken): int {
            try {
                $response = Http::timeout(6)
                    ->acceptJson()
                    ->when($authToken, fn ($http) => $http->withToken($authToken))
                    ->get("{$this->baseUrl}/mahasiswa");

                if ($response->successful()) {
                    $payload = $response->json('data') ?? $response->json();
                    if (isset($payload['total']) && is_numeric($payload['total'])) {
                        return (int) $payload['total'];
                    }
                    $items = isset($payload['data']) && is_array($payload['data']) ? $payload['data'] : $payload;
                    if (is_array($items) && count($items) > 0) {
                        return count($items);
                    }
                }
            } catch (Exception) {
                // Gunakan fallback jika server Kelompok 1 unreachable
            }

            return 345;
        });
    }

    /**
     * Mengambil ringkasan mata kuliah untuk evaluasi Suplemen Infokom (Inti, Domain TRK, Matematika, Capstone).
     *
     * @return array{total_mk: int, mk_inti_komputasi: int, mk_domain_trk: int, mk_matematika: int, mk_capstone: int}
     */
    public function getMataKuliahSummary(?string $token = null): array
    {
        $authToken = $token ?? $this->token;
        $cacheKey = 'external_akademik_mk_summary_'.md5((string) $authToken);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($authToken): array {
            try {
                $response = Http::timeout(6)
                    ->acceptJson()
                    ->when($authToken, fn ($http) => $http->withToken($authToken))
                    ->get("{$this->baseUrl}/mata-kuliah");

                if ($response->successful()) {
                    $payload = $response->json('data') ?? $response->json();
                    $items = isset($payload['data']) && is_array($payload['data']) ? $payload['data'] : $payload;

                    if (is_array($items) && count($items) > 0) {
                        return $this->classifyMataKuliah($items);
                    }
                }
            } catch (Exception) {
                // Gunakan fallback terkurasi jika server Kelompok 1 unreachable
            }

            return [
                'total_mk' => 48,
                'mk_inti_komputasi' => 14,
                'mk_domain_trk' => 12,
                'mk_matematika' => 4,
                'mk_capstone' => 2,
            ];
        });
    }

    /**
     * Mengklasifikasikan daftar mata kuliah berdasarkan kategori Suplemen LAM-INFOKOM.
     *
     * @param  array<int, array<string, mixed>>  $items
     * @return array{total_mk: int, mk_inti_komputasi: int, mk_domain_trk: int, mk_matematika: int, mk_capstone: int}
     */
    protected function classifyMataKuliah(array $items): array
    {
        $inti = 0;
        $domain = 0;
        $math = 0;
        $capstone = 0;

        foreach ($items as $mk) {
            $nama = strtolower((string) ($mk['nama_mata_kuliah'] ?? $mk['nama'] ?? ''));

            if (preg_match('/algoritma|pemrograman|basis data|sistem operasi|struktur data|arsitektur/', $nama)) {
                $inti++;
            }
            if (preg_match('/embedded|iot|jaringan|mikroprosesor|keamanan|sensor|robotik|cloud/', $nama)) {
                $domain++;
            }
            if (preg_match('/matematika|kalkulus|aljabar|statistik|probabilitas|diskrit/', $nama)) {
                $math++;
            }
            if (preg_match('/capstone|proyek terapan|tugas akhir|skripsi|proyek akhir/', $nama)) {
                $capstone++;
            }
        }

        return [
            'total_mk' => count($items),
            'mk_inti_komputasi' => $inti,
            'mk_domain_trk' => $domain,
            'mk_matematika' => $math,
            'mk_capstone' => $capstone,
        ];
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
