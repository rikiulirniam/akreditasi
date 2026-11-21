<?php

namespace App\Policies;

use App\Models\Indikator;
use App\Models\MappingTimAkreditasi;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * IndikatorAssignmentPolicy
 *
 * Mengatur siapa yang boleh mengakses (upload bukti / edit data) suatu butir indikator.
 *
 * Aturan hak akses:
 *   - ADMINISTRATOR & KAPRODI : bebas akses semua indikator tanpa pembatasan.
 *   - DOSEN                   : hanya boleh mengakses indikator yang ia ditunjuk
 *                               sebagai PJ atau PIC pada tabel mapping_tim_akreditasi.
 *   - Role lain               : ditolak (false).
 */
class IndikatorAssignmentPolicy
{
    /**
     * Cek apakah user boleh melihat detail indikator.
     */
    public function view(Authenticatable $user, Indikator $indikator): bool
    {
        return $this->canAccessIndikator($user, $indikator->id);
    }

    /**
     * Cek apakah user boleh mengedit data indikator (isi self-assessment, dsb).
     */
    public function editData(Authenticatable $user, Indikator $indikator): bool
    {
        return $this->canAccessIndikator($user, $indikator->id);
    }

    /**
     * Cek apakah user boleh mengunggah bukti dukung untuk indikator ini.
     */
    public function uploadEvidence(Authenticatable $user, Indikator $indikator): bool
    {
        return $this->canAccessIndikator($user, $indikator->id);
    }

    /**
     * Logika utama: tentukan apakah user boleh mengakses indikator tertentu.
     */
    private function canAccessIndikator(Authenticatable $user, int $indikatorId): bool
    {
        $role = strtoupper((string) ($user->role ?? (method_exists($user, 'getRole') ? $user->getRole() : '')));
        $userId = $user->id ?? $user->getAuthIdentifier();

        // ADMINISTRATOR & KAPRODI → akses penuh ke semua indikator
        if (in_array($role, ['ADMINISTRATOR', 'KAPRODI'], true)) {
            return true;
        }

        // DOSEN → hanya boleh jika terdaftar sebagai PJ atau PIC
        // pada tabel mapping_tim_akreditasi untuk indikator yang bersangkutan
        if ($role === 'DOSEN') {
            return MappingTimAkreditasi::isUserAssigned((int) $userId, $indikatorId);
        }

        // Role lain (reviewer, operator, dll) → tolak
        return false;
    }
}
