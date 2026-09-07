<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIPENTA</title>

    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
</head>
<body>

<div class="container">

    <!-- BAGIAN KIRI -->
    <div class="left">

        <div class="welcome">

            <!-- Logo -->
            <img src="<?php echo e(asset('images/Logo Bru.png')); ?>" alt="Logo SIPENTA" class="logo">

            <h1>SIPENTA</h1>

            <h3>
                Sistem Informasi Pemetaan dan Prioritas Penanganan Stunting
                Pulau Lombok
            </h3>

            <p>
                Sistem ini merupakan sistem digunakan oleh Administrator dan Kepala Dinas
                Kesehatan untuk melakukan pemetaan wilayah, analisis DSS,
                dan penentuan prioritas penanganan stunting pada setiap wilayah di Pulau Lombok.
            </p>

            <small>
                Belum memiliki akun?<br>
                <a href="<?php echo e(route('register')); ?>" style="color: #fff; font-weight: 700; text-decoration: underline;">Daftar Akun Baru</a>
            </small>

        </div>

    </div>

    <!-- BAGIAN KANAN -->
    <div class="right">

        <h2>Masuk</h2>

        <?php if(session('status')): ?>
            <div class="success">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="error">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <label>Username</label>

            <input
                type="text"
                name="username"
                value="<?php echo e(old('username')); ?>"
                placeholder="Masukkan Username"
                required
                autofocus
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan Password"
                required
            >


            <button type="submit" class="btn-daftar">
                Masuk
            </button>

        </form>

    </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/auth/login.blade.php ENDPATH**/ ?>