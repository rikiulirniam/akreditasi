<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceSpmi extends Model
{
    use HasFactory;

    protected $table = 'evidence_spmi';

    protected $fillable = [
        'project_id',
        'link_bukti_evaluasi',
        'deskripsi_bukti_evaluasi',
        'link_bukti_pengendalian',
        'deskripsi_bukti_pengendalian',
        'link_bukti_dampak',
        'deskripsi_bukti_dampak',
        'link_dokumen_implementasi',
        'deskripsi_dokumen_implementasi',
    ];

    /**
     * Kolom pilar evidence (link + deskripsi).
     *
     * @var array<int, string>
     */
    public const PILAR_COLUMNS = [
        'link_bukti_evaluasi',
        'deskripsi_bukti_evaluasi',
        'link_bukti_pengendalian',
        'deskripsi_bukti_pengendalian',
        'link_bukti_dampak',
        'deskripsi_bukti_dampak',
        'link_dokumen_implementasi',
        'deskripsi_dokumen_implementasi',
    ];

    /**
     * 4 Pilar Dokumen Mutu Institusi SPMI.
     *
     * @var array<int, array{key: string, nama_pilar: string, kolom_link: string, kolom_deskripsi: string}>
     */
    public const PILAR_DEFINITIONS = [
        1 => [
            'key' => 'pilar_1_evaluasi',
            'nama_pilar' => 'Laporan Audit Mutu Internal (AMI & Monev)',
            'kolom_link' => 'link_bukti_evaluasi',
            'kolom_deskripsi' => 'deskripsi_bukti_evaluasi',
        ],
        2 => [
            'key' => 'pilar_2_pengendalian',
            'nama_pilar' => 'Rapat Tinjauan Manajemen (RTM & RTL)',
            'kolom_link' => 'link_bukti_pengendalian',
            'kolom_deskripsi' => 'deskripsi_bukti_pengendalian',
        ],
        3 => [
            'key' => 'pilar_3_dampak',
            'nama_pilar' => 'Capaian IKU & Survei Kepuasan Stakeholder',
            'kolom_link' => 'link_bukti_dampak',
            'kolom_deskripsi' => 'deskripsi_bukti_dampak',
        ],
        4 => [
            'key' => 'pilar_4_implementasi',
            'nama_pilar' => 'Dokumen Implementasi (Buku Kebijakan SPMI, Manual Mutu, SOP PPEPP)',
            'kolom_link' => 'link_dokumen_implementasi',
            'kolom_deskripsi' => 'deskripsi_dokumen_implementasi',
        ],
    ];

    /**
     * Cast attributes.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'project_id' => 'integer',
        ];
    }

    // ------------------------------------------------------------------
    // Local Scopes
    // ------------------------------------------------------------------

    /**
     * Scope: filter evidence berdasarkan project_id.
     */
    public function scopeForProject(Builder $query, int $projectId): Builder
    {
        return $query->where('project_id', $projectId);
    }

    // ------------------------------------------------------------------
    // Computed helpers
    // ------------------------------------------------------------------

    /**
     * Hitung jumlah pilar yang sudah terisi (memiliki link).
     */
    public function countFilledPilars(): int
    {
        $linkColumns = [
            'link_bukti_evaluasi',
            'link_bukti_pengendalian',
            'link_bukti_dampak',
            'link_dokumen_implementasi',
        ];

        return collect($linkColumns)
            ->filter(fn (string $col): bool => ! empty($this->getAttribute($col)))
            ->count();
    }

    // ------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------

    /**
     * Relasi ke model ProjectAkreditasi.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'project_id');
    }

    /**
     * Relasi ke model ProjectAkreditasi (alias eksplisit).
     */
    public function projectAkreditasi(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'project_id');
    }
}
