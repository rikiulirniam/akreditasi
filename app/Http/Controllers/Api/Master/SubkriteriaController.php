<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreSubkriteriaRequest;
use App\Http\Requests\Master\UpdateSubkriteriaRequest;
use App\Models\Subkriteria;
use Illuminate\Http\JsonResponse;

class SubkriteriaController extends Controller
{
    public function index(): JsonResponse
    {
        $subkriteria = Subkriteria::with('kriteria')->get();
        return response()->json(['success' => true, 'data' => $subkriteria]);
    }

    public function store(StoreSubkriteriaRequest $request): JsonResponse
    {
        $subkriteria = Subkriteria::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Subkriteria berhasil ditambahkan', 'data' => $subkriteria], 201);
    }

    public function show($id): JsonResponse
    {
        $subkriteria = Subkriteria::with('kriteria')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $subkriteria]);
    }

    public function update(UpdateSubkriteriaRequest $request, $id): JsonResponse
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $subkriteria->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Subkriteria berhasil diperbarui', 'data' => $subkriteria]);
    }

    public function destroy($id): JsonResponse
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $subkriteria->delete();
        return response()->json(['success' => true, 'message' => 'Subkriteria berhasil dihapus']);
    }
}
