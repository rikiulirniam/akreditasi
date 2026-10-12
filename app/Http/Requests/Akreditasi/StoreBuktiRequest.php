<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreBuktiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_lembar_prodi' => 'required|integer|exists:lembar_prodi,id',
            'id_jenis_bukti' => 'required|integer|exists:jenis_bukti,id',
            'file' => 'required|file|max:25600', // maksimal 25 MB
            'nama_file' => 'nullable|string|max:255',
            'masa_berlaku' => 'nullable|date',
            'status_validasi' => 'nullable|string|in:Pending,Approved,Revision',
        ];
    }
}
