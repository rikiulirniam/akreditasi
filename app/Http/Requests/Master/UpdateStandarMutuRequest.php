<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateStandarMutuRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'kode_standar' => 'sometimes|required|string|max:50',
            'nama_standar' => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }
}
