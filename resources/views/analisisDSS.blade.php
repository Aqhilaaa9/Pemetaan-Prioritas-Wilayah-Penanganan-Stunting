@extends('layouts.app')

@section('title', 'Analisis DSS')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/analisisDSS.css') }}">
@endpush

@section('content')

<div class="content">
    <!-- ================= SECTION 1: DATA AWAL STUNTING ================= -->
    <div class="section-header-wrap">
        <h2 class="judul-section">
            Data Awal Stunting Di Pulau Lombok
        </h2>

        <div class="filter-area">
            <form method="GET" action="{{ route('analisisDSS') }}" class="filter-form">
                <select name="kabupaten" onchange="this.form.submit()">
                    <option value="">Semua Kabupaten</option>
                    @foreach($kabupaten as $item)
                        <option value="{{ $item->id }}" {{ ($kabupatenId ?? request('kabupaten')) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kabupaten }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @if(isset($tahunList) && count($tahunList) > 0)
                        @foreach($tahunList as $th)
                            <option value="{{ $th }}" {{ ($tahunSelected ?? request('tahun')) == $th ? 'selected' : '' }}>
                                Tahun {{ $th }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </form>
        </div>
    </div>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Puskesmas</th>
                    <th>Stunting (TB/U)</th>
                    <th>Jumlah Balita yang Diukur Tinggi Badan</th>
                    <th>Bayi BBLR</th>
                    <th>ASI</th>
                    <th>Pelayanan</th>
                </tr>
            </thead>
            <tbody>
                @if(count($data) > 0)
                    @foreach($data as $item)
                        @php
                            $stuntingPersen = ($item->jumlah_balita > 0)
                                ? ($item->jumlah_stunting / $item->jumlah_balita) * 100
                                : 0;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->puskesmas->nama_puskesmas ?? '-' }}</td>
                            <td>{{ number_format($stuntingPersen, 1) }}%</td>
                            <td>{{ number_format($item->jumlah_balita) }}</td>
                            <td>{{ number_format($item->jumlah_bblr, 1) }}%</td>
                            <td>{{ number_format($item->persentase_asi, 1) }}%</td>
                            <td>{{ number_format($item->persentase_pelayanan, 1) }}%</td>
                        </tr>
                    @endforeach
                    <tr class="row-total">
                        <td colspan="2" class="fw-bold">Total Keseluruhan</td>
                        <td class="fw-bold">{{ number_format($summary['avg_stunting_persen'] ?? 0, 1) }}%</td>
                        <td class="fw-bold">{{ number_format($summary['total_balita'] ?? 0) }}</td>
                        <td class="fw-bold">{{ number_format($summary['avg_bblr_persen'] ?? 0, 1) }}%</td>
                        <td class="fw-bold">{{ number_format($summary['avg_asi_persen'] ?? 0, 1) }}%</td>
                        <td class="fw-bold">{{ number_format($summary['avg_pelayanan_persen'] ?? 0, 1) }}%</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="7" class="kosong">Belum ada data stunting.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 2: MATRIKS PERBANDINGAN KRITERIA AHP ================= -->
    <h2 class="judul-section">
        Matriks Perbandingan Kriteria untuk Pemetaan Stunting
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                    <th>C5</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $matrixDisplay = $ahp['matrixDisplay'] ?? [
                        [1,       3,       5,     5,     7],
                        ['1/3',   1,       3,     3,     5],
                        ['1/5',  '1/3',    1,     3,     3],
                        ['1/7',  '1/5',   '1/3',  1,     1],
                        ['1/7',  '1/5',   '1/3',  1,     1],
                    ];
                    $kriteriaList = $ahp['bobotKriteria'] ?? [];
                    $i = 0;
                @endphp
                @foreach($kriteriaList as $kode => $info)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="text-align: left; padding-left: 20px;">{{ $info['kriteria'] ?? $kode }}</td>
                        <td>{{ $matrixDisplay[$i][0] ?? '1' }}</td>
                        <td>{{ $matrixDisplay[$i][1] ?? '1' }}</td>
                        <td>{{ $matrixDisplay[$i][2] ?? '1' }}</td>
                        <td>{{ $matrixDisplay[$i][3] ?? '1' }}</td>
                        <td>{{ $matrixDisplay[$i][4] ?? '1' }}</td>
                    </tr>
                    @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 3: BOBOT KRITERIA AHP ================= -->
    <h2 class="judul-section">
        Bobot Kriteria AHP untuk Pemetaan Stunting
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Bobot</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($ahp['bobotKriteria'] as $kode => $info)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $info['kode'] }}</td>
                        <td style="text-align: left; padding-left: 20px;">{{ $info['nama_lengkap'] }}</td>
                        <td>{{ number_format($info['bobot'], 2) }}</td>
                        <td>{{ $info['tipe'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 4: NORMALISASI SAW ================= -->
    <h2 class="judul-section">
        Normalisasi SAW untuk Pemetaan Stunting
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Puskesmas</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                    <th>C5</th>
                </tr>
            </thead>
            <tbody>
                @if(count($normalisasiSaw) > 0)
                    @foreach($normalisasiSaw as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['puskesmas'] }}</td>
                            <td>{{ number_format($item['C1'], 2) }}</td>
                            <td>{{ number_format($item['C2'], 2) }}</td>
                            <td>{{ number_format($item['C3'], 2) }}</td>
                            <td>{{ number_format($item['C4'], 2) }}</td>
                            <td>{{ number_format($item['C5'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="kosong">Belum ada data normalisasi.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 5: PENENTUAN PRIORITAS WILAYAH ================= -->
    <h2 class="judul-section">
        Penentuan Prioritas Wilayah Penanganan Stunting Di Pulau Lombok
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Puskesmas</th>
                    <th>Nilai DSS</th>
                    <th>Ranking</th>
                    <th>Prioritas</th>
                </tr>
            </thead>
            <tbody>
                @if(count($hasil) > 0)
                    @foreach($hasil as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['puskesmas'] }}</td>
                            <td>{{ number_format($item['nilai_dss'], 2) }}</td>
                            <td>{{ $item['ranking'] }}</td>
                            <td>
                                <span class="prioritas-{{ strtolower($item['prioritas']) }}">
                                    {{ $item['prioritas'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="kosong">Belum ada data hasil prioritas.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@endsection