

<?php $__env->startSection('title','Edit Data Stunting'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/createStunting.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <h1 class="page-title">
        Edit Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    <form action="<?php echo e(route('updateStunting', $dataStunting->id)); ?>" method="POST">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-grid">

            <!-- KIRI -->

            <div class="form-group">

                <label>Kabupaten/Kota</label>

                <select name="kabupaten_id" required>

                    <option value="">Pilih Kabupaten</option>

                    <?php $__currentLoopData = $kabupaten; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option
                            value="<?php echo e($item->id); ?>"
                            <?php echo e(old('kabupaten_id', $dataStunting->kabupaten_id) == $item->id ? 'selected' : ''); ?>>

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
                    value="<?php echo e(old('nama_puskesmas', $dataStunting->puskesmas->nama_puskesmas)); ?>">

            </div>

            <div class="form-group">

                <label>Jumlah Balita Stunting</label>

                <input
                    type="number"
                    name="jumlah_stunting"
                    value="<?php echo e(old('jumlah_stunting', $dataStunting->jumlah_stunting)); ?>">

            </div>

            <div class="form-group">

                <label>Persentase Pelayanan Kesehatan (%)</label>

                <input
                    type="number"
                    name="persentase_pelayanan"
                    value="<?php echo e(old('persentase_pelayanan', $dataStunting->persentase_pelayanan)); ?>">

            </div>

            <!-- KANAN -->

            <div class="form-group">

                <label>Jumlah Balita Diukur</label>

                <input
                    type="number"
                    name="jumlah_balita"
                    value="<?php echo e(old('jumlah_balita', $dataStunting->jumlah_balita)); ?>">

            </div>

            <div class="form-group">

                <label>Jumlah Bayi BBLR</label>

                <input
                    type="number"
                    name="jumlah_bblr"
                    value="<?php echo e(old('jumlah_bblr', $dataStunting->jumlah_bblr)); ?>">

            </div>

            <div class="form-group">

                <label>Persentase ASI Eksklusif (%)</label>

                <input
                    type="number"
                    name="persentase_asi"
                    value="<?php echo e(old('persentase_asi', $dataStunting->persentase_asi)); ?>">

            </div>

            <div class="form-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    value="<?php echo e(old('tanggal', $dataStunting->tanggal ? \Carbon\Carbon::parse($dataStunting->tanggal)->format('Y-m-d') : ($dataStunting->tahun.'-'.sprintf('%02d',$dataStunting->bulan).'-01'))); ?>"
                    required>

            </div>

        </div>

        <div class="button-area">

            <a href="<?php echo e(route('dataStunting')); ?>"
               class="btn-kembali">

                Kembali

            </a>

            <button
                type="submit"
                class="btn-simpan">

                Simpan

            </button>

        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/editStunting.blade.php ENDPATH**/ ?>