@extends('layouts.app')

@section('title','Edit Data Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/editPengguna.css') }}">
@endpush

@section('content')

<div class="content">

    <div class="form-card">

        <h1 class="judul">
            Edit Data Pengguna
        </h1>

        <form action="{{ route('updatePengguna',$user->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Depan</label>
                    <input
                        type="text"
                        name="nama_depan"
                        value="{{ old('nama_depan',$user->nama_depan) }}">
                </div>

                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input
                        type="text"
                        name="nama_belakang"
                        value="{{ old('nama_belakang',$user->nama_belakang) }}">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username',$user->username) }}">
                </div>

                <div class="form-group">
                    <label>Instansi</label>
                    <input
                        type="text"
                        name="instansi"
                        value="{{ old('instansi',$user->instansi) }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email',$user->email) }}">
                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role">

                        <option value="admin"
                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="kadis"
                            {{ old('role', $user->role) == 'kadis' ? 'selected' : '' }}>
                            Kapala Dinas Kesehatan
                        </option>

                    </select>

                </div>
                
                <div class="form-group">
                    <label>Password Baru</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin diubah">
                </div>

            </div>

            <div class="button-area">

                <a href="{{ route('dataPengguna') }}" class="btn-batal">
                    Kembali
                </a>

                <button type="submit" class="btn-simpan">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection