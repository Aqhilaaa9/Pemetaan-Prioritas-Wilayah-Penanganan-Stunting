@extends('layouts.app')

@section('title','Data Stunting')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataStunting.css') }}">
@endpush

@section('content')


<div class="content">

    <h1 class="page-title">
        Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter -->
    <form action="{{ route('dataStunting') }}" method="GET">
        <div class="filter-section">

            <select name="kabupaten" onchange="this.form.submit()">
                <option value="">Semua Kabupaten</option>
                @foreach($kabupaten as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ request('kabupaten') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_kabupaten }}
                    </option>
                @endforeach
            </select>

            <select name="bulan" onchange="this.form.submit()">
                <option value="">Semua Bulan</option>
               
                @foreach($bulan as $key=>$value)
                    <option
                        value="{{ $key }}"
                        {{ request('bulan') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <select name="tahun" onchange="this.form.submit()">
                <option value="">Semua Tahun</option>

                @foreach($tahun as $item)
                    <option
                        value="{{ $item }}"
                        {{ request('tahun') == $item ? 'selected' : '' }}>
                        {{ $item }}
                    </option>
                @endforeach
            </select>

        </div>
    </form>

    <!-- Tombol -->
    <div class="button-section">

        <a href="{{ route('createStunting') }}" class="btn-tambah">
            + Tambah Data
        </a>

    </div>

    <!-- Tabel -->

    <div class="table-wrapper">

        <table>

            <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Kabupaten</th>
                <th>Puskesmas</th>
                <th>Jumlah Balita</th>
                <th>Jumlah Stunting</th>
                <th>Persentase Stunting</th>
                <th>BBLR (%)</th>
                <th>ASI (%)</th>
                <th>Pelayanan (%)</th>
                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            @if($data->count() > 0)

                @foreach($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        @if($item->tanggal)
                            {{ date('d', strtotime($item->tanggal)) }} {{ $bulan[(int)$item->bulan] ?? '' }} {{ $item->tahun }}
                        @else
                            01 {{ $bulan[(int)$item->bulan] ?? '' }} {{ $item->tahun }}
                        @endif
                    </td>

                    <td>{{ $item->kabupaten->nama_kabupaten }}</td>

                    <td>{{ $item->puskesmas->nama_puskesmas }}</td>

                    <td>{{ number_format($item->jumlah_balita, 0, ',', '.') }}</td>

                    <td>{{ number_format($item->jumlah_stunting, 0, ',', '.') }}</td>

                    <td>
                        {{ $item->jumlah_balita > 0 ? number_format(($item->jumlah_stunting / $item->jumlah_balita) * 100, 1) : 0 }}%
                    </td>

                    <td>{{ number_format($item->jumlah_bblr, 1) }}%</td>

                    <td>{{ number_format($item->persentase_asi, 1) }}%</td>

                    <td>{{ number_format($item->persentase_pelayanan, 1) }}%</td>

                    <td>
                        <div class="action-buttons">

                            <a href="{{ route('editStunting',$item->id) }}"
                                class="btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('deleteStunting',$item->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn-delete">Hapus</button>

                            </form>
                        </div>
                    </td>

                </tr>

                @endforeach

                <tr class="row-total" style="background-color: #e6f4f1; font-weight: bold; border-top: 2px solid #009688;">
                    <td colspan="4" style="text-align: center; font-weight: 700; color: #004d40;">Total Keseluruhan</td>
                    <td style="font-weight: 700;">{{ number_format($summary['total_balita'] ?? 0, 0, ',', '.') }}</td>
                    <td style="font-weight: 700;">{{ number_format($summary['total_stunting'] ?? 0, 0, ',', '.') }}</td>
                    <td style="font-weight: 700;">{{ number_format($summary['avg_stunting_persen'] ?? 0, 1) }}%</td>
                    <td style="font-weight: 700;">{{ number_format($summary['avg_bblr'] ?? 0, 1) }}%</td>
                    <td style="font-weight: 700;">{{ number_format($summary['avg_asi'] ?? 0, 1) }}%</td>
                    <td style="font-weight: 700;">{{ number_format($summary['avg_pelayanan'] ?? 0, 1) }}%</td>
                    <td></td>
                </tr>

            @else

            <tr>

                <td colspan="11" class="empty-data">

                    Belum ada data stunting.

                </td>

            </tr>

            @endif

            </tbody>

        </table>

    </div>

</div>

@endsection