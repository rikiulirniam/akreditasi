<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class UpdateProjectAkreditasiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_prodi' => 'sometimes|required',
            'id_versi_instrumen' => 'sometimes|required|integer|exists:versi_instrumen,id',
            'id_jenjang' => 'sometimes|required|integer|exists:jenjang,id',
            'id_jenis_instrumen' => 'sometimes|required|integer|exists:jenis_instrumen,id',
            'nama_project' => 'sometimes|required|string|max:255',
            'tahun_target_submit' => 'sometimes|required|integer|digits:4',
            'status_project' => 'sometimes|required|string|in:Draft,On Progress,Pending,Cancel,Selesai',
            'tanggal_verifikasi_akreditasi' => 'nullable|date|required_if:status_project,Selesai',
            'nomor_sk_akreditasi' => 'nullable|string|max:255|required_if:status_project,Selesai',
        ];
    }
}
