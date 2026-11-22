<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreSelfAssessmentRequest;
use App\Http\Requests\Akreditasi\UpdatePenjelasanProdiRequest;
use App\Models\Indikator;
use App\Models\Rubrik;
use App\Models\SelfAssessment;
use App\Services\Akreditasi\ScoringCalculationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SelfAssessmentController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ScoringCalculationService $scoringService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = SelfAssessment::with(['project', 'indikator', 'rubrik']);

        if ($request->filled('id_project')) {
            $query->forProject((int) $request->query('id_project'));
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
            $rubrik = Rubrik::findOrFail($validated['id_rubrik']);
            $indikator = Indikator::findOrFail($validated['id_indikator']);
            $skorTerbobot = $this->scoringService->calculateItemScore($indikator->bobot, $rubrik->skor);
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

    /**
     * Menambahkan atau memperbarui tanggapan/penjelasan klarifikasi dari pihak prodi atas catatan reviewer.
     */
    public function penjelasanProdi(UpdatePenjelasanProdiRequest $request, int $id): JsonResponse
    {
        $assessment = SelfAssessment::with(['project', 'indikator', 'rubrik'])->find($id);

        if (! $assessment) {
            return $this->errorResponse('Data penilaian mandiri tidak ditemukan', null, 404);
        }

        $assessment->update([
            'tanggapan_kaprodi' => $request->validated('tanggapan_kaprodi'),
        ]);

        return $this->successResponse($assessment, 'Penjelasan / tanggapan prodi berhasil disimpan');
    }

    /**
     * Rekapitulasi review summary penilaian project akreditasi.
     */
    public function reviewSummary(int $id): JsonResponse
    {
        $summary = $this->scoringService->calculateProjectReviewSummary($id);

        return $this->successResponse($summary, 'Rekapitulasi review penilaian project berhasil diambil');
    }

    /**
     * Menghitung hasil simulasi akreditasi (skor per subkriteria, total NA, predikat, dan detail simulasi).
     */
    public function scoringResult(int $id): JsonResponse
    {
        $data = $this->scoringService->calculateScoringResult($id);

        return $this->successResponse($data, 'Hasil simulasi akreditasi berhasil dihitung');
    }

    /**
     * Verifikasi bukti oleh Kaprodi/Administrator (Disetujui / Perlu Revisi).
     */
    public function verifikasiBukti(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,perlu_revisi',
        ]);

        $assessment = SelfAssessment::find($id);

        if (! $assessment) {
            return $this->errorResponse('Data penilaian mandiri tidak ditemukan', null, 404);
        }

        $assessment->update([
            'status_verifikasi_bukti' => $request->validated('status_verifikasi'),
        ]);

        return $this->successResponse($assessment, 'Status verifikasi bukti berhasil diperbarui');
    }
}