<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun | SIPENTA</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">

    <!-- CSS Laravel -->
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
    <style>
        body {
            padding: 30px 15px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f6fa;
        }
        .container {
            width: 1100px;
            max-width: 100%;
            min-height: auto;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,.12);
            overflow: hidden;
            display: flex;
            background: #fff;
            margin: auto;
        }
        .left {
            width: 40%;
            padding: 45px 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .right {
            width: 60%;
            padding: 40px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right h2 {
            font-size: 32px;
            font-weight: 800;
            color: #0b8f8b;
            margin-bottom: 20px;
            text-align: left;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 18px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group.full-width {
            grid-column: span 2;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #dcdcdc;
            border-radius: 8px;
            margin-bottom: 0;
            font-size: 14px;
            outline: none;
            transition: .3s;
            background-color: #fff;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #0ea5a0;
            box-shadow: 0 0 0 3px rgba(14,165,160,.15);
        }
        .btn-daftar {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            font-size: 16px;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-login {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 24px;
            background: transparent;
            border: 2px solid white;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: .3s;
        }
        .btn-login:hover {
            background: white;
            color: #0b7f78;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 12px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }
        .back-link:hover {
            color: #fff;
            transform: translateX(-3px);
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }
            .left, .right {
                width: 100%;
                padding: 30px 20px;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- sebelah kiri -->
    <div class="left">
        <div class="welcome">
            <a href="<?php echo e(route('login')); ?>" class="back-link">← Kembali ke Login</a>
            <br>
            <!-- Logo -->
            <img src="<?php echo e(asset('images/Logo Bru.png')); ?>" alt="Logo SIPENTA" class="logo" style="width: 110px; margin-bottom: 15px;">
            <h1 style="font-size: 32px; margin-bottom: 10px;">SIPENTA</h1>
            <p style="font-size: 13px; line-height: 1.6; margin-bottom: 20px;">
                Daftar akun baru untuk mengakses sistem informasi pemetaan dan analisis stunting. Pendaftaran Anda akan diverifikasi oleh Administrator sebelum dapat login.
            </p>

            <a href="<?php echo e(route('login')); ?>" class="btn-login">Sudah Punya Akun? Masuk</a>
        </div>
    </div>

    <!-- sebelah kanan -->
    <div class="right">
        <h2>Buat Akun Baru</h2>

        <?php if($errors->any()): ?>
            <div class="error" style="margin-bottom: 15px; font-size: 13px;">
                <ul style="margin-left: 20px; margin-bottom: 0;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Depan <span style="color:red">*</span></label>
                    <input type="text" name="nama_depan" value="<?php echo e(old('nama_depan')); ?>" placeholder="Nama depan" required>
                </div>

                <div class="form-group">
                    <label>Nama Belakang <span style="color:red">*</span></label>
                    <input type="text" name="nama_belakang" value="<?php echo e(old('nama_belakang')); ?>" placeholder="Nama belakang" required>
                </div>

                <div class="form-group">
                    <label>Username <span style="color:red">*</span></label>
                    <input type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="Username unik" required>
                </div>

                <div class="form-group">
                    <label>Instansi <span style="color:red">*</span></label>
                    <input type="text" name="instansi" value="<?php echo e(old('instansi')); ?>" placeholder="Contoh: Dinas Kesehatan" required>
                </div>

                <div class="form-group">
                    <label>Email <span style="color:red">*</span></label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="alamat@email.com" required>
                </div>

                <div class="form-group">
                    <label>Role / Peran <span style="color:red">*</span></label>
                    <select name="role" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Administrator</option>
                        <option value="kadis" <?php echo e(old('role') == 'kadis' ? 'selected' : ''); ?>>Kepala Dinas Kesehatan</option>
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
</html><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/auth/register.blade.php ENDPATH**/ ?>