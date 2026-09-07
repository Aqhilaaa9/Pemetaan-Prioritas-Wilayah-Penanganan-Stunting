

<?php $__env->startSection('title','Tambah Data Stunting'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/createStunting.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <h1 class="page-title">
        Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    <?php if($errors->any()): ?>
        <div style="background:#ffe6e6;border:1px solid red;padding:15px;margin-bottom:20px;">
            <b>Terjadi kesalahan:</b>
            <ul style="margin-top:10px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li style="color:red"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('dataStunting.store')); ?>" method="POST">

        <?php echo csrf_field(); ?>

        <div class="form-grid">

            <!-- KIRI -->

            <div class="form-group">

                <label>Kabupaten/Kota</label>

                <select name="kabupaten_id" required>

                    <option value="">Pilih Kabupaten</option>

                    <?php $__currentLoopData = $kabupaten; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($item->id); ?>">
                            <?php echo e($item->nama_kabupaten); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>

            </div>

            <div class="form-group">

                <label>Puskesmas</label>

                <input
                    type="text"
                    name="nama_puskesmas"
                    placeholder="Masukkan Nama Puskesmas">

            </div>

            <div class="form-group">

                <label>Jumlah Balita Stunting</label>
                <input
                    type="number"
                    name="jumlah_stunting"
                    placeholder="Masukkan Jumlah Balita Stunting">

            </div>

            <div class="form-group">

                <label>Persentase Pelayanan Kesehatan (%)</label>

                <input
                    type="number"
                    name="persentase_pelayanan"
                    placeholder="Masukkan Presentase Pelayanan Kesehatan">

            </div>

            <!-- KANAN -->

            <div class="form-group">

                <label>Jumlah Balita Diukur</label>

                <input type="number"
                       name="jumlah_balita"
                       placeholder="Masukkan Jumlah Balita Diukur">

            </div>

            <div class="form-group">

                <label>Jumlah Bayi BBLR (%)</label>

                <input type="number"
                       name="jumlah_bblr"
                       placeholder="Masukkan Jumlah Bayi BBLR">

            </div>

            <div class="form-group">

                <label>Persentase ASI Eksklusif (%)</label>

                <input type="number"
                       name="persentase_asi"
                       placeholder="Masukkan Presentase ASI Ekslusif">

            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input
                    type="date"
                    name="tanggal"
                    required>
            </div>

        </div>

        <div class="button-area">

            <a href="<?php echo e(route('dataStunting')); ?>"
               class="btn-kembali">

                Kembali

            </a>

            <div>

            <a href="<?php echo e(route('importStunting')); ?>"
                class="btn-import">

                    Import File

            </a>

                <button type="submit"
                        class="btn-simpan">

                    Simpan

                </button>

            </div>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/createStunting.blade.php ENDPATH**/ ?>