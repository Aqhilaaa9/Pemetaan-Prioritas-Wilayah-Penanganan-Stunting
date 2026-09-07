<?php

namespace App\Http\Controllers;

use App\Models\DataStunting;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Models\Puskesmas;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class DataStuntingController extends Controller
{
    public function index(Request $request )
    {
        $query = DataStunting::with(['kabupaten','puskesmas']);
        if($request->filled('kabupaten')){
            $query->where('kabupaten_id', $request->kabupaten);
        }
        if($request->filled('bulan')){
            $query->where('bulan', $request->bulan);
        }
        if($request->filled('tahun')){
            $query->where('tahun', $request->tahun);
        }

        $data = $query->orderBy('tahun', 'desc')
                      ->orderBy('bulan', 'desc')
                      ->orderBy('tanggal', 'desc')
                      ->orderBy('id', 'desc')
                      ->get();
        $kabupaten = Kabupaten::orderBy('nama_kabupaten')->get();
        
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        
        $tahun = DataStunting::select('tahun')
                    ->distinct()
                    ->orderByDesc('tahun')
                    ->pluck('tahun');

        /* Hitung summary/total data awal stunting untuk footer tabel */
        $totalBalita = $data->sum('jumlah_balita');
        $totalStunting = $data->sum('jumlah_stunting');
        $avgStuntingPersen = $totalBalita > 0 ? round(($totalStunting / $totalBalita) * 100, 1) : 0;
        $avgBblr = $data->count() > 0 ? round($data->avg('jumlah_bblr'), 1) : 0;
        $avgAsi = $data->count() > 0 ? round($data->avg('persentase_asi'), 1) : 0;
        $avgPelayanan = $data->count() > 0 ? round($data->avg('persentase_pelayanan'), 1) : 0;

        $summary = [
            'total_balita'         => $totalBalita,
            'total_stunting'       => $totalStunting,
            'avg_stunting_persen'  => $avgStuntingPersen,
            'avg_bblr'             => $avgBblr,
            'avg_asi'              => $avgAsi,
            'avg_pelayanan'        => $avgPelayanan,
        ];

        return view('dataStunting', compact(
            'data',
            'kabupaten',
            'bulan',
            'tahun',
            'summary'
        ));
    }

    public function create()
    {
        $kabupaten = Kabupaten::orderBy('nama_kabupaten')->get();
        return view('createStunting', compact('kabupaten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kabupaten_id'=>'required',
            'nama_puskesmas'=>'required',
            'jumlah_balita'=>'required|numeric',
            'jumlah_stunting'=>'required|numeric',
            'jumlah_bblr'=>'required|numeric',
            'persentase_asi'=>'required|numeric',
            'persentase_pelayanan'=>'required|numeric',
            'tanggal' => 'required|date'

        ]);

        $tanggal = $request->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $namaPuskesmas = ucwords(strtolower(trim($request->nama_puskesmas)));

        $puskesmas = Puskesmas::firstOrCreate(
            [
                'kabupaten_id'   => $request->kabupaten_id,
                'nama_puskesmas' => $namaPuskesmas
            ]

        );

        DataStunting::create([
            'kabupaten_id'=>$request->kabupaten_id,
            'puskesmas_id'=>$puskesmas->id,
            'jumlah_balita'=>$request->jumlah_balita,
            'jumlah_stunting'=>$request->jumlah_stunting,
            'jumlah_bblr'=>$request->jumlah_bblr,
            'persentase_asi'=>$request->persentase_asi,
            'persentase_pelayanan'=>$request->persentase_pelayanan,
            'tanggal'=>$tanggal,
            'bulan'=>$bulan,
            'tahun'=>$tahun,

        ]);

        return redirect()
            ->route('dataStunting')
            ->with('success','Data berhasil ditambahkan');
    }

    public function edit(DataStunting $dataStunting)
    {
        $kabupaten = Kabupaten::all();
        return view('editStunting', compact(
            'dataStunting',
            'kabupaten'
        ));
    }

    public function update(Request $request, DataStunting $dataStunting)
    {
        $request->validate([
            'kabupaten_id'=>'required',
            'nama_puskesmas'=>'required',
            'jumlah_balita'=>'required|numeric',
            'jumlah_stunting'=>'required|numeric',
            'jumlah_bblr'=>'required|numeric',
            'persentase_asi'=>'required|numeric',
            'persentase_pelayanan'=>'required|numeric',
            'tanggal'=>'required|date'
    
        ]);
    
        $tanggal = $request->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $namaPuskesmas = ucwords(strtolower(trim($request->nama_puskesmas)));

        $puskesmas = Puskesmas::firstOrCreate(
            [
                'kabupaten_id'   => $request->kabupaten_id,
                'nama_puskesmas' => $namaPuskesmas
            ]
    
        );
    
        $dataStunting->update([
            'kabupaten_id'=>$request->kabupaten_id,
            'puskesmas_id'=>$puskesmas->id,
            'jumlah_balita'=>$request->jumlah_balita,
            'jumlah_stunting'=>$request->jumlah_stunting,
            'jumlah_bblr'=>$request->jumlah_bblr,
            'persentase_asi'=>$request->persentase_asi,
            'persentase_pelayanan'=>$request->persentase_pelayanan,
            'tanggal'=>$tanggal,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
    
        ]);
    
        return redirect()->route('dataStunting')
            ->with('success','Data berhasil diperbarui');
    }

    public function destroy(DataStunting $dataStunting)
    {
        $dataStunting->delete();

        return redirect()
            ->route('dataStunting')
            ->with('success','Data berhasil dihapus');
    }

    public function import()
    {
        return view('importStunting');
    }

    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Data Stunting');

        $headers = [
            'Kabupaten',
            'Nama Puskesmas',
            'Jumlah Balita',
            'Jumlah Stunting',
            'Jumlah BBLR',
            'Persentase ASI (%)',
            'Persentase Pelayanan (%)',
            'Tanggal (YYYY-MM-DD)'
        ];

        $sheet->fromArray([$headers], null, 'A1');

        // Style Header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $sampleData = [
            ['Lombok Barat', 'Puskesmas Gerung', 1200, 150, 25, 75.5, 88.0, date('Y-m-d')],
            ['Lombok Tengah', 'Puskesmas Praya', 1500, 180, 30, 80.0, 90.0, date('Y-m-d')],
            ['Lombok Timur', 'Puskesmas Selong', 1800, 210, 35, 82.5, 92.0, date('Y-m-d')],
        ];

        $sheet->fromArray($sampleData, null, 'A2');

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'template_import_stunting.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function prosesImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240'
        ]);

        try {
            $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file Excel/CSV. Pastikan format file valid.');
        }

        $importedCount = 0;
        $failedCount = 0;

        foreach ($spreadsheet->getWorksheetIterator() as $sheet) {

            $rows = $sheet->toArray(null, true, true, false);

            if (count($rows) < 2) {
                continue;
            }

            $header = [];
            $startRowIndex = 0;

            /* Cari Header Otomatis (Abaikan judul dokumen yang hanya di 1 sel) */
            foreach ($rows as $index => $row) {
                if (!is_array($row)) continue;

                $nonEmptyCells = array_filter($row, function ($cell) {
                    return $cell !== null && trim((string)$cell) !== '';
                });

                // Header yang valid setidaknya mengisi 2 kolom atau lebih
                if (count($nonEmptyCells) >= 2) {
                    $rowText = strtolower(implode(' ', $nonEmptyCells));

                    if (
                        str_contains($rowText, 'kabupaten') ||
                        str_contains($rowText, 'puskesmas') ||
                        str_contains($rowText, 'stunting') ||
                        str_contains($rowText, 'balita')
                    ) {
                        $header = $row;
                        $startRowIndex = $index + 1;
                        break;
                    }
                }
            }

            if (empty($header)) {
                continue;
            }

            /* Mapping Kolom Berdasarkan Nama Header */
            $map = [];

            foreach ($header as $i => $kolom) {
                if ($kolom === null) continue;
                $kolomClean = strtolower(trim((string)$kolom));

                if (str_contains($kolomClean, 'kabupaten') || str_contains($kolomClean, 'kota')) {
                    $map['kabupaten'] = $i;
                } elseif (str_contains($kolomClean, 'puskesmas')) {
                    $map['puskesmas'] = $i;
                } elseif (str_contains($kolomClean, 'balita')) {
                    $map['balita'] = $i;
                } elseif (str_contains($kolomClean, 'stunting')) {
                    $map['stunting'] = $i;
                } elseif (str_contains($kolomClean, 'bblr')) {
                    $map['bblr'] = $i;
                } elseif (str_contains($kolomClean, 'asi')) {
                    $map['asi'] = $i;
                } elseif (str_contains($kolomClean, 'pelayanan') || str_contains($kolomClean, 'yankes')) {
                    $map['pelayanan'] = $i;
                } elseif (
                    str_contains($kolomClean, 'tanggal') ||
                    str_contains($kolomClean, 'bulan') ||
                    str_contains($kolomClean, 'periode') ||
                    str_contains($kolomClean, 'tahun')
                ) {
                    $map['tanggal'] = $i;
                }
            }

            /* Baca Isi Data */
            for ($i = $startRowIndex; $i < count($rows); $i++) {

                $row = $rows[$i];

                if (!is_array($row) || empty(array_filter($row, fn($c) => $c !== null && trim((string)$c) !== ''))) {
                    continue;
                }

                // Ambil & Cocokkan Kabupaten (Fuzzy Search)
                $rawKabupaten = isset($map['kabupaten']) ? trim((string)($row[$map['kabupaten']] ?? '')) : '';

                $kabupaten = null;
                if ($rawKabupaten !== '') {
                    $cleanKab = preg_replace('/^(kabupaten|kab\.|kab|kota)\s+/i', '', $rawKabupaten);
                    $cleanKab = trim($cleanKab);

                    $kabupaten = Kabupaten::whereRaw('LOWER(nama_kabupaten)=?', [strtolower($rawKabupaten)])
                        ->orWhereRaw('LOWER(nama_kabupaten)=?', [strtolower($cleanKab)])
                        ->orWhereRaw('LOWER(nama_kabupaten) LIKE ?', ['%' . strtolower($cleanKab) . '%'])
                        ->first();
                }

                if (!$kabupaten) {
                    $kabupaten = Kabupaten::first();
                }

                if (!$kabupaten) {
                    $failedCount++;
                    continue;
                }

                // Ambil Nama Puskesmas
                $namaPuskesmas = isset($map['puskesmas']) ? trim((string)($row[$map['puskesmas']] ?? '')) : '';
                if ($namaPuskesmas === '') {
                    $namaPuskesmas = 'Puskesmas ' . $kabupaten->nama_kabupaten;
                } else {
                    $namaPuskesmas = ucwords(strtolower($namaPuskesmas));
                }

                $puskesmas = Puskesmas::firstOrCreate([
                    'kabupaten_id'   => $kabupaten->id,
                    'nama_puskesmas' => $namaPuskesmas
                ]);

                // Bersihkan & Format Angka
                $jumlahBalita = isset($map['balita']) ? $this->cleanNumber($row[$map['balita']] ?? 0) : 0;
                $jumlahStunting = isset($map['stunting']) ? $this->cleanNumber($row[$map['stunting']] ?? 0) : 0;
                $jumlahBblr = isset($map['bblr']) ? $this->cleanNumber($row[$map['bblr']] ?? 0) : 0;
                $persentaseAsi = isset($map['asi']) ? $this->cleanNumber($row[$map['asi']] ?? 0) : 0;
                $persentasePelayanan = isset($map['pelayanan']) ? $this->cleanNumber($row[$map['pelayanan']] ?? 0) : 0;

                // Ambil & Format Tanggal
                $rawTanggal = isset($map['tanggal']) ? $row[$map['tanggal']] : null;
                $tanggal = now()->format('Y-m-d');

                if ($rawTanggal !== null && $rawTanggal !== '') {
                    if (is_numeric($rawTanggal)) {
                        try {
                            $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rawTanggal)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $tanggal = now()->format('Y-m-d');
                        }
                    } else {
                        $parsedTime = strtotime((string)$rawTanggal);
                        if ($parsedTime !== false) {
                            $tanggal = date('Y-m-d', $parsedTime);
                        }
                    }
                }

                $bulan = (int)date('m', strtotime($tanggal));
                $tahun = (int)date('Y', strtotime($tanggal));

                DataStunting::create([
                    'kabupaten_id'         => $kabupaten->id,
                    'puskesmas_id'         => $puskesmas->id,
                    'jumlah_balita'        => (int)$jumlahBalita,
                    'jumlah_stunting'      => (int)$jumlahStunting,
                    'jumlah_bblr'          => (int)$jumlahBblr,
                    'persentase_asi'       => (float)$persentaseAsi,
                    'persentase_pelayanan' => (float)$persentasePelayanan,
                    'tanggal'              => $tanggal,
                    'bulan'                => $bulan,
                    'tahun'                => $tahun,
                ]);

                $importedCount++;
            }
        }

        if ($importedCount > 0) {
            return redirect()
                ->route('dataStunting')
                ->with('success', "Berhasil mengimpor $importedCount data stunting ke dalam sistem.");
        } else {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengimpor data. Pastikan file Excel memiliki nama kolom header yang sesuai (seperti Kabupaten, Puskesmas, Balita, Stunting, BBLR, ASI, Pelayanan, Tanggal).');
        }
    }

    private function cleanNumber($value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        $valStr = trim((string)$value);
        $valStr = str_replace(['%', ' '], '', $valStr);

        if (str_contains($valStr, ',') && str_contains($valStr, '.')) {
            $valStr = str_replace('.', '', $valStr);
            $valStr = str_replace(',', '.', $valStr);
        } elseif (str_contains($valStr, ',')) {
            $valStr = str_replace(',', '.', $valStr);
        }

        return (float)$valStr;
    }
}