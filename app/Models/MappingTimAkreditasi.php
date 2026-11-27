<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MappingTimAkreditasi extends Model
{
    use HasFactory;

    protected $table = 'mapping_tim_akreditasi';

    protected $fillable = [
        'id_project',
        'id_user',
        'id_indikator',
        'role',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_user' => 'integer', // Disesuaikan dengan API Kelompok 2
            'id_indikator' => 'integer',
            'role' => 'string',
        ];
    }

    protected $appends = ['role'];

    /**
     * Peran penugasan anggota tim pada indikator (misal: 'PJ' atau 'PIC').
     */
    public function getRoleAttribute(): string
    {
        return strtoupper($this->attributes['role'] ?? 'PIC');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }

    /**
     * Scope: Filter berdasarkan project akreditasi.
     */
    public function scopeForProject($query, int $projectId)
    {
        return $query->where('id_project', $projectId);
    }

    /**
     * Scope: Filter berdasarkan ID user / dosen.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope: Alias forUser untuk dosen penugasan.
     */
    public function scopeForDosen($query, int $userId)
    {
        return $query->where('id_user', $userId);
    }

    /**
     * Scope: Filter berdasarkan role tim (PJ atau PIC).
     */
    public function scopeForRole($query, string $role)
    {
        return $query->where('role', strtoupper($role));
    }

    /**
     * Scope: Filter penugasan pada indikator tertentu.
     */
    public function scopeForIndikator($query, int $indikatorId)
    {
        return $query->where('id_indikator', $indikatorId);
    }

    /**
     * Scope: Filter pasangan project dan indikator.
     */
    public function scopeForProjectIndikator($query, int $projectId, int $indikatorId)
    {
        return $query->where('id_project', $projectId)
            ->where('id_indikator', $indikatorId);
    }

    /**
     * Scope: Filter peran penugasan resmi (PJ atau PIC).
     */
    public function scopeAssignedRoles($query)
    {
        return $query->whereIn('role', ['PJ', 'PIC']);
    }

    /**
     * Scope: Eager loading relasi standar indikator dan project.
     */
    public function scopeWithDetails($query)
    {
        return $query->with([
            'indikator:id,id_subkriteria,kode_indikator,deskripsi_indikator,bobot',
            'indikator.subkriteria:id,id_kriteria,kode_subkriteria,nama_subkriteria',
            'indikator.subkriteria.kriteria:id,kode_kriteria,nama_kriteria',
            'project:id,nama_project,status_project',
        ]);
    }

    /**
     * Scope: Kecualikan indikator dari Kriteria Statis / Non-Handle (Kriteria 5: Tata Pamong, Keuangan, Sarpras).
     */
    public function scopeExcludeNonHandleCriteria($query)
    {
        return $query->whereDoesntHave('indikator.subkriteria.kriteria', function ($q) {
            $q->whereIn('kode_kriteria', ['K5', 'C.5', '5']);
        });
    }

    /**
     * Cek apakah user terdaftar sebagai PJ atau PIC pada butir indikator tertentu.
     */
    public static function isUserAssigned(int $userId, int $indikatorId): bool
    {
        return static::forUser($userId)
            ->forIndikator($indikatorId)
            ->assignedRoles()
            ->exists();
    }

    /**
     * Mengambil peta status self-assessment, evidence, dan narasi secara batch (bebas N+1).
     *
     * @param  array<int, int>  $projectIds
     * @param  array<int, int>  $indikatorIds
     * @param  array<int, int>  $subkriteriaIds
     * @return array{assessed: array<string, bool>, evidence: array<string, bool>, narasi: array<string, bool>}
     */
    public static function getAssignmentStatusMaps(array $projectIds, array $indikatorIds, array $subkriteriaIds): array
    {
        $assessedMap = [];
        $evidenceMap = [];
        $narasiMap = [];

        if ($projectIds !== [] && $indikatorIds !== []) {
            $assessedMap = SelfAssessment::query()
                ->whereIn('id_project', $projectIds)
                ->whereIn('id_indikator', $indikatorIds)
                ->whereNotNull('id_rubrik')
                ->get(['id_project', 'id_indikator'])
                ->mapWithKeys(fn ($row) => ["{$row->id_project}_{$row->id_indikator}" => true])
                ->all();

            $evidenceMap = ProjectIndicatorEvidence::query()
                ->whereIn('id_project', $projectIds)
                ->whereIn('id_indikator', $indikatorIds)
                ->get(['id_project', 'id_indikator'])
                ->mapWithKeys(fn ($row) => ["{$row->id_project}_{$row->id_indikator}" => true])
                ->all();
        }

        if ($projectIds !== [] && $subkriteriaIds !== []) {
            $narasiMap = NarasiSubkriteria::query()
                ->whereIn('id_project', $projectIds)
                ->whereIn('id_subkriteria', $subkriteriaIds)
                ->whereNotNull('narasi')
                ->where('narasi', '!=', '')
                ->get(['id_project', 'id_subkriteria'])
                ->mapWithKeys(fn ($row) => ["{$row->id_project}_{$row->id_subkriteria}" => true])
                ->all();
        }

        return [
            'assessed' => $assessedMap,
            'evidence' => $evidenceMap,
            'narasi' => $narasiMap,
        ];
    }
}
