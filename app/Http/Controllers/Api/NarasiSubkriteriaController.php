<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreNarasiSubkriteriaRequest;
use App\Models\Instrumen;
use App\Models\MappingTimAkreditasi;
use App\Models\NarasiSubkriteria;
use App\Models\ProjectAkreditasi;
use App\Models\Subkriteria;
use App\Services\Narration\NarrationTemplateService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NarasiSubkriteriaController extends Controller
{
    use ApiResponseTrait;

    /**
     * Menyuntikkan service pembentuk template narasi.
     */
    public function __construct(
        protected NarrationTemplateService $narrationTemplateService,
    ) {}

    /**
     * B3: Menghasilkan template narasi draf terinjeksi nilai pakem (atau catatan parsial/kosong).
     */
    public function showTemplate(int $projectId, int $subkriteriaId): JsonResponse
    {
        $project = ProjectAkreditasi::find($projectId);
        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $subkriteria = Subkriteria::find($subkriteriaId);
        if (! $subkriteria) {
            return $this->errorResponse('Subkriteria tidak ditemukan', null, 404);
        }
        if (! $this->subkriteriaBelongsToProject($project, $subkriteria)) {
            return $this->errorResponse('Subkriteria tidak termasuk instrumen project ini', null, 404);
        }

        $data = $this->narrationTemplateService->generate($project, $subkriteria);

        $message = ($data['status_ketersediaan_data'] === 'Tersedia Lengkap')
            ? 'Template narasi subkriteria berhasil di-generate'
            : 'Template narasi dihasilkan dengan catatan data parsial';

        return $this->successResponse($data, $message);
    }

    /**
     * B4: Memvalidasi dan menyimpan narasi yang telah diedit/disesuaikan oleh Dosen PIC atau Kaprodi.
     */
    public function store(StoreNarasiSubkriteriaRequest $request, int $projectId, int $subkriteriaId): JsonResponse
    {
        $project = ProjectAkreditasi::find($projectId);
        if (! $project) {
            return $this->errorResponse('Project akreditasi tidak ditemukan', null, 404);
        }

        $subkriteria = Subkriteria::find($subkriteriaId);
        if (! $subkriteria) {
            return $this->errorResponse('Subkriteria tidak ditemukan', null, 404);
        }
        if (! $this->subkriteriaBelongsToProject($project, $subkriteria)) {
            return $this->errorResponse('Subkriteria tidak termasuk instrumen project ini', null, 404);
        }
        if (! $this->canEditNarration($request, $project, $subkriteria)) {
            return $this->errorResponse('Anda tidak memiliki hak menyimpan narasi untuk project/subkriteria ini', null, 403);
        }

        $user = $request->user();
        $disuntingOleh = (string) ($user->nama ?? $user->name ?? 'Dr. Eng. Riki Ulir, M.T.');
        $narasiText = (string) ($request->input('narasi_disunting') ?? $request->input('narasi'));
        $catatanRevisi = $request->input('catatan_revisi');

        $aggregate = $this->narrationTemplateService->getAggregation($project);
        $aggregate['nama_subkriteria'] = $subkriteria->nama_subkriteria;

        $narasi = NarasiSubkriteria::updateOrCreate(
            [
                'id_project' => $project->id,
                'id_subkriteria' => $subkriteria->id,
            ],
            [
                'narasi' => $narasiText,
                'disunting_oleh' => $disuntingOleh,
                'catatan_revisi' => $catatanRevisi,
                'data_agregasi' => $aggregate,
            ]
        );

        return $this->successResponse([
            'id' => $narasi->id,
            'subkriteria_id' => $narasi->id_subkriteria,
            'project_id' => $narasi->id_project,
            'narasi_final' => $narasi->narasi,
            'narasi' => $narasi->narasi,
            'disunting_oleh' => $narasi->disunting_oleh,
            'catatan_revisi' => $narasi->catatan_revisi,
            'data_agregasi' => $narasi->data_agregasi,
            'updated_at' => $narasi->updated_at?->toISOString() ?? now()->toISOString(),
        ], 'Narasi subkriteria berhasil disimpan');
    }

    /**
     * Memastikan subkriteria benar-benar berada dalam instrumen milik project.
     */
    private function subkriteriaBelongsToProject(ProjectAkreditasi $project, Subkriteria $subkriteria): bool
    {
        $instrument = Instrumen::query()
            ->where('id_versi_instrumen', $project->id_versi_instrumen)
            ->where('id_jenjang', $project->id_jenjang)
            ->where('id_jenis_instrumen', $project->id_jenis_instrumen)
            ->first();

        if (! $instrument) {
            return false;
        }

        return $subkriteria->kriteria()
            ->where('id_instrumen', $instrument->id)
            ->exists();
    }

    /**
     * Memastikan Kaprodi/administrator dapat edit, sedangkan dosen harus menjadi PJ atau PIC.
     */
    private function canEditNarration(Request $request, ProjectAkreditasi $project, Subkriteria $subkriteria): bool
    {
        $user = $request->user();
        $role = strtoupper((string) ($user->role ?? ''));

        if (in_array($role, ['ADMINISTRATOR', 'KAPRODI'], true)) {
            return true;
        }
        if ($role !== 'DOSEN') {
            return false;
        }

        $indicatorIds = $subkriteria->indikator()->pluck('indikator.id');

        return MappingTimAkreditasi::query()
            ->where('id_project', $project->id)
            ->whereIn('id_indikator', $indicatorIds)
            ->where('id_user', $user->id)
            ->whereIn('role', ['PJ', 'PIC'])
            ->exists();
    }
}
