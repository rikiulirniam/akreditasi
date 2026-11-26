<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreNarasiSubkriteriaRequest extends BaseApiRequest
{
    /**
     * Permintaan diverifikasi oleh middleware role; payload tetap wajib divalidasi di sini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Menyiapkan dan menyinkronkan field narasi_disunting dengan narasi untuk backward compatibility.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('narasi_disunting') && ! $this->has('narasi')) {
            $this->merge(['narasi' => $this->input('narasi_disunting')]);
        } elseif ($this->has('narasi') && ! $this->has('narasi_disunting')) {
            $this->merge(['narasi_disunting' => $this->input('narasi')]);
        }
    }

    /**
     * Menentukan aturan validasi untuk narasi_disunting (minimal 20 karakter) dan catatan_revisi opsional.
     */
    public function rules(): array
    {
        return [
            'narasi_disunting' => ['required', 'string', 'min:20', 'max:10000'],
            'narasi' => ['required', 'string', 'min:10', 'max:10000'],
            'catatan_revisi' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Pesan validasi kustom.
     */
    public function messages(): array
    {
        return [
            'narasi_disunting.required' => 'Teks narasi hasil kustomisasi wajib diisi.',
            'narasi_disunting.min' => 'Teks narasi minimal berisi 20 karakter.',
            'narasi.required' => 'Field narasi wajib diisi.',
        ];
    }
}
