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
}
