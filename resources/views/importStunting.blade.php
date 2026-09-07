@extends('layouts.app')

@section('title','Import Data Stunting')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/importStunting.css') }}">
@endpush

@section('content')

<div class="content">

    <h1 class="page-title">
        Import Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    @if(session('error'))
        <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="margin-bottom: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 16px 20px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div>
            <strong style="color: #166534; display: block; margin-bottom: 4px;">💡 Belum memiliki format Excel yang sesuai?</strong>
            <span style="color: #15803d; font-size: 13px;">Unduh template resmi agar struktur kolom (Kabupaten, Puskesmas, Balita, Stunting, BBLR, ASI, Pelayanan, Tanggal) sesuai secara otomatis.</span>
        </div>
        <a href="{{ route('importStunting.template') }}" 
           style="background-color: #059669; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
            📥 Download Template Excel
        </a>
    </div>

    <form action="{{ route('importStunting.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">

            <label>Import File</label>

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

document.getElementById('excel').addEventListener('change',function(){

    if(this.files.length>0){

        document.getElementById('namaFile').innerHTML=this.files[0].name;

    }

});

</script>

@endsection