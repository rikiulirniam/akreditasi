<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateRubrikRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_indikator' => 'sometimes|required|integer|exists:indikator,id',
            'skor' => 'sometimes|required|integer',
            'deskripsi_rubrik' => 'sometimes|required|string',
        ];
    }
}
