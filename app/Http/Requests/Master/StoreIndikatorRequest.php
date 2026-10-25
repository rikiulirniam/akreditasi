<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreIndikatorRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_subkriteria' => 'required|integer|exists:subkriteria,id',
            'kode_indikator' => 'required|string|max:50',
            'deskripsi_indikator' => 'required|string',
            'bobot' => 'required|numeric|between:0,999999.99',
        ];
    }
}
