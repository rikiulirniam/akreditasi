<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = [
        'id_upps',
        'kode_prodi',
        'nama_prodi',
        'akreditasi',
    ];

    protected function casts(): array
    {
        return [
            'id_upps' => 'integer',
        ];
    }

    /**
     * Relasi ke Unit Pengelola Program Studi (UPPS / Induk Prodi).
     */
    public function upps(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'id_upps');
    }

    /**
     * Relasi ke Program Studi di bawah UPPS ini.
     */
    public function prodiBawahan(): HasMany
    {
        return $this->hasMany(Prodi::class, 'id_upps');
    }

    /**
     * Relasi ke Project Akreditasi yang dimiliki program studi.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(ProjectAkreditasi::class, 'id_prodi');
    }
}
