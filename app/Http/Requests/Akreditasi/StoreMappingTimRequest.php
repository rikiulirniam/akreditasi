<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;
use App\Models\Indikator;
use Illuminate\Validation\Validator;

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
            'assignments.*.role.in' => 'Field role harus bernilai PJ atau PIC.',
            'assignments.*.role.required' => 'Field role wajib diisi pada setiap item assignments.',
            'assignments.min' => 'Minimal harus ada 1 item dalam assignments.',
        ];
    }

    /**
     * Tolak indikator yang berasal dari Kriteria Statis / Non-Handle (Kriteria 5).
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $staticCodes = ['K5', 'C.5', '5'];
            $indikatorIds = [];

            if ($this->has('assignments') && is_array($this->assignments)) {
                foreach ($this->assignments as $index => $item) {
                    if (isset($item['id_indikator'])) {
                        $indikatorIds[$index] = (int) $item['id_indikator'];
                    }
                }
            } elseif ($this->filled('id_indikator')) {
                $indikatorIds['single'] = (int) $this->input('id_indikator');
            }

            if (empty($indikatorIds)) {
                return;
            }

            $blockedIds = Indikator::whereIn('id', array_values($indikatorIds))
                ->whereHas('subkriteria.kriteria', function ($q) use ($staticCodes) {
                    $q->whereIn('kode_kriteria', $staticCodes);
                })
                ->pluck('id')
                ->all();

            foreach ($indikatorIds as $key => $idIndikator) {
                if (in_array($idIndikator, $blockedIds, true)) {
                    $field = $key === 'single' ? 'id_indikator' : "assignments.{$key}.id_indikator";
                    $validator->errors()->add(
                        $field,
                        'Indikator dari Kriteria Statis / Non-Handle (Kriteria 5) tidak dapat ditugaskan.'
                    );
                }
            }
        });
    }
}
