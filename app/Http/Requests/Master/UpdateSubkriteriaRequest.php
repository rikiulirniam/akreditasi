<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateSubkriteriaRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kriteria' => 'sometimes|required|exists:kriteria,id',
            'kode_subkriteria' => 'sometimes|required|string|max:50',
            'nama_subkriteria' => 'sometimes|required|string|max:255',
        ];
    }
}
