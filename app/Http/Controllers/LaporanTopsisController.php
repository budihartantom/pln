<?php

namespace App\Http\Controllers;

use App\Models\TopsisRun;
use Illuminate\Http\Request;

class LaporanTopsisController extends Controller
{
    public function index(Request $request)
    {
        $query = TopsisRun::with('creator')->latest();
        
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $runs = $query->paginate(15);
        return view('topsis.laporan.index', compact('runs'));
    }
}
