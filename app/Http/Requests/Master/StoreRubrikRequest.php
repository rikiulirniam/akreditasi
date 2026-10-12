<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreRubrikRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_indikator' => 'required|integer|exists:indikator,id',
            'skor' => 'required|integer',
            'deskripsi_rubrik' => 'required|string',
        ];
    }
}
