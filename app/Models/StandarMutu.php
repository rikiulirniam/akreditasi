<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StandarMutu extends Model
{
    use HasFactory;

    protected $table = 'standar_mutu';

    protected $fillable = [
        'kode_standar',
        'nama_standar',
        'deskripsi',
    ];

    /**
     * Relasi ke entri Data Audit SPMI terkait standar ini.
     */
    public function dataSpmiAudit(): HasMany
    {
        return $this->hasMany(DataSpmiAudit::class, 'id_standar');
    }
}
