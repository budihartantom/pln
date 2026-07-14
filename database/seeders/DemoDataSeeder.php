<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gardus = [
            [
                'id_gardu' => '17GD001',
                'no_gardu' => 'KRG-A',
                'id_up3' => '17',
                'up3' => 'TANJUNG KARANG',
                'id_ulp' => '1701',
                'ulp' => 'WAY HALIM',
                'penyulang' => 'MERPATI',
                'alamat' => 'Jl. Ki Maja, Way Halim',
                'kode_konstruksi' => 'PORTAL',
                'status_pemilik' => 'PLN',
                'tahun_pembuatan' => 2010,
            ],
            [
                'id_gardu' => '17GD002',
                'no_gardu' => 'KRG-B',
                'id_up3' => '17',
                'up3' => 'TANJUNG KARANG',
                'id_ulp' => '1702',
                'ulp' => 'KEDATON',
                'penyulang' => 'ELANG',
                'alamat' => 'Jl. Teuku Umar, Kedaton',
                'kode_konstruksi' => 'PORTAL',
                'status_pemilik' => 'PLN',
                'tahun_pembuatan' => 2015,
            ],
            [
                'id_gardu' => '17GD003',
                'no_gardu' => 'KRG-C',
                'id_up3' => '17',
                'up3' => 'TANJUNG KARANG',
                'id_ulp' => '1701',
                'ulp' => 'WAY HALIM',
                'penyulang' => 'MERPATI',
                'alamat' => 'Jl. Sultan Agung',
                'kode_konstruksi' => 'PORTAL',
                'status_pemilik' => 'PLN',
                'tahun_pembuatan' => 2005,
            ],
        ];

        foreach ($gardus as $gData) {
            $gardu = \App\Models\Gardu::create($gData);
            
            // Create a measurement for each gardu
            $pengukuran = \App\Models\Pengukuran::create([
                'gardu_id' => $gardu->id,
                'tanggal_pengukuran' => now()->subDays(rand(1, 10)),
                'jam_pengukuran' => '10:00',
                'kapasitas_trafo_kva' => 100,
                'beban_trafo_dist_kva' => rand(60, 95),
                'beban_trafo_dist_persen' => rand(60, 95),
                'tegangan_fn_rata2' => rand(210, 240),
                'unbalance_persen' => rand(5, 25),
                'cosphi_rata2' => 0.85,
                'created_by' => 1,
                'user_input' => 'System Demo'
            ]);

            // Simple Jurusan & JTR for demo
            foreach (['A', 'B'] as $jur) {
                foreach (['R', 'S', 'T'] as $fasa) {
                    $pengukuran->jurusanBebans()->create([
                        'jurusan' => $jur,
                        'fasa' => $fasa,
                        'nilai_ampere' => rand(20, 50)
                    ]);
                }
                $pengukuran->teganganUjungJtrs()->create([
                    'jurusan' => $jur,
                    'tegangan_volt' => rand(200, 220)
                ]);
            }
        }
    }
}
