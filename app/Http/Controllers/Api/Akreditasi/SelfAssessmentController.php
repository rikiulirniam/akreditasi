<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreSelfAssessmentRequest;
use App\Models\Bobot;
use App\Models\ProjectAkreditasi;
use App\Models\Rubrik;
use App\Models\SelfAssessment;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SelfAssessmentController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = SelfAssessment::with(['project', 'indikator', 'rubrik']);

        if ($request->has('id_project')) {
            $query->where('id_project', $request->query('id_project'));
        }

        if ($request->has('id_indikator')) {
            $query->where('id_indikator', $request->query('id_indikator'));
        }

        $data = $query->latest()->get();

        return $this->successResponse($data, 'Data penilaian mandiri (self assessment) berhasil diambil');
    }

    public function storeOrUpdate(StoreSelfAssessmentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $skorTerbobot = null;

        if (! empty($validated['id_rubrik'])) {
            $project = ProjectAkreditasi::findOrFail($validated['id_project']);
            $rubrik = Rubrik::findOrFail($validated['id_rubrik']);

            $bobot = Bobot::where('id_indikator', $validated['id_indikator'])
                ->where('id_jenis_instrumen', $project->id_jenis_instrumen)
                ->where('id_jenjang', $project->id_jenjang)
                ->first();

            if (! $bobot) {
                $bobot = Bobot::where('id_indikator', $validated['id_indikator'])->first();
            }

            $nilaiBobot = $bobot ? (float) $bobot->nilai_bobot : 1.0;
            $skorTerbobot = round((float) $rubrik->skor * $nilaiBobot, 2);
        }

        $assessment = SelfAssessment::updateOrCreate(
            [
                'id_project' => $validated['id_project'],
                'id_indikator' => $validated['id_indikator'],
            ],
            [
                'id_rubrik' => $validated['id_rubrik'] ?? null,
                'skor_terbobot' => $skorTerbobot,
                'catatan_reviewer' => $validated['catatan_reviewer'] ?? null,
                'tanggal_penilaian' => $validated['tanggal_penilaian'] ?? Carbon::now(),
                'reviewer_id' => $validated['reviewer_id'] ?? null,
            ]
        );

        $assessment->load(['project', 'indikator', 'rubrik']);

        return $this->successResponse(
            $assessment,
            'Penilaian reviewer berhasil disimpan dengan perhitungan skor terbobot otomatis: '.$skorTerbobot,
            200
        );
    }

    public function show(int $id): JsonResponse
    {
        $assessment = SelfAssessment::with(['project', 'indikator', 'rubrik'])->find($id);

        if (! $assessment) {
            return $this->errorResponse('Data penilaian mandiri tidak ditemukan', null, 404);
        }

        return $this->successResponse($assessment, 'Detail penilaian mandiri berhasil diambil');
    }

    public function destroy(int $id): JsonResponse
    {
        $assessment = SelfAssessment::find($id);

        if (! $assessment) {
            return $this->errorResponse('Data penilaian mandiri tidak ditemukan', null, 404);
        }

        $assessment->delete();

        return $this->successResponse(null, 'Data penilaian mandiri berhasil dihapus');
    }
}
