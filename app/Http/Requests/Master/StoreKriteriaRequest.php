<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreKriteriaRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_instrumen' => 'required|uuid|exists:instrumen,id',
            'kode_kriteria' => 'required|string|max:50',
            'nama_kriteria' => 'required|string|max:255',
        ];
    }
}
