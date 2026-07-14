<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopsisController extends Controller
{
    protected $topsisService;

    public function __construct(\App\Services\TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    public function index()
    {
        return view('topsis.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        ]);

        try {
            $run = $this->topsisService->calculate(
                $request->periode_mulai,
                $request->periode_selesai,
                auth()->id(),
                $request->catatan ?? ''
            );

            return redirect()->route('topsis.show', $run->id)->with('success', 'Perhitungan TOPSIS selesai.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function history()
    {
        $runs = \App\Models\TopsisRun::with('creator')->latest()->paginate(10);
        return view('topsis.history', compact('runs'));
    }

    public function show(\App\Models\TopsisRun $run)
    {
        $run->load(['details.gardu', 'normalizedDetails.kriteria', 'creator']);
        return view('topsis.show', compact('run'));
    }
}
