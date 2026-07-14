<?php

namespace App\Http\Controllers;

use App\Models\TopsisRun;
use Illuminate\Http\Request;

class RankingTopsisController extends Controller
{
    public function index()
    {
        // Get the latest topsis run for ranking
        $latestRun = TopsisRun::with(['details.gardu', 'normalizedDetails.kriteria', 'creator'])->latest()->first();
        return view('topsis.ranking.index', compact('latestRun'));
    }
}
