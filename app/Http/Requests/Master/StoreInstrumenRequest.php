<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreInstrumenRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_versi_instrumen' => 'required|integer|exists:versi_instrumen,id',
            'id_jenjang' => 'required|integer|exists:jenjang,id',
            'id_jenis_instrumen' => 'required|integer|exists:jenis_instrumen,id',
        ];
    }
}
