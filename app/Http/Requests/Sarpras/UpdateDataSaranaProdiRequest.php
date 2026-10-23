<?php

namespace App\Http\Requests\Sarpras;

use App\Http\Requests\BaseApiRequest;

class UpdateDataSaranaProdiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_prasarana' => 'sometimes|required|integer|exists:data_sarpras_prodi,id',
            'jumlah_unit' => 'sometimes|required|integer|min:0',
            'kondisi' => 'sometimes|required|string|max:100',
            'keterangan' => 'nullable|string',
        ];
    }
}
