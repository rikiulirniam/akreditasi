<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectAkreditasi extends Model
{
    use HasFactory;

    protected $table = 'project_akreditasi';

    protected $fillable = [
        'id_prodi',
        'id_versi_instrumen',
        'id_jenjang',
        'id_jenis_instrumen',
        'nama_project',
        'tahun_target_submit',
        'status_project',
    ];

    protected function casts(): array
    {
        return [
            'id_prodi' => 'integer', // Disesuaikan dengan ID dari API Kelompok 2
            'id_versi_instrumen' => 'integer',
            'id_jenjang' => 'integer',
            'id_jenis_instrumen' => 'integer',
            'tahun_target_submit' => 'integer',
        ];
    }

    /**
     * Relasi ke Versi Instrumen.
     */
    public function versiInstrumen(): BelongsTo
    {
        return $this->belongsTo(VersiInstrumen::class, 'id_versi_instrumen');
    }

    /**
     * Relasi ke Jenjang program studi.
     */
    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang');
    }

    /**
     * Relasi ke Jenis Instrumen.
     */
    public function jenisInstrumen(): BelongsTo
    {
        return $this->belongsTo(JenisInstrumen::class, 'id_jenis_instrumen');
    }

    /**
     * Relasi ke Mapping Tim Akreditasi.
     */
    public function mappingTim(): HasMany
    {
        return $this->hasMany(MappingTimAkreditasi::class, 'id_project');
    }

    /**
     * Relasi BelongsToMany ke Indikator yang ditugaskan.
     */
    public function indikators(): BelongsToMany
    {
        return $this->belongsToMany(Indikator::class, 'mapping_tim_akreditasi', 'id_project', 'id_indikator')
            ->withPivot('id', 'id_user')
            ->withTimestamps();
    }

    /**
     * Relasi ke Lembar Kerja Prodi.
     */
    public function lembarProdi(): HasMany
    {
        return $this->hasMany(LembarProdi::class, 'id_project');
    }

    /**
     * Relasi ke Self Assessment / Penilaian Mandiri.
     */
    public function selfAssessments(): HasMany
    {
        return $this->hasMany(SelfAssessment::class, 'id_project');
    }

    /**
     * Relasi ke Data Audit SPMI.
     */
    public function dataSpmiAudit(): HasMany
    {
        return $this->hasMany(DataSpmiAudit::class, 'id_project');
    }

    /**
     * Relasi ke Data Sarpras Prodi.
     */
    public function dataSarprasProdi(): HasMany
    {
        return $this->hasMany(DataSarprasProdi::class, 'id_project');
    }
}
