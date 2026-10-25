<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreMappingTimRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'required|integer|exists:project_akreditasi,id',
            'id_user' => 'required_without:assignments',
            'id_indikator' => 'required_without:assignments|integer|exists:indikator,id',
            'role' => 'nullable|string|in:ADMINISTRATOR,REVIEWER,DOSEN,KAPRODI',

            'assignments' => 'sometimes|array',
            'assignments.*.id_user' => 'required_with:assignments',
            'assignments.*.id_indikator' => 'required_with:assignments|integer|exists:indikator,id',
            'assignments.*.role' => 'nullable|string|in:ADMINISTRATOR,REVIEWER,DOSEN,KAPRODI',
        ];
    }
}
