@extends('layouts.app')

@section('title','Edit Data Stunting')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/createStunting.css') }}">
@endpush

@section('content')

<div class="content">

    <h1 class="page-title">
        Edit Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    <form action="{{ route('updateStunting', $dataStunting->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-grid">

            <!-- KIRI -->

            <div class="form-group">

                <label>Kabupaten/Kota</label>

                <select name="kabupaten_id" required>

                    <option value="">Pilih Kabupaten</option>

                    @foreach($kabupaten as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kabupaten_id', $dataStunting->kabupaten_id) == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_kabupaten }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Puskesmas</label>

                <input
                    type="text"
                    name="nama_puskesmas"
                    value="{{ old('nama_puskesmas', $dataStunting->puskesmas->nama_puskesmas) }}">

            </div>

            <div class="form-group">

                <label>Jumlah Balita Stunting</label>

                <input
                    type="number"
                    name="jumlah_stunting"
                    value="{{ old('jumlah_stunting', $dataStunting->jumlah_stunting) }}">

            </div>

            <div class="form-group">

                <label>Persentase Pelayanan Kesehatan (%)</label>

                <input
                    type="number"
                    name="persentase_pelayanan"
                    value="{{ old('persentase_pelayanan', $dataStunting->persentase_pelayanan) }}">

            </div>

            <!-- KANAN -->

            <div class="form-group">

                <label>Jumlah Balita Diukur</label>

                <input
                    type="number"
                    name="jumlah_balita"
                    value="{{ old('jumlah_balita', $dataStunting->jumlah_balita) }}">

            </div>

            <div class="form-group">

                <label>Jumlah Bayi BBLR</label>

                <input
                    type="number"
                    name="jumlah_bblr"
                    value="{{ old('jumlah_bblr', $dataStunting->jumlah_bblr) }}">

            </div>

            <div class="form-group">

                <label>Persentase ASI Eksklusif (%)</label>

                <input
                    type="number"
                    name="persentase_asi"
                    value="{{ old('persentase_asi', $dataStunting->persentase_asi) }}">

            </div>

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', $dataStunting->tanggal ? \Carbon\Carbon::parse($dataStunting->tanggal)->format('Y-m-d') : ($dataStunting->tahun.'-'.sprintf('%02d',$dataStunting->bulan).'-01')) }}"
                    required>

            </div>

        </div>

        <div class="button-area">

            <a href="{{ route('dataStunting') }}"
               class="btn-kembali">

                Kembali

            </a>

            <button
                type="submit"
                class="btn-simpan">

                Simpan

            </button>

        </div>

    </form>

</div>

@endsection