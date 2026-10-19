<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreVersiInstrumenRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_lembaga' => 'required|integer|exists:lembaga_akreditasi,id',
            'nomor_versi' => 'required|string|max:50',
            'tanggal_berlaku' => 'required|date',
            'status_aktif' => 'sometimes|boolean',
        ];
    }
}
