<?php

namespace App\Http\Requests\Sarpras;

use App\Http\Requests\BaseApiRequest;

class StoreDataSaranaProdiRequest extends BaseApiRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('id_sarpras_prodi') && ! $this->has('id_prasarana')) {
            $this->merge(['id_prasarana' => $this->id_sarpras_prodi]);
        }
    }

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
