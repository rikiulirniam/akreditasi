<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBukti extends Model
{
    use HasFactory;

    protected $table = 'jenis_bukti';

    protected $fillable = [
        'nama_jenis_bukti',
    ];

    /**
     * Relasi ke file Bukti yang bertipe jenis bukti ini.
     */
    public function buktis(): HasMany
    {
        return $this->hasMany(Bukti::class, 'id_jenis_bukti');
    }
}
