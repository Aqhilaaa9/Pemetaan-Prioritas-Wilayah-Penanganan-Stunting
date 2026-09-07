

<?php $__env->startSection('title','Edit Data Pengguna'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/editPengguna.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <div class="form-card">

        <h1 class="judul">
            Edit Data Pengguna
        </h1>

        <form action="<?php echo e(route('updatePengguna',$user->id)); ?>" method="POST">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Depan</label>
                    <input
                        type="text"
                        name="nama_depan"
                        value="<?php echo e(old('nama_depan',$user->nama_depan)); ?>">
                </div>

                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input
                        type="text"
                        name="nama_belakang"
                        value="<?php echo e(old('nama_belakang',$user->nama_belakang)); ?>">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input
                        type="text"
                        name="username"
                        value="<?php echo e(old('username',$user->username)); ?>">
                </div>

                <div class="form-group">
                    <label>Instansi</label>
                    <input
                        type="text"
                        name="instansi"
                        value="<?php echo e(old('instansi',$user->instansi)); ?>">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email',$user->email)); ?>">
                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role">

                        <option value="admin"
                            <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>
                            Admin
                        </option>

                        <option value="kadis"
                            <?php echo e(old('role', $user->role) == 'kadis' ? 'selected' : ''); ?>>
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

                <a href="<?php echo e(route('dataPengguna')); ?>" class="btn-batal">
                    Kembali
                </a>

                <button type="submit" class="btn-simpan">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/editPengguna.blade.php ENDPATH**/ ?>