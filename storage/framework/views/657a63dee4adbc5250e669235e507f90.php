

<?php $__env->startSection('title','Tambah Pengguna'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/createPengguna.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <div class="card-form">

        <h1>Tambah Data Pengguna</h1>

        <form action="<?php echo e(route('dataPengguna.store')); ?>"
              method="POST">

            <?php echo csrf_field(); ?>

            <div class="form-grid">
            <?php if($errors->any()): ?>
                <div style="color: red; margin-bottom: 15px;">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

                <div class="form-group">

                    <label>Nama Depan</label>

                    <input type="text"
                           name="nama_depan"
                           value="<?php echo e(old('nama_depan')); ?>">

                </div>

                <div class="form-group">

                    <label>Nama Belakang</label>

                    <input type="text"
                           name="nama_belakang"
                           value="<?php echo e(old('nama_belakang')); ?>">

                </div>

                <div class="form-group">

                    <label>Username</label>

                    <input type="text"
                           name="username"
                           value="<?php echo e(old('username')); ?>">

                </div>

                <div class="form-group">

                    <label>Instansi</label>

                    <input type="text"
                           name="instansi"
                           value="<?php echo e(old('instansi')); ?>">

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           value="<?php echo e(old('email')); ?>">

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

                <a href="<?php echo e(route('dataPengguna')); ?>"
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/createPengguna.blade.php ENDPATH**/ ?>