<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreVersiInstrumenRequest;
use App\Http\Requests\Master\UpdateVersiInstrumenRequest;
use App\Models\VersiInstrumen;
use Illuminate\Http\JsonResponse;

class VersiInstrumenController extends Controller
{
    public function index(): JsonResponse
    {
        $versi = VersiInstrumen::all();
        return response()->json(['success' => true, 'data' => $versi]);
    }

    public function store(StoreVersiInstrumenRequest $request): JsonResponse
    {
        $versi = VersiInstrumen::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Versi instrumen berhasil ditambahkan', 'data' => $versi], 201);
    }

    public function show($id): JsonResponse
    {
        $versi = VersiInstrumen::findOrFail($id);
        return response()->json(['success' => true, 'data' => $versi]);
    }

    public function update(UpdateVersiInstrumenRequest $request, $id): JsonResponse
    {
        $versi = VersiInstrumen::findOrFail($id);
        $versi->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Versi instrumen berhasil diperbarui', 'data' => $versi]);
    }

    public function destroy($id): JsonResponse
    {
        $versi = VersiInstrumen::findOrFail($id);
        $versi->delete();
        return response()->json(['success' => true, 'message' => 'Versi instrumen berhasil dihapus']);
    }
}
