<?php $__env->startSection('title', 'Import Data Stunting'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/importStunting.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <h1 class="page-title">
        Import Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    <?php if(session('error')): ?>
        <div class="alert-error">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- TEMPLATE EXCEL BANNER -->
    <div class="template-card">
        <div class="template-card-header">
            <img src="<?php echo e(asset('images/icon/ide.png')); ?>" alt="Ide" class="icon-ide">
            <strong>Belum memiliki format Excel yang sesuai?</strong>
        </div>
        <p class="template-card-desc">
            Unduh template resmi agar struktur kolom (Kabupaten, Puskesmas, Balita, Stunting, BBLR, ASI, Pelayanan, Tanggal) sesuai secara otomatis.
        </p>
        <a href="<?php echo e(route('importStunting.template')); ?>" class="btn-download-template">
            <img src="<?php echo e(asset('images/icon/unduh file.png')); ?>" alt="Unduh Template" class="template-btn-icon">
            <span>Download Template Excel</span>
        </a>
    </div>

    <form action="<?php echo e(route('importStunting.store')); ?>"
          method="POST"
          enctype="multipart/form-data">

        <?php echo csrf_field(); ?>

        <div class="form-group">

            <label class="label-title">Import File</label>

            <div class="upload-box">

                <label class="btn-pilih">
                    Pilih File
                    <input
                        type="file"
                        id="excel"
                        name="file"
                        accept=".xls,.xlsx,.csv"
                        required
                        hidden>
                </label>

                <span id="namaFile">
                    Masukkan File Anda
                </span>

            </div>

        </div>

        <div class="button-area">

            <a href="<?php echo e(route('dataStunting')); ?>"
               class="btn-kembali">
                Kembali
            </a>

            <button type="submit"
                    class="btn-simpan">
                Tambah
            </button>

        </div>

    </form>

</div>

<script>
document.getElementById('excel').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.getElementById('namaFile').textContent = this.files[0].name;
    } else {
        document.getElementById('namaFile').textContent = 'Masukkan File Anda';
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/importStunting.blade.php ENDPATH**/ ?>