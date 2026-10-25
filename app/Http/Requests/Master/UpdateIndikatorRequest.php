<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateIndikatorRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_subkriteria' => 'sometimes|required|integer|exists:subkriteria,id',
            'kode_indikator' => 'sometimes|required|string|max:50',
            'deskripsi_indikator' => 'sometimes|required|string',
            'bobot' => 'required|numeric|between:0,999999.99',
        ];
    }
}
