<?php

namespace App\Http\Resources;

use App\Models\EvidenceSpmi;
use App\Models\ProjectAkreditasi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ProjectAkreditasi $resource
 */
class EvidenceOverviewResource extends JsonResource
{
    /**
     * Menyusun rekapitulasi evidence overview (disederhanakan).
     *
     * Fokus: media penyimpanan dokumen evidence penjaminan mutu yang
     * terhubung langsung ke indikator akreditasi. Tanpa siklus audit.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $evidence = $this->resource->evidenceSpmi;

        // Indikator yang ditugaskan ke project melalui mapping tim
        $mappings = $this->resource->mappingTim;
        $assignedIndicators = $mappings->map(function ($mapping) {
            return [
                'id_indikator' => $mapping->id_indikator,
                'id_user' => $mapping->id_user,
                'role' => $mapping->role,
                'indikator' => $mapping->relationLoaded('indikator') && $mapping->indikator ? [
                    'id' => $mapping->indikator->id,
                    'kode_indikator' => $mapping->indikator->kode_indikator,
                    'deskripsi_indikator' => $mapping->indikator->deskripsi_indikator,
                ] : null,
            ];
        });

        return [
            'project' => [
                'id' => $this->resource->id,
                'nama_project' => $this->resource->nama_project,
                'status_project' => $this->resource->status_project,
                'id_prodi' => $this->resource->id_prodi,
                'tahun_target_submit' => $this->resource->tahun_target_submit,
            ],
            'evidence' => $evidence ? [
                'id' => $evidence->id,
                'pilar_1_evaluasi' => [
                    'link' => $evidence->link_bukti_evaluasi,
                    'deskripsi' => $evidence->deskripsi_bukti_evaluasi,
                ],
                'pilar_2_pengendalian' => [
                    'link' => $evidence->link_bukti_pengendalian,
                    'deskripsi' => $evidence->deskripsi_bukti_pengendalian,
                ],
                'pilar_3_dampak' => [
                    'link' => $evidence->link_bukti_dampak,
                    'deskripsi' => $evidence->deskripsi_bukti_dampak,
                ],
                'pilar_4_implementasi' => [
                    'link' => $evidence->link_dokumen_implementasi,
                    'deskripsi' => $evidence->deskripsi_dokumen_implementasi,
                ],
                'pilar_terisi' => $evidence->countFilledPilars(),
                'created_at' => $evidence->created_at,
                'updated_at' => $evidence->updated_at,
            ] : null,
            'kelengkapan_pilar' => [
                'total_pilar' => 4,
                'terisi' => $evidence ? $evidence->countFilledPilars() : 0,
                'belum_terisi' => $evidence ? 4 - $evidence->countFilledPilars() : 4,
            ],
            'assigned_indicators' => $assignedIndicators,
        ];
    }
}
