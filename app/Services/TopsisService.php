<?php

namespace App\Services;

use App\Models\Gardu;
use App\Models\Pengukuran;
use App\Models\TopsisKriteria;
use App\Models\TopsisRun;
use App\Models\TopsisRunDetail;
use App\Models\TopsisRunNormalized;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TopsisService
{
    /**
     * Run TOPSIS Calculation for a period
     */
    public function calculate($startDate, $endDate, $userId, $notes = '')
    {
        // 1. Get Active Criteria and Weights
        $kriterias = TopsisKriteria::where('aktif', true)->with('currentBobot')->get();
        if ($kriterias->isEmpty()) {
            throw new \Exception("Kriteria belum dikonfigurasi.");
        }

        // 2. Get latest measurements for each Gardu in the period
        $gardus = Gardu::all();
        $decisionMatrix = [];
        
        foreach ($gardus as $gardu) {
            $latestPengukuran = Pengukuran::where('gardu_id', $gardu->id)
                ->whereBetween('tanggal_pengukuran', [$startDate, $endDate])
                ->latest('tanggal_pengukuran')
                ->first();

            if ($latestPengukuran) {
                $matrixRow = [
                    'gardu_id' => $gardu->id,
                    'values' => []
                ];

                foreach ($kriterias as $k) {
                    $val = $this->getValueForKriteria($k, $gardu, $latestPengukuran);
                    $matrixRow['values'][$k->id] = $val;
                }
                $decisionMatrix[] = $matrixRow;
            }
        }

        if (empty($decisionMatrix)) {
            throw new \Exception("Tidak ada data pengukuran dalam periode ini.");
        }

        // 3. Normalization logic (TOPSIS)
        $pembagi = []; // untuk menyimpan nilai sqrt(sum(x^2)) per kriteria
        foreach ($kriterias as $k) {
            $allValues = array_column(array_column($decisionMatrix, 'values'), $k->id);
            if (empty($allValues)) continue;

            $sumSquare = 0;
            foreach ($allValues as $val) {
                $sumSquare += pow($val, 2);
            }
            $pembagi[$k->id] = sqrt($sumSquare);
        }

        $normalizationMatrix = [];
        $yMatrix = []; // Matriks Keputusan Ternormalisasi Terbobot (Y)

        foreach ($kriterias as $k) {
            if (!isset($pembagi[$k->id])) continue;
            
            foreach ($decisionMatrix as $rowIndex => $row) {
                $xij = $row['values'][$k->id];
                
                // Normalisasi vektor (TOPSIS)
                $rij = $pembagi[$k->id] != 0 ? ($xij / $pembagi[$k->id]) : 0;

                $weight = $k->currentBobot->bobot ?? 0;
                $yij = $rij * $weight; // Nilai Y (Terbobot)

                $normalizationMatrix[$rowIndex][$k->id] = [
                    'x' => $xij,
                    'r' => $rij,
                    'weight' => $weight,
                    'contribution' => $yij // Disimpan ke db sebagai kontribusi (nilai Y)
                ];

                $yMatrix[$k->id][$rowIndex] = $yij;
            }
        }

        // 4. Menentukan Solusi Ideal Positif (A+) dan Solusi Ideal Negatif (A-)
        $idealPositif = [];
        $idealNegatif = [];

        foreach ($kriterias as $k) {
            if (!isset($yMatrix[$k->id])) continue;

            $yValues = $yMatrix[$k->id];
            
            if ($k->tipe == 'benefit') {
                $idealPositif[$k->id] = !empty($yValues) ? max($yValues) : 0;
                $idealNegatif[$k->id] = !empty($yValues) ? min($yValues) : 0;
            } else { // cost
                $idealPositif[$k->id] = !empty($yValues) ? min($yValues) : 0;
                $idealNegatif[$k->id] = !empty($yValues) ? max($yValues) : 0;
            }
        }

        // 5. Menghitung Jarak (D+, D-) dan Nilai Preferensi (V)
        $results = [];
        foreach ($decisionMatrix as $rowIndex => $row) {
            $dPlusSum = 0;
            $dMinSum = 0;

            foreach ($kriterias as $k) {
                if (!isset($normalizationMatrix[$rowIndex][$k->id])) continue;

                $yij = $normalizationMatrix[$rowIndex][$k->id]['contribution'];
                $dPlusSum += pow($yij - ($idealPositif[$k->id] ?? 0), 2);
                $dMinSum += pow($yij - ($idealNegatif[$k->id] ?? 0), 2);
            }

            $dPlus = sqrt($dPlusSum);
            $dMin = sqrt($dMinSum);
            
            // Calculate V (Preference)
            $vi = ($dPlus + $dMin) != 0 ? ($dMin / ($dPlus + $dMin)) : 0;

            $results[] = [
                'gardu_id' => $row['gardu_id'],
                'd_plus' => $dPlus,
                'd_min' => $dMin,
                'vi' => $vi,
                'normalized' => $normalizationMatrix[$rowIndex]
            ];
        }

        // Sort by Vi descending for ranking
        usort($results, fn($a, $b) => $b['vi'] <=> $a['vi']);

        // 6. Store Calculation Results
        return DB::transaction(function() use ($results, $startDate, $endDate, $userId, $notes) {
            $run = TopsisRun::create([
                'periode_mulai' => $startDate,
                'periode_selesai' => $endDate,
                'dibuat_oleh' => $userId,
                'catatan' => $notes,
                'metode' => 'TOPSIS' // Mengubah penanda metode menjadi TOPSIS
            ]);

            foreach ($results as $index => $res) {
                TopsisRunDetail::create([
                    'topsis_run_id' => $run->id,
                    'gardu_id' => $res['gardu_id'],
                    'd_plus' => $res['d_plus'],
                    'd_min' => $res['d_min'],
                    'nilai_preferensi' => $res['vi'],
                    'ranking' => $index + 1
                ]);

                foreach ($res['normalized'] as $kId => $norm) {
                    TopsisRunNormalized::create([
                        'topsis_run_id' => $run->id,
                        'gardu_id' => $res['gardu_id'],
                        'kriteria_id' => $kId,
                        'nilai_x' => $norm['x'],
                        'nilai_r' => $norm['r'],
                        'kontribusi' => $norm['contribution']
                    ]);
                }
            }

            return $run;
        });
    }

    /**
     * Map criteria codes to actual measurement fields
     */
    protected function getValueForKriteria($kriteria, $gardu, $pengukuran)
    {
        // Default mapping based on common requirements
        switch ($kriteria->kode) {
            case 'C1': // Beban Trafo Dist (%)
                return $pengukuran->beban_trafo_persen;
            case 'C2': // Unbalance (%)
                return $pengukuran->unbalance_persen;
            case 'C3': // Tegangan F-N Rata-rata (V)
                return $pengukuran->tegangan_fn_rata2;
            case 'C4': // Cosphi Rata-rata
                return $pengukuran->cosphi_rata2;
            case 'C5': // Usia Trafo
                return $gardu->tahun_pembuatan ? (Carbon::now()->year - $gardu->tahun_pembuatan) : 0;
            default:
                // Try to find a way to dynamically map if needed
                return 0;
        }
    }
}
