<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreSubkriteriaRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kriteria' => 'required|exists:kriteria,id',
            'kode_subkriteria' => 'required|string|max:50',
            'nama_subkriteria' => 'required|string|max:255',
        ];
    }
}
