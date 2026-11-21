<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indikator extends Model
{
    use HasFactory;

    protected $table = 'indikator';

    protected $fillable = [
        'id_subkriteria',
        'kode_indikator',
        'deskripsi_indikator',
        'bobot',
    ];

    protected $appends = [
        'rubriks_count',
        'rubrik_count',
        'target_sumber_data',
        'kategori_sumber',
    ];

    public function getRubriksCountAttribute(): int
    {
        if (isset($this->attributes['rubriks_count'])) {
            return (int) $this->attributes['rubriks_count'];
        }
        if (isset($this->attributes['rubrik_count'])) {
            return (int) $this->attributes['rubrik_count'];
        }
        if ($this->relationLoaded('rubriks')) {
            return $this->rubriks->count();
        }
        if ($this->relationLoaded('rubrik')) {
            return $this->rubrik->count();
        }

        return 0;
    }

    public function getRubrikCountAttribute(): int
    {
        return $this->rubriks_count;
    }

    /**
     * Pemetaan sumber data riil (API Kelompok 2 vs Bukti SPMI) untuk eliminasi kompleksitas lembar manual.
     */
    public function getTargetSumberDataAttribute(): string
    {
        $kode = (string) ($this->kode_indikator ?? '');

        // Indikator terkait dosen, kurikulum, mahasiswa ditarik dari API Kelompok 2
        if (str_contains($kode, 'C.2.2') || str_contains($kode, 'B.1') || str_contains($kode, 'C.2.1') || str_contains($kode, 'C.5.2')) {
            return 'API Kelompok 2 (Data Master Dosen & Prodi)';
        }

        // Indikator terkait SPMI, AMI, RTM, Sarpras, Keuangan dari SPMI Internal
        return 'Bukti Upload SPMI / Audit Mutu Internal';
    }

    /**
     * Kategori sumber data: EXTERNAL_API atau SPMI_EVIDENCE.
     */
    public function getKategoriSumberAttribute(): string
    {
        $kode = (string) ($this->kode_indikator ?? '');

        if (str_contains($kode, 'C.2.2') || str_contains($kode, 'B.1') || str_contains($kode, 'C.2.1') || str_contains($kode, 'C.5.2')) {
            return 'EXTERNAL_API';
        }

        return 'SPMI_EVIDENCE';
    }

    protected function casts(): array
    {
        return [
            'id_subkriteria' => 'integer',
            'bobot' => 'decimal:2',
        ];
    }

    /**
     * Scope hierarki lengkap indikator (hanya kolom data esensial, tanpa opsi rubrik berulang).
     */
    public function scopeCompleteHierarchy(Builder $query): Builder
    {
        return $query->select([
            'id',
            'id_subkriteria',
            'kode_indikator',
            'deskripsi_indikator',
            'bobot',
        ])->orderBy('kode_indikator');
    }

    /**
     * Scope untuk eager load subkriteria, kriteria, dan hitungan rubrik.
     */
    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with(['subkriteria.kriteria'])
            ->withCount('rubriks');
    }

    /**
     * Scope untuk filter berdasarkan ID subkriteria.
     */
    public function scopeFilterBySubkriteria(Builder $query, ?int $idSubkriteria = null): Builder
    {
        if ($idSubkriteria !== null) {
            $query->where('id_subkriteria', $idSubkriteria);
        }

        return $query;
    }

    /**
     * Scope untuk detail indikator dengan opsi rubrik terurut.
     */
    public function scopeWithDetailedRubriks(Builder $query): Builder
    {
        return $query->with([
            'subkriteria.kriteria',
            'rubriks' => function ($q): void {
                $q->orderBy('skor');
            },
        ])->withCount('rubriks');
    }

    /**
     * Proteksi soft guard: cek apakah indikator sedang dipakai dalam transaksi aktif.
     */
    public function isUsedInActiveTransactions(): bool
    {
        return $this->selfAssessments()->exists()
            || $this->mappingTim()->exists()
            || $this->dataSpmiAudit()->exists();
    }

    /**
     * Relasi ke Subkriteria induk.
     */
    public function subkriteria(): BelongsTo
    {
        return $this->belongsTo(Subkriteria::class, 'id_subkriteria');
    }

    /**
     * Relasi ke Rubrik penilaian untuk indikator ini.
     */
    public function rubriks(): HasMany
    {
        return $this->hasMany(Rubrik::class, 'id_indikator');
    }

    /**
     * Alias relasi ke Rubrik.
     */
    public function rubrik(): HasMany
    {
        return $this->hasMany(Rubrik::class, 'id_indikator');
    }

    /**
     * Relasi ke entri Mapping Tim Akreditasi.
     */
    public function mappingTim(): HasMany
    {
        return $this->hasMany(MappingTimAkreditasi::class, 'id_indikator');
    }

    /**
     * Relasi BelongsToMany ke Project Akreditasi melalui mapping tim akreditasi.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(ProjectAkreditasi::class, 'mapping_tim_akreditasi', 'id_indikator', 'id_project')
            ->withPivot('id', 'id_user')
            ->withTimestamps();
    }

    /**
     * Relasi ke Self Assessment / Penilaian Mandiri untuk indikator ini.
     */
    public function selfAssessments(): HasMany
    {
        return $this->hasMany(SelfAssessment::class, 'id_indikator');
    }

    /**
     * Relasi ke rekaman Audit SPMI terkait indikator ini.
     */
    public function dataSpmiAudit(): HasMany
    {
        return $this->hasMany(DataSpmiAudit::class, 'id_indikator');
    }

    /**
     * Relasi indikator ke seluruh link evidence milik project.
     */
    public function projectEvidences(): HasMany
    {
        return $this->hasMany(ProjectIndicatorEvidence::class, 'id_indikator');
    }

    /**
     * Scope indikator milik instrumen tertentu.
     */
    public function scopeForInstrument(Builder $query, string $instrumentId): Builder
    {
        return $query->whereHas('subkriteria.kriteria', function (Builder $query) use ($instrumentId): void {
            $query->where('id_instrumen', $instrumentId);
        });
    }

    /**
     * Scope indikator yang memiliki link evidence valid pada project.
     */
    public function scopeWithProjectEvidence(Builder $query, int $projectId): Builder
    {
        return $query->whereHas('projectEvidences', function (Builder $query) use ($projectId): void {
            $query->where('id_project', $projectId)
                ->whereNotNull('link_evidence')
                ->where('link_evidence', '<>', '');
        });
    }
}
