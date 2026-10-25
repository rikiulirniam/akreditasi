<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreLembagaAkreditasiRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lembaga' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }
}
