<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreVersiInstrumenRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_lembaga' => 'required|exists:lembaga_akreditasi,id',
            'nomor_versi' => 'required|string|max:255',
            'tanggal_berlaku' => 'required|date',
            'status_aktif' => 'nullable|boolean',
        ];
    }
}
