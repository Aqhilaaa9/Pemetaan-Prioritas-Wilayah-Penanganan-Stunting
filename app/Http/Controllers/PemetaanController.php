<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataStunting;
use App\Models\Kabupaten;
use App\Services\AHPService;
use App\Services\SAWService;

class PemetaanController extends Controller
{
    protected $ahp;
    protected $saw;

    public function __construct(
        AHPService $ahp,
        SAWService $saw
    ) {
        $this->ahp = $ahp;
        $this->saw = $saw;
    }

    public function index(Request $request)
    {
        // 1. Tahun List & Selected
        $tahunList = DataStunting::select('tahun')
            ->whereNotNull('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $tahunSelected = $request->get('tahun');

        // 2. Data Kabupaten
        $kabupaten = Kabupaten::all();

        // 3. Data Stunting Query
        $query = DataStunting::with([
            'kabupaten',
            'puskesmas'
        ]);

        if ($tahunSelected) {
            $query->where('tahun', $tahunSelected);
        }

        $dataStunting = $query->get();

        // 4. Hitung DSS (AHP & SAW) seperti pada Fitur Prioritas
        $ahpHasil = $this->ahp->hitung();
        $sawHasil = $this->saw->hitung($dataStunting, $ahpHasil['bobot']);
        $hasilDSS = collect($sawHasil['hasil'] ?? []);

        // 5. Aggregate Data per Kabupaten
        $dataPeta = $kabupaten->map(function ($kab) use ($dataStunting, $hasilDSS) {
            $dataKabupaten = $dataStunting->where('kabupaten_id', $kab->id);

            // Data dari Fitur Data Stunting
            $jumlahBalita = $dataKabupaten->sum('jumlah_balita');
            $jumlahStunting = $dataKabupaten->sum('jumlah_stunting');
            $jumlahBblr = $dataKabupaten->sum('jumlah_bblr');

            $avgAsi = $dataKabupaten->count() > 0
                ? round($dataKabupaten->avg('persentase_asi'), 2)
                : 0;

            $avgPelayanan = $dataKabupaten->count() > 0
                ? round($dataKabupaten->avg('persentase_pelayanan'), 1)
                : 0;

            $persentaseStunting = $jumlahBalita > 0
                ? round(($jumlahStunting / $jumlahBalita) * 100, 2)
                : 0;

            // Data dari Fitur Prioritas Penanganan (Nilai DSS & Status Prioritas)
            $dssKab = $hasilDSS->filter(function ($item) use ($kab) {
                return isset($item['kabupaten']) &&
                    strtolower(trim($item['kabupaten'])) === strtolower(trim($kab->nama_kabupaten));
            });

            if ($dssKab->count() > 0) {
                $nilaiDss = round($dssKab->avg('nilai_dss'), 2);
                $ranking = $dssKab->min('ranking');
                $statusPrioritas = $dssKab->first()['prioritas'] ?? 'Rendah';
            } else {
                $nilaiDss = 0;
                $ranking = '-';
                if ($persentaseStunting >= 15) {
                    $statusPrioritas = 'Tinggi';
                } elseif ($persentaseStunting >= 6) {
                    $statusPrioritas = 'Sedang';
                } else {
                    $statusPrioritas = 'Rendah';
                }
            }

            // Warna Peta disesuaikan dengan Chart pada Dashboard:
            // High (Tinggi) => Merah (#ff3131)
            // Medium (Sedang) => Kuning (#fff000)
            // Low (Rendah) => Hijau (#b7f57a)
            if ($persentaseStunting < 10) {
                $warna = '#b7f57a'; // Hijau - Rendah
                $kategori = 'Rendah';
            } elseif ($persentaseStunting <= 20) {
                $warna = '#fff000'; // Kuning - Sedang
                $kategori = 'Sedang';
            } else {
                $warna = '#ff3131'; // Merah - Tinggi
                $kategori = 'Tinggi';
            }

            return [
                'id'                   => $kab->id,
                'nama'                 => $kab->nama_kabupaten,
                'jumlah_balita'        => $jumlahBalita,
                'jumlah_stunting'      => $jumlahStunting,
                'jumlah_bblr'          => $jumlahBblr,
                'persentase_asi'       => $avgAsi,
                'persentase_pelayanan' => $avgPelayanan,
                'persentase'           => $persentaseStunting,
                'nilai_dss'            => $nilaiDss,
                'ranking'              => $ranking,
                'status'               => $statusPrioritas,
                'kategori'             => $kategori,
                'warna'                => $warna,
                'latitude'             => $kab->latitude ?? null,
                'longitude'            => $kab->longitude ?? null,
            ];
        })->values();

        // 6. Data Titik Lokasi Puskesmas (berdasarkan data stunting yang dimasukkan)
        $dataPuskesmas = $dataStunting->groupBy('puskesmas_id')->map(function ($items) use ($hasilDSS) {
            $first = $items->first();
            $puskesmas = $first->puskesmas;
            $kabupaten = $first->kabupaten;

            $totalBalita = $items->sum('jumlah_balita');
            $totalStunting = $items->sum('jumlah_stunting');
            $totalBblr = $items->sum('jumlah_bblr');
            $avgAsi = $items->count() > 0 ? round($items->avg('persentase_asi'), 1) : 0;
            $avgPelayanan = $items->count() > 0 ? round($items->avg('persentase_pelayanan'), 1) : 0;

            $persentase = $totalBalita > 0 ? round(($totalStunting / $totalBalita) * 100, 1) : 0;

            // Kategori warna
            if ($persentase < 10) {
                $warna = '#54c414'; // Hijau - Rendah
                $kategori = 'Rendah';
            } elseif ($persentase <= 20) {
                $warna = '#fff000'; // Kuning - Sedang
                $kategori = 'Sedang';
            } else {
                $warna = '#ff3131'; // Merah - Tinggi
                $kategori = 'Tinggi';
            }

            // Cek data DSS untuk puskesmas ini
            $dssPkm = $hasilDSS->first(function ($item) use ($puskesmas) {
                return isset($item['puskesmas']) &&
                    strtolower(trim($item['puskesmas'])) === strtolower(trim($puskesmas->nama_puskesmas ?? ''));
            });

            $nilaiDss = $dssPkm['nilai_dss'] ?? null;
            $ranking = $dssPkm['ranking'] ?? '-';
            $statusPrioritas = $dssPkm['prioritas'] ?? $kategori;

            $lat = $puskesmas->latitude ?? ($kabupaten->latitude ?? -8.6);
            $lng = $puskesmas->longitude ?? ($kabupaten->longitude ?? 116.3);

            return [
                'id'                   => $puskesmas->id ?? $first->id,
                'nama'                 => $puskesmas->nama_puskesmas ?? 'Puskesmas',
                'kabupaten'            => $kabupaten->nama_kabupaten ?? '-',
                'kabupaten_id'         => $kabupaten->id ?? null,
                'jumlah_balita'        => $totalBalita,
                'jumlah_stunting'      => $totalStunting,
                'jumlah_bblr'          => $totalBblr,
                'persentase_asi'       => $avgAsi,
                'persentase_pelayanan' => $avgPelayanan,
                'persentase'           => $persentase,
                'nilai_dss'            => $nilaiDss ? round($nilaiDss, 2) : '-',
                'ranking'              => $ranking,
                'status'               => $statusPrioritas,
                'kategori'             => $kategori,
                'warna'                => $warna,
                'latitude'             => (float)$lat,
                'longitude'            => (float)$lng,
            ];
        })->values();

        return view('pemetaan', [
            'dataPeta'       => $dataPeta,
            'dataPuskesmas'  => $dataPuskesmas,
            'tahunList'      => $tahunList,
            'tahunSelected'  => $tahunSelected,
        ]);
    }
}