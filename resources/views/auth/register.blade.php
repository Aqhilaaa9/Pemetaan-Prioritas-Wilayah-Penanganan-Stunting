<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun | SIPENTA</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="container">

    <!-- BAGIAN KIRI -->
    <div class="left">
        <div class="welcome">

            <!-- Logo -->
            <img src="{{ asset('images/Logo Bru.png') }}" alt="Logo SIPENTA" class="logo">

            <h1>SIPENTA</h1>

            <h3>
                Sistem Informasi Pemetaan dan Prioritas Penanganan Stunting
                Pulau Lombok
            </h3>

            <p>
                Daftar akun baru untuk mengakses sistem informasi pemetaan dan analisis stunting. Pendaftaran Anda akan diverifikasi oleh Administrator sebelum dapat login.
            </p>

            <a href="{{ route('login') }}" class="btn-login">Sudah Punya Akun? Masuk</a>

        </div>
    </div>

    <!-- BAGIAN KANAN -->
    <div class="right">
        <h2>Buat Akun Baru</h2>

        @if($errors->any())
            <div class="error" style="margin-bottom: 15px; font-size: 13px;">
                <ul style="margin-left: 20px; margin-bottom: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Depan <span style="color:red">*</span></label>
                    <input type="text" name="nama_depan" value="{{ old('nama_depan') }}" placeholder="Nama depan" required>
                </div>

                <div class="form-group">
                    <label>Nama Belakang <span style="color:red">*</span></label>
                    <input type="text" name="nama_belakang" value="{{ old('nama_belakang') }}" placeholder="Nama belakang" required>
                </div>

                <div class="form-group">
                    <label>Username <span style="color:red">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Username unik" required>
                </div>

                <div class="form-group">
                    <label>Instansi <span style="color:red">*</span></label>
                    <input type="text" name="instansi" value="{{ old('instansi') }}" placeholder="Contoh: Dinas Kesehatan" required>
                </div>

                <div class="form-group">
                    <label>Email <span style="color:red">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="alamat@email.com" required>
                </div>

                <div class="form-group">
                    <label>Role / Peran <span style="color:red">*</span></label>
                    <select name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="kadis" {{ old('role') == 'kadis' ? 'selected' : '' }}>Kepala Dinas Kesehatan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kata Sandi <span style="color:red">*</span></label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Kata Sandi <span style="color:red">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                </div>
            </div>

            <button type="submit" class="btn-daftar">Daftar Sekarang</button>
        </form>
    </div>

</div>

</body>
</html>