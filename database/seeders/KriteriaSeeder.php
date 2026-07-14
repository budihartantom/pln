<?php

namespace Database\Seeders;

use App\Models\TopsisKriteria;
use App\Models\TopsisBobot;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = [
            [
                'kode' => 'C1',
                'nama' => 'Beban Trafo Dist (%)',
                'tipe' => 'benefit',
                'satuan' => '%',
                'bobot' => 0.30,
            ],
            [
                'kode' => 'C2',
                'nama' => 'Unbalance (%)',
                'tipe' => 'benefit',
                'satuan' => '%',
                'bobot' => 0.20,
            ],
            [
                'kode' => 'C3',
                'nama' => 'Tegangan F-N Rata-rata (V)',
                'tipe' => 'cost',
                'satuan' => 'V',
                'bobot' => 0.20,
            ],
            [
                'kode' => 'C4',
                'nama' => 'Cosphi Rata-rata',
                'tipe' => 'cost',
                'satuan' => '-',
                'bobot' => 0.15,
            ],
            [
                'kode' => 'C5',
                'nama' => 'Usia Trafo (tahun)',
                'tipe' => 'benefit',
                'satuan' => 'tahun',
                'bobot' => 0.15,
            ],
        ];

        foreach ($kriterias as $kData) {
            $kriteria = TopsisKriteria::create([
                'kode' => $kData['kode'],
                'nama' => $kData['nama'],
                'tipe' => $kData['tipe'],
                'satuan' => $kData['satuan'],
                'aktif' => true,
            ]);

            TopsisBobot::create([
                'kriteria_id' => $kriteria->id,
                'bobot' => $kData['bobot']
            ]);
        }
    }
}
