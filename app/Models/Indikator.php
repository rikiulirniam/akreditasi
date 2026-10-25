<?php

namespace App\Models;

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

    protected function casts(): array
    {
        return [
            'id_subkriteria' => 'integer',
            'bobot' => 'decimal:2',
        ];
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
     * Relasi ke Lembar Kerja Prodi untuk indikator ini.
     */
    public function lembarProdi(): HasMany
    {
        return $this->hasMany(LembarProdi::class, 'id_indikator');
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
}
