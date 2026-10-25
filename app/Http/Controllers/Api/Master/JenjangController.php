<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use Illuminate\Http\JsonResponse;

class JenjangController extends Controller
{
    public function index(): JsonResponse
    {
        $jenjang = Jenjang::all();

        return response()->json([
            'success' => true,
            'data' => $jenjang,
        ]);
    }

    public function show($id): JsonResponse
    {
        $jenjang = Jenjang::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $jenjang,
        ]);
    }
}
