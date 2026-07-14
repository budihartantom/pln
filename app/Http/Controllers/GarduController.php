<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GarduController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Gardu::query();

        // Dynamic Filtering
        $query->when($request->search, function($q, $search) {
            $q->where(function($sq) use ($search) {
                $sq->where('no_gardu', 'like', "%$search%")
                   ->orWhere('id_gardu', 'like', "%$search%")
                   ->orWhere('alamat', 'like', "%$search%");
            });
        });

        $query->when($request->ulp, fn($q, $ulp) => $q->where('ulp', $ulp));
        $query->when($request->penyulang, fn($q, $p) => $q->where('penyulang', $p));
        $query->when($request->status, fn($q, $s) => $q->where('status_pemilik', $s));

        // Get dropdown lists from DB
        $ulps = \App\Models\Gardu::select('ulp')->whereNotNull('ulp')->distinct()->orderBy('ulp')->pluck('ulp');
        $penyulangs = \App\Models\Gardu::select('penyulang')->whereNotNull('penyulang')->distinct()->orderBy('penyulang')->pluck('penyulang');
        $statusList = ['1 - PLN', '3 - NON PLN'];

        $gardus = $query->latest()->paginate(10)->withQueryString();
        
        return view('gardu.index', compact('gardus', 'ulps', 'penyulangs', 'statusList'));
    }

    public function create()
    {
        return view('gardu.create');
    }

    public function store(\App\Http\Requests\StoreGarduRequest $request)
    {
        \App\Models\Gardu::create($request->validated());
        return redirect()->route('gardu.index')->with('success', 'Data Gardu berhasil disimpan.');
    }

    public function show(\App\Models\Gardu $gardu)
    {
        $gardu->load(['pengukurans' => fn($q) => $q->latest()->take(5)]);
        return view('gardu.show', compact('gardu'));
    }

    public function edit(\App\Models\Gardu $gardu)
    {
        return view('gardu.edit', compact('gardu'));
    }

    public function update(\App\Http\Requests\UpdateGarduRequest $request, \App\Models\Gardu $gardu)
    {
        $gardu->update($request->validated());
        return redirect()->route('gardu.index')->with('success', 'Data Gardu berhasil diperbarui.');
    }

    public function destroy(\App\Models\Gardu $gardu)
    {
        $gardu->delete();
        return redirect()->route('gardu.index')->with('success', 'Data Gardu berhasil dihapus.');
    }
}
