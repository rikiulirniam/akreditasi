<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisInstrumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_instrumen';

    protected $fillable = [
        'nama_jenis',
    ];

    /**
     * Relasi ke Bobot indikator untuk jenis instrumen ini.
     */
    public function bobots(): HasMany
    {
        return $this->hasMany(Bobot::class, 'id_jenis_instrumen');
    }

    /**
     * Relasi ke Project Akreditasi untuk jenis instrumen ini.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(ProjectAkreditasi::class, 'id_jenis_instrumen');
    }
}
