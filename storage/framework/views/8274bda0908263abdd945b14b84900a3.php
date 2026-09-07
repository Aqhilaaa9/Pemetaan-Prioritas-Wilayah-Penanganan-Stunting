

<?php $__env->startSection('title', 'Prioritas Penanganan'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/prioritas.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">

    <div class="header-prioritas">
        <h1>
            Prioritas Penanganan Stunting Di Setiap Wilayah Di Pulau Lombok
        </h1>

        <div class="filter-area">
            <form method="GET" action="<?php echo e(route('prioritas')); ?>">
                <select name="kabupaten" onchange="this.form.submit()">
                    <option value="">Semua Wilayah</option>
                    <?php $__currentLoopData = $kabupaten; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>" <?php echo e(($kabupatenId ?? request('kabupaten')) == $item->id ? 'selected' : ''); ?>>
                            <?php echo e($item->nama_kabupaten); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select name="tahun" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    <?php if(isset($tahunList) && count($tahunList) > 0): ?>
                        <?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($th); ?>" <?php echo e(($tahunSelected ?? request('tahun')) == $th ? 'selected' : ''); ?>>
                                Tahun <?php echo e($th); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </form>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kabupaten/Kota</th>
                    <th>Puskesmas</th>
                    <th>Nilai DSS</th>
                    <th>Ranking</th>
                    <th>Prioritas</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($hasil) && count($hasil) > 0): ?>
                    <?php $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($item['kabupaten']); ?></td>
                            <td><?php echo e($item['puskesmas']); ?></td>
                            <td><?php echo e(number_format($item['nilai_dss'], 2)); ?></td>
                            <td><?php echo e($item['ranking']); ?></td>
                            <td>
                                <span class="prioritas-<?php echo e(strtolower($item['prioritas'])); ?>">
                                    <?php echo e($item['prioritas']); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-data">
                            Belum ada data stunting.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/prioritas.blade.php ENDPATH**/ ?>