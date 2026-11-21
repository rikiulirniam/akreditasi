<?php

namespace App\Services\Akreditasi;

use App\Models\Indikator;
use App\Models\Instrumen;
use App\Models\MappingTimAkreditasi;
use App\Models\ProjectAkreditasi;
use App\Models\ProjectIndicatorEvidence;
use App\Models\SelfAssessment;

class DashboardMetricsService
{
    /**
     * Menghitung progres seluruh kriteria dan bukti evidence untuk satu project.
     */
    public function getDashboardProgress(ProjectAkreditasi $project): array
    {
        $instrument = $this->findProjectInstrument($project);

        if (! $instrument) {
            return [
                'project_id' => $project->id,
                'kriteria' => [],
                'total_indikator' => 0,
                'indikator_terisi_bukti' => 0,
                'progres_total_persen' => 0,
                'instrument_found' => false,
            ];
        }

        $criteria = $instrument->kriterias()
            ->with([
                'subkriteria' => fn ($query) => $query->orderBy('kode_subkriteria'),
                'subkriteria.indikator' => fn ($query) => $query->orderBy('kode_indikator'),
            ])
            ->orderBy('kode_kriteria')
            ->get();

        $indicatorIds = $criteria
            ->flatMap(fn ($criterion) => $criterion->subkriteria->flatMap(
                fn ($subcriterion) => $subcriterion->indikator->pluck('id')
            ))
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->values();

        $evidencedIndicatorIds = ProjectIndicatorEvidence::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->whereNotNull('link_evidence')
            ->where('link_evidence', '<>', '')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();

        $criteriaProgress = $criteria->map(function ($criterion) use ($evidencedIndicatorIds): array {
            $indicators = $criterion->subkriteria->flatMap(
                fn ($subcriterion) => $subcriterion->indikator
            );
            $totalIndicators = $indicators->count();
            $completedIndicators = $indicators->filter(
                fn (Indikator $indicator) => $evidencedIndicatorIds->has((int) $indicator->id)
            )->count();

            return [
                'id' => $criterion->id,
                'kode_kriteria' => $criterion->kode_kriteria,
                'nama_kriteria' => $criterion->nama_kriteria,
                'total_indikator' => $totalIndicators,
                'indikator_terisi_bukti' => $completedIndicators,
                'progres_persen' => $totalIndicators > 0
                    ? round(($completedIndicators / $totalIndicators) * 100, 2)
                    : 0,
            ];
        })->values();

        $totalIndicators = $indicatorIds->count();
        $completedIndicators = $evidencedIndicatorIds->filter(
            fn ($value, $key) => $indicatorIds->contains((int) $key)
        )->count();

        return [
            'project_id' => $project->id,
            'kriteria' => $criteriaProgress,
            'total_indikator' => $totalIndicators,
            'indikator_terisi_bukti' => $completedIndicators,
            'progres_total_persen' => $totalIndicators > 0
                ? round(($completedIndicators / $totalIndicators) * 100, 2)
                : 0,
            'instrument_found' => true,
        ];
    }

    /**
     * Mengumpulkan indikator yang belum memiliki PIC, evidence, atau skor reviewer.
     */
    public function getReadiness(ProjectAkreditasi $project): array
    {
        $instrument = $this->findProjectInstrument($project);

        if (! $instrument) {
            return [
                'project_id' => $project->id,
                'total_indikator_kritis' => 0,
                'indikator_belum_siap' => [],
                'jumlah_indikator_belum_siap' => 0,
                'siap_submit' => false,
                'instrument_found' => false,
            ];
        }

        $indicators = Indikator::query()
            ->forInstrument($instrument->id)
            ->with(['subkriteria.kriteria'])
            ->orderBy('kode_indikator')
            ->get();

        $indicatorIds = $indicators->pluck('id');
        $picAssignments = MappingTimAkreditasi::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->where(function ($query): void {
                $query->whereNull('role')->orWhereRaw('UPPER(role) = ?', ['PIC']);
            })
            ->whereNotNull('id_user')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();
        $evidencedIndicators = Indikator::query()
            ->forInstrument($instrument->id)
            ->withProjectEvidence($project->id)
            ->pluck('id')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();
        $scoredIndicators = SelfAssessment::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->whereNotNull('skor_terbobot')
            ->pluck('id_indikator')
            ->map(fn ($indicatorId) => (int) $indicatorId)
            ->flip();

        $notReadyIndicators = $indicators->map(function (Indikator $indicator) use (
            $picAssignments,
            $evidencedIndicators,
            $scoredIndicators
        ): ?array {
            $missing = [];

            if (! $picAssignments->has((int) $indicator->id)) {
                $missing[] = 'pic';
            }
            if (! $evidencedIndicators->has((int) $indicator->id)) {
                $missing[] = 'link_evidence';
            }
            if (! $scoredIndicators->has((int) $indicator->id)) {
                $missing[] = 'skor_reviewer';
            }

            if ($missing === []) {
                return null;
            }

            return [
                'id_indikator' => $indicator->id,
                'kode_indikator' => $indicator->kode_indikator,
                'deskripsi_indikator' => $indicator->deskripsi_indikator,
                'belum_terpenuhi' => $missing,
            ];
        })->filter()->values();

        return [
            'project_id' => $project->id,
            'total_indikator_kritis' => $indicators->count(),
            'indikator_belum_siap' => $notReadyIndicators,
            'jumlah_indikator_belum_siap' => $notReadyIndicators->count(),
            'siap_submit' => $notReadyIndicators->isEmpty(),
            'instrument_found' => true,
        ];
    }

    /**
     * Mencari instrumen yang sesuai dengan konfigurasi master data project.
     */
    public function findProjectInstrument(ProjectAkreditasi $project): ?Instrumen
    {
        return Instrumen::query()
            ->where('id_versi_instrumen', $project->id_versi_instrumen)
            ->where('id_jenjang', $project->id_jenjang)
            ->where('id_jenis_instrumen', $project->id_jenis_instrumen)
            ->first();
    }
}
