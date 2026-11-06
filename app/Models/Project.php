<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model Project (alias / representasi dari ProjectAkreditasi).
 */
class Project extends ProjectAkreditasi
{
    /**
     * Relasi ke Evidence SPMI (One-to-One).
     */
    public function evidenceSpmi(): HasOne
    {
        return $this->hasOne(EvidenceSpmi::class, 'project_id');
    }
}
