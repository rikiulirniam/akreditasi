<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateLembagaAkreditasiRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lembaga' => 'sometimes|required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }
}
