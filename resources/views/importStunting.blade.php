@extends('layouts.app')

@section('title', 'Import Data Stunting')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/importStunting.css') }}">
@endpush

@section('content')

<div class="content">

    <h1 class="page-title">
        Import Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TEMPLATE EXCEL BANNER -->
    <div class="template-card">
        <div class="template-card-header">
            <img src="{{ asset('images/icon/ide.png') }}" alt="Ide" class="icon-ide">
            <strong>Belum memiliki format Excel yang sesuai?</strong>
        </div>
        <p class="template-card-desc">
            Unduh template resmi agar struktur kolom (Kabupaten, Puskesmas, Balita, Stunting, BBLR, ASI, Pelayanan, Tanggal) sesuai secara otomatis.
        </p>
        <a href="{{ route('importStunting.template') }}" class="btn-download-template">
            <img src="{{ asset('images/icon/unduh file.png') }}" alt="Unduh Template" class="template-btn-icon">
            <span>Download Template Excel</span>
        </a>
    </div>

    <form action="{{ route('importStunting.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">

            <label class="label-title">Import File</label>

            <div class="upload-box">

                <label class="btn-pilih">
                    Pilih File
                    <input
                        type="file"
                        id="excel"
                        name="file"
                        accept=".xls,.xlsx,.csv"
                        required
                        hidden>
                </label>

                <span id="namaFile">
                    Masukkan File Anda
                </span>

            </div>

        </div>

        <div class="button-area">

            <a href="{{ route('dataStunting') }}"
               class="btn-kembali">
                Kembali
            </a>

            <button type="submit"
                    class="btn-simpan">
                Tambah
            </button>

        </div>

    </form>

</div>

<script>
document.getElementById('excel').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.getElementById('namaFile').textContent = this.files[0].name;
    } else {
        document.getElementById('namaFile').textContent = 'Masukkan File Anda';
    }
});
</script>

@endsection