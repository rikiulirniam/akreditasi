<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreStandarMutuRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'kode_standar' => 'required|string|max:50',
            'nama_standar' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }
}
