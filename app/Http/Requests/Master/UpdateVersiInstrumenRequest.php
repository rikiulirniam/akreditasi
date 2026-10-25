<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateVersiInstrumenRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_lembaga' => 'sometimes|required|integer|exists:lembaga_akreditasi,id',
            'nomor_versi' => 'sometimes|required|string|max:50',
            'tanggal_berlaku' => 'sometimes|required|date',
            'status_aktif' => 'sometimes|boolean',
        ];
    }
}
