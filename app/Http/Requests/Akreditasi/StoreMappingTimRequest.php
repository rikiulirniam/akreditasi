<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreMappingTimRequest extends BaseApiRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->route('id') && ! $this->has('id_project')) {
            $this->merge(['id_project' => (int) $this->route('id')]);
        }

        if ($this->has('role') && is_string($this->role)) {
            $this->merge(['role' => strtoupper(trim($this->role))]);
        }

        if ($this->has('assignments') && is_array($this->assignments)) {
            $assignments = array_map(function ($item) {
                if (is_array($item) && isset($item['role']) && is_string($item['role'])) {
                    $item['role'] = strtoupper(trim($item['role']));
                }

                return $item;
            }, $this->assignments);

            $this->merge(['assignments' => $assignments]);
        }
    }

    public function rules(): array
    {
        return [
            // --- Mode single assignment ---
            'id_project' => 'required|integer|exists:project_akreditasi,id',
            'id_user' => 'required_without:assignments|integer',
            'id_indikator' => 'required_without:assignments|integer|exists:indikator,id',
            'role' => 'required_without:assignments|string|in:PJ,PIC',

            // --- Mode batch assignment ---
            'assignments' => 'sometimes|array|min:1',
            'assignments.*.id_user' => 'required|integer',
            'assignments.*.id_indikator' => 'required|integer|exists:indikator,id',
            'assignments.*.role' => 'required|string|in:PJ,PIC',
        ];
    }

    public function messages(): array
    {
        return [
            'role.in' => 'Role harus bernilai PJ (Penanggung Jawab) atau PIC (Pelaksana Teknis).',
            'assignments.*.role.in' => 'Setiap role pada assignments harus PJ atau PIC.',
            'assignments.*.role.required' => 'Field role wajib diisi pada setiap item assignments.',
            'assignments.min' => 'Minimal harus ada 1 item dalam assignments.',
        ];
    }
}
