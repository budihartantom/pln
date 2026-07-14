<?php

namespace App\Http\Controllers;

use App\Models\Gardu;
use App\Models\Pengukuran;
use App\Http\Requests\StorePengukuranRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengukuranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengukuran::with('gardu');

        if ($request->filled('search')) {
            $query->whereHas('gardu', function($q) use ($request) {
                $q->where('no_gardu', 'like', '%'.$request->search.'%');
            });
        }

        $pengukurans = $query->latest('tanggal_pengukuran')->paginate(10)->withQueryString();
        return view('pengukuran.index', compact('pengukurans'));
    }

    public function create(Request $request)
    {
        $gardus = Gardu::all();
        $selectedGarduId = $request->get('gardu_id');
        return view('pengukuran.create', compact('gardus', 'selectedGarduId'));
    }

    public function store(StorePengukuranRequest $request)
    {
        DB::beginTransaction();
        try {
            $pengukuran = Pengukuran::create([
                'gardu_id' => $request->gardu_id,
                'tanggal_pengukuran' => $request->tanggal_pengukuran,
                'jam_pengukuran' => $request->jam_pengukuran,
                'beban_trafo_kva' => $request->beban_trafo_kva,
                'beban_trafo_persen' => $request->beban_trafo_persen,
                'tegangan_fn_rata2' => $request->tegangan_fn_rata2,
                'unbalance_persen' => $request->unbalance_persen,
                'cosphi_rata2' => $request->cosphi_rata2,
                'user_input' => $request->user_input,
                'created_by' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('pengukuran.index')->with('success', 'Data pengukuran berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Pengukuran $pengukuran)
    {
        $pengukuran->load('gardu');
        return view('pengukuran.show', compact('pengukuran'));
    }

    public function destroy(Pengukuran $pengukuran)
    {
        $pengukuran->delete();
        return redirect()->route('pengukuran.index')->with('success', 'Data pengukuran berhasil dihapus.');
    }
}
