<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataStunting;
use App\Models\Kabupaten;
use App\Services\AHPService;
use App\Services\SAWService;

class HasilDssController extends Controller
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

    /*
    |--------------------------------------------------------------------------
    | ANALISIS DSS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // Ambil semua kabupaten
        $kabupaten = Kabupaten::orderBy('nama_kabupaten')->get();

        // Ambil daftar tahun dari data stunting
        $tahunList = DataStunting::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $tahunSelected = $request->get('tahun');

        // Ambil data stunting
        $query = DataStunting::with([
            'kabupaten',
            'puskesmas'
        ]);

        // Filter Kabupaten
        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_id', $request->kabupaten);
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Jalankan query
        $data = $query->get();

        /* HITUNG AHP & SAW */

        $ahp = $this->ahp->hitung();
        $hasilSaw = $this->saw->hitung($data, $ahp['bobot']);

        $normalisasiSaw = $hasilSaw['normalisasi'] ?? [];
        $hasil = $hasilSaw['hasil'] ?? [];

        /* HITUNG SUMMARY DATA AWAL (Tabel 1 Footer) */

        $totalBalita = $data->sum('jumlah_balita');
        $totalStunting = $data->sum('jumlah_stunting');
        $avgStuntingPersen = $totalBalita > 0 ? round(($totalStunting / $totalBalita) * 100, 1) : 0;
        $avgBblrPersen = $data->count() > 0 ? round($data->avg('jumlah_bblr'), 1) : 0;
        $avgAsiPersen = $data->count() > 0 ? round($data->avg('persentase_asi'), 1) : 0;
        $avgPelayananPersen = $data->count() > 0 ? round($data->avg('persentase_pelayanan'), 1) : 0;

        $summary = [
            'total_balita'          => $totalBalita,
            'avg_stunting_persen'   => $avgStuntingPersen,
            'avg_bblr_persen'       => $avgBblrPersen,
            'avg_asi_persen'        => $avgAsiPersen,
            'avg_pelayanan_persen'  => $avgPelayananPersen,
        ];

        return view('analisisDSS', [
            'kabupaten'      => $kabupaten,
            'kabupatenId'    => $request->kabupaten,
            'tahunList'      => $tahunList,
            'tahunSelected'  => $tahunSelected,
            'data'           => $data,
            'ahp'            => $ahp,
            'normalisasiSaw' => $normalisasiSaw,
            'hasil'          => $hasil,
            'summary'        => $summary,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PRIORITAS PENANGANAN
    |--------------------------------------------------------------------------
    */

    public function prioritas(Request $request)
    {
        // Ambil semua kabupaten
        $kabupaten = Kabupaten::orderBy('nama_kabupaten')->get();

        // Ambil daftar tahun dari data stunting
        $tahunList = DataStunting::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $tahunSelected = $request->get('tahun');

        // Ambil data stunting
        $query = DataStunting::with([
            'kabupaten',
            'puskesmas'
        ]);

        // Filter Kabupaten
        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_id', $request->kabupaten);
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Ambil data
        $data = $query->get();

        /* HITUNG AHP & SAW */

        $ahp = $this->ahp->hitung();
        $hasilSaw = $this->saw->hitung($data, $ahp['bobot']);

        $hasil = $hasilSaw['hasil'] ?? [];

        return view('prioritas', [
            'kabupaten'     => $kabupaten,
            'kabupatenId'   => $request->kabupaten,
            'tahunList'     => $tahunList,
            'tahunSelected' => $tahunSelected,
            'data'          => $data,
            'hasil'         => $hasil,
        ]);
    }
}