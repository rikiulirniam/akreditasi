<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSpmiAudit extends Model
{
    use HasFactory;

    protected $table = 'data_spmi_audit';

    protected $fillable = [
        'id_project',
        'id_indikator',
        'jenis_kegiatan',
        'tanggal_pelaksanaan',
        'tahun_audit',
        'temuan',
        'tindak_lanjut',
        'status_penyelesaian',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_indikator' => 'integer',
            'tahun_audit' => 'integer',
            'tanggal_pelaksanaan' => 'date',
        ];
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
     * Scope untuk menyaring temuan audit SPMI berdasarkan parameter query.
     *
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(isset($filters['id_project']), fn (Builder $q) => $q->where('id_project', $filters['id_project']))
            ->when(isset($filters['jenis_kegiatan']), fn (Builder $q) => $q->where('jenis_kegiatan', $filters['jenis_kegiatan']))
            ->when(isset($filters['tahun_audit']), fn (Builder $q) => $q->where('tahun_audit', $filters['tahun_audit']))
            ->when(isset($filters['status_penyelesaian']), fn (Builder $q) => $q->where('status_penyelesaian', $filters['status_penyelesaian']));
    }
}
