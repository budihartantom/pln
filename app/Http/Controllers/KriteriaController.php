<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = \App\Models\TopsisKriteria::with('currentBobot')->get();
        return view('master.kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('master.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:topsis_kriterias',
            'nama' => 'required',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1',
        ]);

        $kriteria = \App\Models\TopsisKriteria::create($request->only(['kode', 'nama', 'tipe', 'satuan', 'deskripsi']));
        $kriteria->bobots()->create(['bobot' => $request->bobot]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambah.');
    }

    public function edit(\App\Models\TopsisKriteria $kriterium)
    {
        return view('master.kriteria.edit', ['kriteria' => $kriterium]);
    }

    public function update(Request $request, \App\Models\TopsisKriteria $kriterium)
    {
        $request->validate([
            'kode' => 'required|unique:topsis_kriterias,kode,'.$kriterium->id,
            'nama' => 'required',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1',
        ]);

        $kriterium->update($request->only(['kode', 'nama', 'tipe', 'satuan', 'deskripsi']));
        $kriterium->bobots()->create(['bobot' => $request->bobot]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diubah.');
    }

    public function destroy(\App\Models\TopsisKriteria $kriterium)
    {
        $kriterium->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
