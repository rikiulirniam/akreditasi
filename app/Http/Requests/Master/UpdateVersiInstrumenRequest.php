<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateVersiInstrumenRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_lembaga' => 'sometimes|required|exists:lembaga_akreditasi,id',
            'nomor_versi' => 'sometimes|required|string|max:255',
            'tanggal_berlaku' => 'sometimes|required|date',
            'status_aktif' => 'sometimes|boolean',
        ];
    }
}
