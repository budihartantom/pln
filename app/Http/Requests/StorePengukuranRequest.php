<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengukuranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gardu_id' => 'required|exists:gardus,id',
            'tanggal_pengukuran' => 'required|date',
            'jam_pengukuran' => 'required',
            'beban_trafo_kva' => 'required|numeric',
            'beban_trafo_persen' => 'required|numeric',
            'tegangan_fn_rata2' => 'required|numeric',
            'unbalance_persen' => 'required|numeric',
            'cosphi_rata2' => 'required|numeric|min:0|max:1',
            'user_input' => 'nullable|string|max:255',
        ];
    }
}
