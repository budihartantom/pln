<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGarduRequest extends FormRequest
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
            'id_gardu' => 'required|unique:gardus,id_gardu',
            'no_gardu' => 'required|unique:gardus,no_gardu',
            'id_up3' => 'required',
            'up3' => 'required',
            'id_ulp' => 'required',
            'ulp' => 'required',
            'penyulang' => 'required',
            'alamat' => 'nullable',
            'kode_konstruksi' => 'required',
            'status_pemilik' => 'required',
            'tahun_pembuatan' => 'required|numeric|min:1900|max:'.date('Y'),
            'merk' => 'nullable',
            'no_seri' => 'nullable',
            'kapasitas_trafo_kva' => 'required|numeric',
        ];
    }
}
