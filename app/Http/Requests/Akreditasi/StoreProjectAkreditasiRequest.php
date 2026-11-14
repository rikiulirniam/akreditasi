<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreProjectAkreditasiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_prodi' => 'required|integer',
            'id_versi_instrumen' => 'required|integer|exists:versi_instrumen,id',
            'id_jenjang' => 'required|integer|exists:jenjang,id',
            'id_jenis_instrumen' => 'required|integer|exists:jenis_instrumen,id',
            'nama_project' => 'required|string|max:255',
            'tahun_target_submit' => 'required|integer|digits:4',
            'status_project' => 'nullable|string|in:Draft,On Progress,Pending,Cancel,Selesai',
            'tanggal_verifikasi_akreditasi' => 'nullable|date',
            'nomor_sk_akreditasi' => 'nullable|string|max:255',
        ];
    }
}
