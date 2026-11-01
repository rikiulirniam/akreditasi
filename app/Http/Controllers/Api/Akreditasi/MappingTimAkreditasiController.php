<?php

namespace App\Http\Controllers\Api\Akreditasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Akreditasi\StoreMappingTimRequest;
use App\Models\MappingTimAkreditasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MappingTimAkreditasiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = MappingTimAkreditasi::with(['project', 'indikator']);

        if ($request->filled('id_project')) {
            $query->where('id_project', $request->query('id_project'));
        } elseif ($request->filled('project_id')) {
            $query->where('id_project', $request->query('project_id'));
        }

        if ($request->filled('role')) {
            $query->where('role', strtoupper($request->query('role')));
        }

        $data = $query->get();

        return response()->json(['data' => $data], 200);
    }

    public function store(StoreMappingTimRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->has('assignments')) {
            $created = [];
            foreach ($validated['assignments'] as $item) {
                $role = strtoupper($item['role'] ?? 'PIC');
                $created[] = MappingTimAkreditasi::updateOrCreate(
                    [
                        'id_project' => $validated['id_project'],
                        'id_indikator' => $item['id_indikator'],
                        'role' => $role,
                    ],
                    [
                        'id_user' => $item['id_user'],
                    ]
                );
            }

            return response()->json(['message' => 'Batch assignments berhasil disimpan', 'data' => $created], 201);
        }

        $role = strtoupper($validated['role'] ?? 'PIC');
        $data = MappingTimAkreditasi::updateOrCreate(
            [
                'id_project' => $validated['id_project'],
                'id_indikator' => $validated['id_indikator'],
                'role' => $role,
            ],
            [
                'id_user' => $validated['id_user'],
            ]
        );

        return response()->json(['message' => 'Penugasan berhasil disimpan', 'data' => $data], 201);
    }

    public function destroy($id): JsonResponse
    {
        $mapping = MappingTimAkreditasi::findOrFail($id);
        $mapping->delete();

        return response()->json(['message' => 'Penugasan berhasil dihapus'], 200);
    }
}
