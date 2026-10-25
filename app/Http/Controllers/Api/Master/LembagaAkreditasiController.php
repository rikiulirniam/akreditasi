<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreLembagaAkreditasiRequest;
use App\Http\Requests\Master\UpdateLembagaAkreditasiRequest;
use App\Models\LembagaAkreditasi;
use Illuminate\Http\JsonResponse;

class LembagaAkreditasiController extends Controller
{
    public function index(): JsonResponse
    {
        $data = LembagaAkreditasi::all();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(StoreLembagaAkreditasiRequest $request): JsonResponse
    {
        $lembaga = LembagaAkreditasi::create($request->validated());
        return response()->json(['success' => true, 'message' => 'Lembaga akreditasi berhasil ditambahkan', 'data' => $lembaga], 201);
    }

    public function show($id): JsonResponse
    {
        $lembaga = LembagaAkreditasi::findOrFail($id);
        return response()->json(['success' => true, 'data' => $lembaga]);
    }

    public function update(UpdateLembagaAkreditasiRequest $request, $id): JsonResponse
    {
        $lembaga = LembagaAkreditasi::findOrFail($id);
        $lembaga->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Lembaga akreditasi berhasil diperbarui', 'data' => $lembaga]);
    }

    public function destroy($id): JsonResponse
    {
        $lembaga = LembagaAkreditasi::findOrFail($id);
        $lembaga->delete();
        return response()->json(['success' => true, 'message' => 'Lembaga akreditasi berhasil dihapus']);
    }
}
