<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\UpdateJenisInstrumenRequest;
use App\Models\JenisInstrumen;
use Illuminate\Http\JsonResponse;

class JenisInstrumenController extends Controller
{
    public function index(): JsonResponse
    {
        $data = JenisInstrumen::all();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function show($id): JsonResponse
    {
        $data = JenisInstrumen::findOrFail($id);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(UpdateJenisInstrumenRequest $request, $id): JsonResponse
    {
        $jenisInstrumen = JenisInstrumen::findOrFail($id);
        $jenisInstrumen->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Jenis instrumen berhasil diperbarui',
            'data' => $jenisInstrumen,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $jenisInstrumen = JenisInstrumen::findOrFail($id);
        $jenisInstrumen->delete();

        return response()->json(['success' => true, 'message' => 'Jenis instrumen berhasil dihapus']);
    }
}
