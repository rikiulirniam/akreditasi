<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenjang extends Model
{
    use HasFactory;

    protected $table = 'jenjang';

    protected $fillable = [
        'nama_jenjang',
    ];

    /**
     * Relasi ke Project Akreditasi untuk jenjang ini.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(ProjectAkreditasi::class, 'id_jenjang');
    }

    /**
     * Relasi ke versi instrumen melalui tabel penghubung.
     */
    public function versiInstrumens(): BelongsToMany
    {
        return $this->belongsToMany(
            VersiInstrumen::class,
            'versi_instrumen_jenjang',
            'id_jenjang',
            'id_versi_instrumen'
        )->withPivot('status_aktif')
            ->withTimestamps();
    }
}
