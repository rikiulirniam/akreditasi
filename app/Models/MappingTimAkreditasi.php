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
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_user' => 'integer', // Disesuaikan dengan API Kelompok 2
            'id_indikator' => 'integer',
        ];
    }

    protected $appends = ['role'];

    /**
     * Anggota tim akreditasi yang dipetakan pada indikator/butir selalu ber-role DOSEN.
     */
    public function getRoleAttribute(): string
    {
        return $this->attributes['role'] ?? 'DOSEN';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }
}
