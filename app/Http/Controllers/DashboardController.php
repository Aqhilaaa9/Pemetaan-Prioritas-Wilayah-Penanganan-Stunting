<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataStunting;
use App\Models\Kabupaten;
use App\Models\Puskesmas;
use App\Models\User;
use App\Services\AHPService;
use App\Services\SAWService;

class DashboardController extends Controller
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
        $tahunList = DataStunting::select('tahun')->distinct()->whereNotNull('tahun')->orderBy('tahun', 'desc')->pluck('tahun');
        $tahunSelected = $request->get('tahun');

        $queryStunting = DataStunting::query();
        if (!empty($tahunSelected)) {
            $queryStunting->where('tahun', $tahunSelected);
        }

        $jumlahBalita = (clone $queryStunting)->sum('jumlah_balita');
        $jumlahStunting = (clone $queryStunting)->sum('jumlah_stunting');
        $jumlahKabupaten = Kabupaten::count();
        $jumlahPuskesmas = Puskesmas::count();

        // 1. Data Persentase per Kabupaten dari database
        $kabupatenData = Kabupaten::with(['dataStunting' => function ($q) use ($tahunSelected) {
            if (!empty($tahunSelected)) {
                $q->where('tahun', $tahunSelected);
            }
        }])->get()->map(function ($kab) {
            $totalBalita = $kab->dataStunting->sum('jumlah_balita');
            $totalStunting = $kab->dataStunting->sum('jumlah_stunting');
            $persentase = $totalBalita > 0 ? round(($totalStunting / $totalBalita) * 100, 2) : 0;

            // Kategori warna sesuai mockup
            if ($persentase < 10) {
                $kategori = 'hijau';
                $prioritasText = 'Rendah';
            
            } elseif ($persentase <= 20) {
                $kategori = 'kuning';
                $prioritasText = 'Sedang';
            
            } else {
                $kategori = 'merah';
                $prioritasText = 'Tinggi';
            
            }

            return [
                'id'             => $kab->id,
                'nama'           => $kab->nama_kabupaten,
                'persentase'     => $persentase,
                'total_balita'   => $totalBalita,
                'total_stunting' => $totalStunting,
                'kategori'       => $kategori,
                'prioritas'      => $prioritasText,
            ];
        });

        // 2. Data Chart (Porsi Stunting berdasarkan Tingkat Prioritas)
        $stuntingTinggi = $kabupatenData->where('kategori', 'merah')->sum('total_stunting');
        $stuntingSedang = $kabupatenData->where('kategori', 'kuning')->sum('total_stunting');
        $stuntingRendah = $kabupatenData->where('kategori', 'hijau')->sum('total_stunting');
        $sumStuntingAll = $stuntingTinggi + $stuntingSedang + $stuntingRendah;

        $chartData = [
            'tinggi' => $sumStuntingAll > 0 ? round(($stuntingTinggi / $sumStuntingAll) * 100, 1) : 0,
            'sedang' => $sumStuntingAll > 0 ? round(($stuntingSedang / $sumStuntingAll) * 100, 1) : 0,
            'rendah' => $sumStuntingAll > 0 ? round(($stuntingRendah / $sumStuntingAll) * 100, 1) : 0,
        ];

        // 3. Perhitungan DSS (AHP & SAW) untuk Prioritas Utama & Top 3 Wilayah
        $allDataQuery = DataStunting::with(['kabupaten', 'puskesmas']);
        if (!empty($tahunSelected)) {
            $allDataQuery->where('tahun', $tahunSelected);
        }

        // Kelompokkan data per puskesmas agar tiap puskesmas dihitung sebagai 1 alternatif unik
        $dataStuntingAll = $allDataQuery->get()->groupBy('puskesmas_id')->map(function ($items) {
            $first = $items->first();
            $totalBalita = $items->sum('jumlah_balita');
            $totalStunting = $items->sum('jumlah_stunting');
            $totalBblr = $items->sum('jumlah_bblr');
            $avgAsi = $items->avg('persentase_asi');
            $avgPelayanan = $items->avg('persentase_pelayanan');

            return (object) [
                'id'                   => $first->puskesmas_id,
                'kabupaten_id'         => $first->kabupaten_id,
                'kabupaten'            => $first->kabupaten,
                'puskesmas'            => $first->puskesmas,
                'jumlah_balita'        => $totalBalita,
                'jumlah_stunting'      => $totalStunting,
                'jumlah_bblr'          => $totalBblr,
                'persentase_asi'       => $avgAsi,
                'persentase_pelayanan' => $avgPelayanan,
            ];
        })->values();

        $ahpHasil = $this->ahp->hitung();
        $sawHasil = $this->saw->hitung($dataStuntingAll, $ahpHasil['bobot']);
        $hasilDSS = $sawHasil['hasil'] ?? [];

        // Prioritas Utama (Ranking 1)
        $prioritasUtama = $hasilDSS[0] ?? null;

        // Top 3 Wilayah
        $top3Prioritas = array_slice($hasilDSS, 0, 3);

        return view('dashboard', compact(
            'jumlahBalita',
            'jumlahStunting',
            'jumlahKabupaten',
            'jumlahPuskesmas',
            'kabupatenData',
            'chartData',
            'prioritasUtama',
            'top3Prioritas',
            'tahunList',
            'tahunSelected'
        ));
    }
}