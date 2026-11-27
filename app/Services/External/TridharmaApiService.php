<?php

namespace App\Services\External;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TridharmaApiService
{
    protected string $baseUrl;

    protected ?string $token;

    public function __construct(?string $token = null)
    {
        $this->baseUrl = rtrim((string) config('services.external.tridharma_url', 'https://tridharma.fayra.my.id/api'), '/');
        $this->token = $token ?? request()?->bearerToken();
    }

    /**
     * Mengambil ringkasan Tridharma dari API Kelompok 2 (atau fallback terkurasi).
     *
     * @return array<string, mixed>
     */
    public function getSummary(?string $token = null): array
    {
        $authToken = $token ?? $this->token;
        $cacheKey = 'external_tridharma_summary_'.md5((string) $authToken);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($authToken) {
            try {
                $activities = $this->fetchCollection('/kegiatan', $authToken);
                $outputs = $this->fetchCollection('/luaran', $authToken);
                $partnerships = $this->fetchCollection('/kerja-sama', $authToken);

                if (count($activities) > 0 || count($outputs) > 0 || count($partnerships) > 0) {
                    return $this->buildSummaryFromApi($activities, $outputs, $partnerships);
                }
            } catch (Exception) {
                // API Kelompok 2 unreachable / token tidak tersedia -> fallback ditandai sebagai simulasi.
            }

            return $this->getCuratedSummary(false);
        });
    }

    /**
     * Ringkasan agregat standar Tridharma Kelompok 2 (175 publikasi, riset, PkM, HKI, kemitraan DUDIKA).
     *
     * @return array<string, mixed>
     */
    public function getCuratedSummary(bool $fromApi = false): array
    {
        return [
            'penelitian' => [
                'total_kegiatan' => 42,
                'melibatkan_mahasiswa' => 35,
                'hibah_nasional_bima' => 8,
                'hibah_internal_polines' => 26,
                'hibah_internasional' => 0,
                'mandiri' => 8,
            ],
            'pkm' => [
                'total_kegiatan' => 28,
                'melibatkan_mahasiswa' => 24,
                'hibah_pkm_nasional' => 4,
                'hibah_internal' => 24,
                'hibah_internasional' => 0,
            ],
            'publikasi' => [
                'jurnal_internasional_scopus' => 18,
                'jurnal_nasional_sinta' => 64,
                'prosiding_seminar_ieee' => 32,
                'buku_isbn' => 12,
            ],
            'hki' => [
                'paten_terdaftar' => 3,
                'hak_cipta_program_komputer' => 22,
            ],
            'kerjasama_dudika_aktif' => 15,
            '_meta' => [
                'source' => $fromApi ? 'api' : 'fallback',
                'available' => $fromApi,
                'is_simulation' => ! $fromApi,
                'endpoints' => ['/kegiatan', '/luaran', '/kerja-sama'],
            ],
        ];
    }

    /**
     * Mengambil koleksi API dengan dukungan response pagination Laravel.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function fetchCollection(string $path, ?string $token): array
    {
        $response = Http::timeout(8)
            ->acceptJson()
            ->when($token, fn ($http) => $http->withToken($token))
            ->get($this->baseUrl.$path);

        if (! $response->successful()) {
            return [];
        }

        $payload = $response->json('data') ?? $response->json();
        $items = is_array($payload['data'] ?? null) ? $payload['data'] : $payload;

        return is_array($items) ? array_values(array_filter($items, 'is_array')) : [];
    }

    /**
     * Membentuk ringkasan narasi dari endpoint Tridharma yang benar-benar tersedia.
     *
     * @param  array<int, array<string, mixed>>  $activities
     * @param  array<int, array<string, mixed>>  $outputs
     * @param  array<int, array<string, mixed>>  $partnerships
     * @return array<string, mixed>
     */
    protected function buildSummaryFromApi(array $activities, array $outputs, array $partnerships): array
    {
        $research = array_values(array_filter($activities, fn (array $item): bool => (int) ($item['id_jenis_kegiatan'] ?? 0) === 1));
        $pkm = array_values(array_filter($activities, fn (array $item): bool => (int) ($item['id_jenis_kegiatan'] ?? 0) === 2));
        $countStudents = static function (array $items): int {
            return count(array_filter($items, function (array $item): bool {
                return collect($item['anggota'] ?? [])->contains(fn (array $member): bool => ! empty($member['id_mahasiswa']));
            }));
        };
        $outputName = static fn (array $item): string => strtolower((string) data_get($item, 'jenis_luaran.nama_jenis_luaran', ''));

        $international = count(array_filter($outputs, fn (array $item): bool => str_contains($outputName($item), 'internasional')));
        $national = count(array_filter($outputs, fn (array $item): bool => str_contains($outputName($item), 'nasional')));
        $prosiding = count(array_filter($outputs, fn (array $item): bool => str_contains($outputName($item), 'prosiding')));
        $hki = count(array_filter($outputs, fn (array $item): bool => str_contains($outputName($item), 'hki') || ! empty($item['nomor_sertifikat_hki'])));
        $activePartnerships = count(array_filter($partnerships, fn (array $item): bool => strtolower((string) ($item['status'] ?? '')) === 'aktif'));

        return [
            'penelitian' => [
                'total_kegiatan' => count($research),
                'melibatkan_mahasiswa' => $countStudents($research),
                'hibah_nasional_bima' => 0,
                'hibah_internal_polines' => 0,
                'hibah_internasional' => 0,
                'mandiri' => 0,
            ],
            'pkm' => [
                'total_kegiatan' => count($pkm),
                'melibatkan_mahasiswa' => $countStudents($pkm),
                'hibah_pkm_nasional' => 0,
                'hibah_internal' => 0,
                'hibah_internasional' => 0,
            ],
            'publikasi' => [
                'jurnal_internasional_scopus' => $international,
                'jurnal_nasional_sinta' => $national,
                'prosiding_seminar_ieee' => $prosiding,
                'buku_isbn' => count(array_filter($outputs, fn (array $item): bool => str_contains($outputName($item), 'buku'))),
            ],
            'hki' => [
                'paten_terdaftar' => $hki,
                'hak_cipta_program_komputer' => $hki,
            ],
            'kerjasama_dudika_aktif' => $activePartnerships,
            '_meta' => [
                'source' => 'api',
                'available' => true,
                'endpoints' => ['/kegiatan', '/luaran', '/kerja-sama'],
            ],
        ];
    }
}
