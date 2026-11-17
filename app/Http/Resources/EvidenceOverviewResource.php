<?php

namespace App\Http\Resources;

use App\Models\ProjectAkreditasi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ProjectAkreditasi $resource
 */
class EvidenceOverviewResource extends JsonResource
{
    /**
     * Menyusun rekapitulasi evidence overview untuk sebuah project.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $evidence = $this->resource->evidenceSpmi;

        $audits = $this->resource->dataSpmiAudit;
        $openCount = $audits->where('status_penyelesaian', 'Open')->count();
        $closedCount = $audits->where('status_penyelesaian', 'Closed')->count();

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
                'created_at' => $evidence->created_at,
                'updated_at' => $evidence->updated_at,
            ] : null,
            'assigned_indicators' => $assignedIndicators,
            'audit_summary' => [
                'total' => $audits->count(),
                'open' => $openCount,
                'closed' => $closedCount,
            ],
            'audits' => $audits->map(function ($audit) {
                return [
                    'id' => $audit->id,
                    'id_indikator' => $audit->id_indikator,
                    'jenis_kegiatan' => $audit->jenis_kegiatan,
                    'tanggal_pelaksanaan' => $audit->tanggal_pelaksanaan?->toDateString(),
                    'tahun_audit' => $audit->tahun_audit,
                    'temuan' => $audit->temuan,
                    'tindak_lanjut' => $audit->tindak_lanjut,
                    'status_penyelesaian' => $audit->status_penyelesaian,
                ];
            }),
        ];
    }
}
