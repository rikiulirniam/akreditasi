<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateKriteriaRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_versi_instrumen' => 'sometimes|required|integer|exists:versi_instrumen,id',
            'kode_kriteria' => 'sometimes|required|string|max:50',
            'nama_kriteria' => 'sometimes|required|string|max:255',
        ];
    }
}
