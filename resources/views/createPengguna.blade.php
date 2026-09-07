@extends('layouts.app')

@section('title','Tambah Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/createPengguna.css') }}">
@endpush

@section('content')

<div class="content">

    <div class="card-form">

        <h1>Tambah Data Pengguna</h1>

        <form action="{{ route('dataPengguna.store') }}"
              method="POST">

            @csrf

            <div class="form-grid">
            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <div class="form-group">

                    <label>Nama Depan</label>

                    <input type="text"
                           name="nama_depan"
                           value="{{ old('nama_depan') }}">

                </div>

                <div class="form-group">

                    <label>Nama Belakang</label>

                    <input type="text"
                           name="nama_belakang"
                           value="{{ old('nama_belakang') }}">

                </div>

                <div class="form-group">

                    <label>Username</label>

                    <input type="text"
                           name="username"
                           value="{{ old('username') }}">

                </div>

                <div class="form-group">

                    <label>Instansi</label>

                    <input type="text"
                           name="instansi"
                           value="{{ old('instansi') }}">

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}">

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input type="password"
                           name="password">

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role">

                        <option value="">Pilih Role</option>

                        <option value="admin">Admin</option>

                        <option value="kadis">Kepala Dinas</option>

                    </select>

                </div>

            </div>

            <div class="btn-area">

                <a href="{{ route('dataPengguna') }}"
                   class="btn-batal">

                    Batal

                </a>

                <button class="btn-simpan">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection