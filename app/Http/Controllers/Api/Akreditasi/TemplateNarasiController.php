<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\TemplateNarasiRequest;
use App\Models\TemplateNarasiSubkriteria;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplateNarasiController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $templates = TemplateNarasiSubkriteria::query()
            ->with('subkriteria:id,kode_subkriteria,nama_subkriteria')
            ->when($request->filled('kategori_data'), fn ($query) => $query->where('kategori_data', $request->string('kategori_data')->toString()))
            ->when($request->has('is_active'), fn ($query) => $query->where('is_active', $request->boolean('is_active')))
            ->orderBy('kategori_data')
            ->orderBy('prioritas')
            ->get();

        return $this->successResponse($templates, 'Daftar template narasi berhasil diambil');
    }

    public function store(TemplateNarasiRequest $request): JsonResponse
    {
        $template = TemplateNarasiSubkriteria::create($request->validated());

        return $this->successResponse($template->load('subkriteria'), 'Template narasi berhasil dibuat', 201);
    }

    public function show(int $id): JsonResponse
    {
        $template = TemplateNarasiSubkriteria::with('subkriteria')->find($id);
        if (! $template) {
            return $this->errorResponse('Template narasi tidak ditemukan', null, 404);
        }

        return $this->successResponse($template, 'Detail template narasi berhasil diambil');
    }

    public function update(TemplateNarasiRequest $request, int $id): JsonResponse
    {
        $template = TemplateNarasiSubkriteria::find($id);
        if (! $template) {
            return $this->errorResponse('Template narasi tidak ditemukan', null, 404);
        }

        $template->update($request->validated());

        return $this->successResponse($template->fresh()->load('subkriteria'), 'Template narasi berhasil diperbarui');
    }

    public function destroy(int $id): JsonResponse
    {
        $template = TemplateNarasiSubkriteria::find($id);
        if (! $template) {
            return $this->errorResponse('Template narasi tidak ditemukan', null, 404);
        }

        $template->delete();

        return $this->successResponse(null, 'Template narasi berhasil dihapus');
    }
}
