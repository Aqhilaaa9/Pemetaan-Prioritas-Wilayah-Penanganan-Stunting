@extends('layouts.app')

@section('title','Tambah Data Stunting')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/createStunting.css') }}">
@endpush

@section('content')

<div class="content">

    <h1 class="page-title">
        Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    @if ($errors->any())
        <div style="background:#ffe6e6;border:1px solid red;padding:15px;margin-bottom:20px;">
            <b>Terjadi kesalahan:</b>
            <ul style="margin-top:10px;">
                @foreach ($errors->all() as $error)
                    <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dataStunting.store') }}" method="POST">

        @csrf

        <div class="form-grid">

            <!-- KIRI -->

            <div class="form-group">

                <label>Kabupaten/Kota</label>

                <select name="kabupaten_id" required>

                    <option value="">Pilih Kabupaten</option>

                    @foreach($kabupaten as $item)

                        <option value="{{ $item->id }}">
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
                    placeholder="Masukkan Nama Puskesmas">

            </div>

            <div class="form-group">

                <label>Jumlah Balita Stunting</label>
                <input
                    type="number"
                    name="jumlah_stunting"
                    placeholder="Masukkan Jumlah Balita Stunting">

            </div>

            <div class="form-group">

                <label>Persentase Pelayanan Kesehatan (%)</label>

                <input
                    type="number"
                    name="persentase_pelayanan"
                    placeholder="Masukkan Presentase Pelayanan Kesehatan">

            </div>

            <!-- KANAN -->

            <div class="form-group">

                <label>Jumlah Balita Diukur</label>

                <input type="number"
                       name="jumlah_balita"
                       placeholder="Masukkan Jumlah Balita Diukur">

            </div>

            <div class="form-group">

                <label>Jumlah Bayi BBLR (%)</label>

                <input type="number"
                       name="jumlah_bblr"
                       placeholder="Masukkan Jumlah Bayi BBLR">

            </div>

            <div class="form-group">

                <label>Persentase ASI Eksklusif (%)</label>

                <input type="number"
                       name="persentase_asi"
                       placeholder="Masukkan Presentase ASI Ekslusif">

            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    required>
            </div>

        </div>

        <div class="button-area">

            <a href="{{ route('dataStunting') }}"
               class="btn-kembali">

                Kembali

            </a>

            <div>

            <a href="{{ route('importStunting') }}"
                class="btn-import">

                    Import File

            </a>

                <button type="submit"
                        class="btn-simpan">

                    Simpan

                </button>

            </div>

        </div>

    </form>

</div>

@endsection