<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreMappingTimRequest;
use App\Models\MappingTimAkreditasi;
use Illuminate\Http\JsonResponse;

class MappingTimAkreditasiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = MappingTimAkreditasi::with(['project', 'indikator'])->get();
        return response()->json(['data' => $data], 200);
    }

    public function store(StoreMappingTimRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->has('assignments')) {
            $created = [];
            foreach ($validated['assignments'] as $item) {
                $created[] = MappingTimAkreditasi::create([
                    'id_project' => $validated['id_project'],
                    'id_user' => $item['id_user'],
                    'id_indikator' => $item['id_indikator'],
                    'role' => $item['role'] ?? null,
                ]);
            }
            return response()->json(['message' => 'Batch assignments berhasil disimpan', 'data' => $created], 201);
        }

        $data = MappingTimAkreditasi::create($validated);
        return response()->json(['message' => 'Penugasan berhasil disimpan', 'data' => $data], 201);
    }

    public function destroy($id): JsonResponse
    {
        $mapping = MappingTimAkreditasi::findOrFail($id);
        $mapping->delete();

        return response()->json(['message' => 'Penugasan berhasil dihapus'], 200);
    }
}
