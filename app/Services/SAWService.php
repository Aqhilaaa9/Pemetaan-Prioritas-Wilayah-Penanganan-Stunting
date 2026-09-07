<?php

namespace App\Services;

class SAWService
{
    protected array $kriteria = [
        'C1' => 'benefit',    // Jumlah Stunting (TB/U)
        'C2' => 'benefit', // Jumlah Balita yang Diukur
        'C3' => 'benefit',    // Bayi BBLR
        'C4' => 'cost', // ASI
        'C5' => 'cost', // Pelayanan
    ];

    public function hitung($data, $bobot)
    {
        if ($data->isEmpty()) {
            return [
                'alternatif'  => [],
                'max'         => [],
                'min'         => [],
                'normalisasi' => [],
                'hasil'       => [],
            ];
        }

        // 1. Data Alternatif
        $alternatif = [];
        foreach ($data as $item) {
            $stuntingPersen = ($item->jumlah_balita > 0)
                ? ($item->jumlah_stunting / $item->jumlah_balita) * 100
                : 0;

            $alternatif[] = [
                'id'                   => $item->id,
                'kabupaten_id'         => $item->kabupaten_id,
                'kabupaten'            => $item->kabupaten->nama_kabupaten ?? '-',
                'puskesmas'            => $item->puskesmas->nama_puskesmas ?? '-',
                'jumlah_balita'        => (int) $item->jumlah_balita,
                'jumlah_stunting'      => (int) $item->jumlah_stunting,
                'stunting_persen'      => (float) $stuntingPersen,
                'jumlah_bblr'          => (float) $item->jumlah_bblr,
                'persentase_asi'       => (float) $item->persentase_asi,
                'persentase_pelayanan' => (float) $item->persentase_pelayanan,
                'C1'                   => (float) $item->jumlah_stunting,
                'C2'                   => (float) $item->jumlah_balita,
                'C3'                   => (float) $item->jumlah_bblr,
                'C4'                   => (float) $item->persentase_asi,
                'C5'                   => (float) $item->persentase_pelayanan,
            ];
        }

        // 2. Cari Nilai MAX & MIN untuk Setiap Kriteria
        $nilaiMax = [];
        $nilaiMin = [];

        foreach ($this->kriteria as $kode => $jenis) {
            $nilaiArr = array_column($alternatif, $kode);
            $nilaiMax[$kode] = count($nilaiArr) > 0 ? max($nilaiArr) : 0;
            $nilaiMin[$kode] = count($nilaiArr) > 0 ? min($nilaiArr) : 0;
        }

        // 3. Normalisasi Matriks SAW
        $normalisasi = [];
        foreach ($alternatif as $index => $item) {
            $normalisasi[$index] = [
                'id'        => $item['id'],
                'kabupaten' => $item['kabupaten'],
                'puskesmas' => $item['puskesmas'],
            ];

            foreach ($this->kriteria as $kode => $jenis) {
                $nilai = $item[$kode];

                if ($jenis === 'benefit') {
                    $hasilNorm = ($nilaiMax[$kode] > 0)
                        ? ($nilai / $nilaiMax[$kode])
                        : 0;
                } else {
                    // COST
                    $hasilNorm = ($nilai > 0)
                        ? ($nilaiMin[$kode] / $nilai)
                        : 0;
                }

                $normalisasi[$index][$kode] = round($hasilNorm, 2);
            }
        }

        // 4. Hitung Nilai DSS (Preferensi SAW)
        $hasil = [];
        foreach ($normalisasi as $index => $item) {
            $nilaiDss = 0;

            foreach ($this->kriteria as $kode => $jenis) {
                $w = $bobot[$kode] ?? 0;
                $r = $item[$kode] ?? 0;
                $nilaiDss += ($w * $r);
            }

            $hasil[] = [
                'id'              => $item['id'],
                'kabupaten'       => $item['kabupaten'],
                'puskesmas'       => $item['puskesmas'],
                'stunting_persen' => $alternatif[$index]['stunting_persen'] ?? 0,
                'C1'              => $item['C1'],
                'C2'              => $item['C2'],
                'C3'              => $item['C3'],
                'C4'              => $item['C4'],
                'C5'              => $item['C5'],
                'nilai_dss'       => round($nilaiDss, 2),
            ];
        }

        // 5. Urutkan berdasarkan Nilai DSS Tertinggi (Prioritas Utama)
        usort($hasil, function ($a, $b) {
            return $b['nilai_dss'] <=> $a['nilai_dss'];
        });

        // 6. Tentukan Ranking & Prioritas
        $totalItems = count($hasil);
        foreach ($hasil as $index => &$item) {
            $item['ranking'] = $index + 1;

            if ($item['nilai_dss'] >= 0.70) {
                $item['prioritas'] = 'Tinggi';
            } elseif ($item['nilai_dss'] >= 0.40) {
                $item['prioritas'] = 'Sedang';
            } else {
                $item['prioritas'] = 'Rendah';
            }
            
        }
        unset($item);

        return [
            'alternatif'  => $alternatif,
            'max'         => $nilaiMax,
            'min'         => $nilaiMin,
            'normalisasi' => $normalisasi,
            'hasil'       => $hasil,
        ];
    }

    public function getKriteria(): array
    {
        return $this->kriteria;
    }
}
