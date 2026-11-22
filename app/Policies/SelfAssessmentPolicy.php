<?php

namespace App\Policies;

use App\Models\SelfAssessment;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * SelfAssessmentPolicy
 *
 * Mengatur hak akses penilaian mandiri (Self Assessment) akreditasi.
 *
 * Berdasarkan evaluasi Klien & Dosen Pembimbing:
 *   - Peran Reviewer independen ditiadakan dan dilebur ke KAPRODI.
 *   - KAPRODI memiliki hak penuh untuk mereview, merevisi, menilai (skor rubrik),
 *     dan memverifikasi butir self-assessment, baik untuk butirnya sendiri maupun PIC lain.
 *   - ADMINISTRATOR memiliki akses penuh (super role).
 *   - REVIEWER tetap diizinkan sebagai fallback kompatibilitas peran lama.
 *   - DOSEN hanya memiliki akses lihat (read-only) atau ditolak untuk mutasi penilaian.
 */
class SelfAssessmentPolicy
{
    /**
     * Cek apakah user boleh melihat daftar self-assessment.
     */
    public function viewAny(Authenticatable $user): bool
    {
        $role = $this->getUserRole($user);

        return in_array($role, ['ADMINISTRATOR', 'KAPRODI', 'REVIEWER', 'DOSEN'], true);
    }

    /**
     * Cek apakah user boleh melihat detail penilaian mandiri.
     */
    public function view(Authenticatable $user, ?SelfAssessment $assessment = null): bool
    {
        $role = $this->getUserRole($user);

        return in_array($role, ['ADMINISTRATOR', 'KAPRODI', 'REVIEWER', 'DOSEN'], true);
    }

    /**
     * Cek apakah user boleh membuat penilaian mandiri baru.
     */
    public function create(Authenticatable $user): bool
    {
        return $this->canAssess($user);
    }

    /**
     * Cek apakah user boleh mengubah/merevisi penilaian mandiri (isi rubrik / skor / catatan).
     */
    public function update(Authenticatable $user, ?SelfAssessment $assessment = null): bool
    {
        return $this->canAssess($user);
    }

    /**
     * Cek apakah user boleh menghapus penilaian mandiri.
     */
    public function delete(Authenticatable $user, ?SelfAssessment $assessment = null): bool
    {
        $role = $this->getUserRole($user);

        return in_array($role, ['ADMINISTRATOR', 'KAPRODI', 'REVIEWER'], true);
    }

    /**
     * Cek apakah user boleh melakukan penilaian mandiri (memilih rubrik & input skor terbobot).
     */
    public function assess(Authenticatable $user): bool
    {
        return $this->canAssess($user);
    }

    /**
     * Cek apakah user boleh mengisi penjelasan prodi (khusus Kaprodi & Admin).
     */
    public function penjelasanProdi(Authenticatable $user): bool
    {
        $role = $this->getUserRole($user);

        return in_array($role, ['ADMINISTRATOR', 'KAPRODI'], true);
    }

    /**
     * Otoritas hak asesmen/review: Administrator, Kaprodi, dan Reviewer (legacy).
     */
    private function canAssess(Authenticatable $user): bool
    {
        $role = $this->getUserRole($user);

        return in_array($role, ['ADMINISTRATOR', 'KAPRODI', 'REVIEWER'], true);
    }

    /**
     * Ekstraksi string role dalam uppercase.
     */
    private function getUserRole(Authenticatable $user): string
    {
        return strtoupper((string) ($user->role ?? (method_exists($user, 'getRole') ? $user->getRole() : '')));
    }
}
