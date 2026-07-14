<?php

namespace App\Http\Controllers;

use App\Models\Gardu;
use App\Models\Pengukuran;
use App\Models\TopsisRun;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_gardu' => Gardu::count(),
            'total_pengukuran' => Pengukuran::count(),
            'last_topsis_run' => TopsisRun::latest()->first(),
            'recent_runs' => TopsisRun::with('creator')->latest()->take(5)->get(),
        ];

        // Basic alerts for overloads
        $overloaded = Pengukuran::where('beban_trafo_persen', '>', 80)
            ->with('gardu')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'overloaded'));
    }
}
