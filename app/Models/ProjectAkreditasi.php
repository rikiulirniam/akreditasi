<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'tanggal_verifikasi_akreditasi',
        'nomor_sk_akreditasi',
    ];

    protected function casts(): array
    {
        return [
            'id_prodi' => 'integer', // Disesuaikan dengan ID dari API Kelompok 2
            'id_versi_instrumen' => 'integer',
            'id_jenjang' => 'integer',
            'id_jenis_instrumen' => 'integer',
            'tahun_target_submit' => 'integer',
            'tanggal_verifikasi_akreditasi' => 'date:Y-m-d',
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
     * Relasi ke bukti yang diunggah untuk setiap indikator project.
     */
    public function indikatorEvidences(): HasMany
    {
        return $this->hasMany(ProjectIndicatorEvidence::class, 'id_project');
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

    /**
     * Relasi ke Evidence SPMI (One-to-One).
     */
    public function evidenceSpmi(): HasOne
    {
        return $this->hasOne(EvidenceSpmi::class, 'project_id');
    }

    /**
     * Scope untuk eager loading relasi master dasar.
     */
    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with(['versiInstrumen', 'jenjang', 'jenisInstrumen']);
    }

    /**
     * Scope untuk eager loading seluruh detail relasi project akreditasi.
     */
    public function scopeWithFullDetails(Builder $query): Builder
    {
        return $query->with([
            'versiInstrumen',
            'jenjang',
            'jenisInstrumen',
            'mappingTim.indikator',
            'lembarProdi.buktis',
            'selfAssessments.rubrik',
        ]);
    }

    /**
     * Scope untuk memfilter project berdasarkan ID Program Studi.
     */
    public function scopeFilterByProdi(Builder $query, mixed $idProdi): Builder
    {
        if (! empty($idProdi)) {
            $query->where('id_prodi', $idProdi);
        }

        return $query;
    }

    /**
     * Scope untuk memfilter project berdasarkan ID Jenjang.
     */
    public function scopeFilterByJenjang(Builder $query, mixed $idJenjang): Builder
    {
        if (! empty($idJenjang)) {
            $query->where('id_jenjang', $idJenjang);
        }

        return $query;
    }

    /**
     * Scope untuk memfilter project berdasarkan status siklus akreditasi.
     */
    public function scopeFilterByStatus(Builder $query, ?string $status): Builder
    {
        if (! empty($status)) {
            $query->where('status_project', $status);
        }

        return $query;
    }

    /**
     * Scope untuk hanya menyertakan project dengan status aktif (bukan Cancel atau Selesai).
     */
    public function scopeStatusActive(Builder $query): Builder
    {
        return $query->whereNotIn('status_project', ['Cancel', 'Selesai']);
    }

    /**
     * Scope pencarian nama project akreditasi.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (! empty($keyword)) {
            $query->where('nama_project', 'like', "%{$keyword}%");
        }

        return $query;
    }
}
