<?php

namespace App\Http\Requests\Sarpras;

use App\Http\Requests\BaseApiRequest;

class StoreDataSaranaProdiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_prasarana' => 'required|integer|exists:data_sarpras_prodi,id',
            'jumlah_unit' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ];
    }
}
