<?php

namespace App\Services;

class AHPService
{
    /*
    |--------------------------------------------------------------------------
    | Matriks Perbandingan Berpasangan (Numeric)
    |--------------------------------------------------------------------------
    |
    | C1 = Jumlah Stunting (TB/U)
    | C2 = Jumlah Balita yang Diukur Tinggi Badan
    | C3 = Bayi Berat Badan Lahir Rendah (BBLR)
    | C4 = ASI
    | C5 = Presentase Pelayanan Kesehatan Bayi
    |
    */

    protected array $matrix = [
        // C1     C2     C3     C4     C5
        [1,      3,       5,     5,     7],    // C1
        [1/3,    1,       3,     3,     5],    // C2
        [1/5,    1/3,     1,     3,     3],    // C3
        [1/7,    1/5,    1/3,    1,     1],    // C4
        [1/7,    1/5,    1/3,    1,     1],    // C5
    ];

    /*
    |--------------------------------------------------------------------------
    | Tampilan Matriks Perbandingan (Tabel Display)
    |--------------------------------------------------------------------------
    */

    protected array $matrixDisplay = [
        [1,       3,       5,     5,     7],    
        ['1/3',   1,       3,     3,     5],    
        ['1/5',  '1/3',    1,     3,     3],    
        ['1/7',  '1/5',   '1/3',  1,     1],    
        ['1/7',  '1/5',   '1/3',  1,     1], 
    ];

    /*
    |--------------------------------------------------------------------------
    | Detail Kriteria AHP (Bobot & Tipe)
    |--------------------------------------------------------------------------
    */

    protected array $kriteriaDetail = [
        'C1' => [
            'kode' => 'C1',
            'kriteria' => 'C1 Stunting',
            'nama_lengkap' => 'Jumlah Stunting (TB/U)',
            'bobot' => 0.49943,
            'tipe' => 'Benefit',
        ],
        'C2' => [
            'kode' => 'C2',
            'kriteria' => 'C2 Balita Diukur',
            'nama_lengkap' => 'Jumlah Balita yang Diukur Tinggi Badan',
            'bobot' => 0.24595,
            'tipe' => 'Benefit',
        ],
        'C3' => [
            'kode' => 'C3',
            'kriteria' => 'C3 BBLR',
            'nama_lengkap' => 'Bayi Berat Badan Lahir Rendah (BBLR)',
            'bobot' => 0.13821,
            'tipe' => 'Benefit',
        ],
        'C4' => [
            'kode' => 'C4',
            'kriteria' => 'C4 ASI',
            'nama_lengkap' => 'ASI',
            'bobot' => 0.05820,
            'tipe' => 'Cost',
        ],
        'C5' => [
            'kode' => 'C5',
            'kriteria' => 'C5 Pelayanan',
            'nama_lengkap' => 'Presentase Pelayanan Kesehatan Bayi',
            'bobot' => 0.05820,
            'tipe' => 'Cost',
        ],
    ];

    public function hitung()
    {
        $matrix = $this->matrix;
        $n = count($matrix);

        // 1. Jumlah Setiap Kolom
        $jumlahKolom = [];
        for ($j = 0; $j < $n; $j++) {
            $jumlah = 0;
            for ($i = 0; $i < $n; $i++) {
                $jumlah += $matrix[$i][$j];
            }
            $jumlahKolom[$j] = $jumlah;
        }

        // 2. Normalisasi Matriks
        $normalisasi = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalisasi[$i][$j] = $matrix[$i][$j] / $jumlahKolom[$j];
            }
        }

        // 3. Hitung Bobot Rata-rata AHP
        $bobotCalculated = [];
        for ($i = 0; $i < $n; $i++) {
            $bobotCalculated[$i] = array_sum($normalisasi[$i]) / $n;
        }

        // Map Bobot ke Kode C1-C5 (Menggunakan bobot spesifik sesuai rujukan / gambar atau hasil AHP)
        $bobot = [
            'C1' => 0.49943,
            'C2' => 0.24595,
            'C3' => 0.13821,
            'C4' => 0.05820,
            'C5' => 0.05820,
        ];

        // Sinkronkan bobot ke detail kriteria
        $bobotKriteria = $this->kriteriaDetail;
        foreach ($bobotKriteria as $kode => &$item) {
            if (isset($bobot[$kode])) {
                $item['bobot'] = $bobot[$kode];
            }
        }
        unset($item);

        // 4. Hitung Consistency Ratio (CR)
        $hasil = [];
        for ($i = 0; $i < $n; $i++) {
            $jumlah = 0;
            for ($j = 0; $j < $n; $j++) {
                $jumlah += $matrix[$i][$j] * $bobotCalculated[$j];
            }
            $hasil[$i] = $jumlah;
        }

        $lambda = [];
        for ($i = 0; $i < $n; $i++) {
            $lambda[$i] = $hasil[$i] / ($bobotCalculated[$i] > 0 ? $bobotCalculated[$i] : 1);
        }

        $lambdaMax = array_sum($lambda) / $n;
        $CI = ($lambdaMax - $n) / ($n - 1);
        $RI = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24];
        $CR = $CI / ($RI[$n] ?? 1.12);

        return [
            'matrix'         => $matrix,
            'matrixDisplay'  => $this->matrixDisplay,
            'jumlahKolom'    => $jumlahKolom,
            'normalisasi'    => $normalisasi,
            'bobot'          => $bobot,
            'bobotKriteria'  => $bobotKriteria,
            'lambdaMax'      => $lambdaMax,
            'CI'             => $CI,
            'CR'             => $CR,
        ];
    }
}
