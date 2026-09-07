<?php $__env->startSection('title','Data Pengguna'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/user.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <div class="header-content">

        <h1 class="judul">
            Data Pengguna
        </h1>

        <a href="<?php echo e(route('createPengguna')); ?>" class="btn-tambah">
            + Tambah Pengguna
        </a>

    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- TABEL 1: PENGGUNA TERDAFTAR (AKTIF) -->
    <div class="section-box">
        <h2 class="sub-judul">Daftar Pengguna Terdaftar</h2>

        <table class="table-users">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Username</th>
                    <th>Instansi</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($item->nama_depan); ?></td>
                    <td><?php echo e($item->nama_belakang); ?></td>
                    <td><?php echo e($item->username); ?></td>
                    <td><?php echo e($item->instansi); ?></td>
                    <td><?php echo e($item->email); ?></td>
                    <td><?php echo e(ucfirst($item->role)); ?></td>
                    
                    <td class="aksi">
                        <a href="<?php echo e(route('editPengguna', $item->id)); ?>"
                            class="btn-edit">
                            Edit
                        </a>

                        <form action="<?php echo e(route('dataPengguna.destroy',$item->id)); ?>"
                              method="POST">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit"
                                    class="btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td colspan="8" style="text-align:center">
                        Belum ada data pengguna terdaftar.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>
    </div>

    <!-- TABEL 2: VERIFIKASI PENDAFTARAN PENGGUNA BARU (PENDING) -->
    <div class="section-box" style="margin-top: 45px;">
        <div class="pending-header">
            <h2 class="sub-judul">Verifikasi Pendaftaran Pengguna Baru</h2>
            <?php if(count($pendingUsers) > 0): ?>
                <span class="badge-count"><?php echo e(count($pendingUsers)); ?> Pendaftaran Menunggu</span>
            <?php endif; ?>
        </div>

        <table class="table-users">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Username</th>
                    <th>Instansi</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi Verifikasi</th>

                </tr>

            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $pendingUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($item->nama_depan); ?></td>
                    <td><?php echo e($item->nama_belakang); ?></td>
                    <td><?php echo e($item->username); ?></td>
                    <td><?php echo e($item->instansi); ?></td>
                    <td><?php echo e($item->email); ?></td>
                    <td><?php echo e(ucfirst($item->role)); ?></td>
                    
                    <td class="aksi">
                        <form action="<?php echo e(route('dataPengguna.approve', $item->id)); ?>"
                              method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="btn-approve"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran pengguna ini?')">
                                Terima
                            </button>
                        </form>

                        <form action="<?php echo e(route('dataPengguna.reject', $item->id)); ?>"
                              method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="btn-reject"
                                    onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran pengguna ini?')">
                                Tolak
                            </button>
                        </form>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td colspan="8" style="text-align:center">
                        Tidak ada pendaftaran pengguna baru yang menunggu verifikasi.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/dataPengguna.blade.php ENDPATH**/ ?>