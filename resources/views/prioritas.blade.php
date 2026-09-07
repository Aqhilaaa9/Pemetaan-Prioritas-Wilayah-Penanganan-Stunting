@extends('layouts.app')

@section('title', 'Prioritas Penanganan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/prioritas.css') }}">
@endpush

@section('content')

<div class="content">

    <div class="header-prioritas">
        <h1>
            Prioritas Penanganan Stunting Di<br>
            Setiap Wilayah Di Pulau Lombok
        </h1>

        <div class="filter-area">
            <form method="GET" action="{{ route('prioritas') }}">
                <select name="kabupaten" onchange="this.form.submit()">
                    <option value="">Semua Wilayah</option>
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

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kabupaten/Kota</th>
                    <th>Puskesmas</th>
                    <th>Nilai DSS</th>
                    <th>Ranking</th>
                    <th>Prioritas</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($hasil) && count($hasil) > 0)
                    @foreach($hasil as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['kabupaten'] }}</td>
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
                        <td colspan="6" class="empty-data">
                            Belum ada data stunting.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@endsection
 