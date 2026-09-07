

<?php $__env->startSection('title','Data Stunting'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/dataStunting.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="content">

    <h1 class="page-title">
        Data Stunting Di Setiap Wilayah Di Pulau Lombok
    </h1>

    <?php if(session('success')): ?>
        <div style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Filter -->
    <form action="<?php echo e(route('dataStunting')); ?>" method="GET">
        <div class="filter-section">

            <select name="kabupaten" onchange="this.form.submit()">
                <option value="">Semua Kabupaten</option>
                <?php $__currentLoopData = $kabupaten; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option
                        value="<?php echo e($item->id); ?>"
                        <?php echo e(request('kabupaten') == $item->id ? 'selected' : ''); ?>>
                        <?php echo e($item->nama_kabupaten); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="bulan" onchange="this.form.submit()">
                <option value="">Semua Bulan</option>
               
                <?php $__currentLoopData = $bulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option
                        value="<?php echo e($key); ?>"
                        <?php echo e(request('bulan') == $key ? 'selected' : ''); ?>>
                        <?php echo e($value); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="tahun" onchange="this.form.submit()">
                <option value="">Semua Tahun</option>

                <?php $__currentLoopData = $tahun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option
                        value="<?php echo e($item); ?>"
                        <?php echo e(request('tahun') == $item ? 'selected' : ''); ?>>
                        <?php echo e($item); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

        </div>
    </form>

    <!-- Tombol -->
    <div class="button-section">

        <a href="<?php echo e(route('createStunting')); ?>" class="btn-tambah">
            + Tambah Data
        </a>

    </div>

    <!-- Tabel -->

    <div class="table-wrapper">

        <table>

            <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Kabupaten</th>
                <th>Puskesmas</th>
                <th>Jumlah Balita</th>
                <th>Jumlah Stunting</th>
                <th>Persentase Stunting</th>
                <th>BBLR (%)</th>
                <th>ASI (%)</th>
                <th>Pelayanan (%)</th>
                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            <?php if($data->count() > 0): ?>

                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr>

                    <td><?php echo e($loop->iteration); ?></td>

                    <td>
                        <?php if($item->tanggal): ?>
                            <?php echo e(date('d', strtotime($item->tanggal))); ?> <?php echo e($bulan[(int)$item->bulan] ?? ''); ?> <?php echo e($item->tahun); ?>

                        <?php else: ?>
                            01 <?php echo e($bulan[(int)$item->bulan] ?? ''); ?> <?php echo e($item->tahun); ?>

                        <?php endif; ?>
                    </td>

                    <td><?php echo e($item->kabupaten->nama_kabupaten); ?></td>

                    <td><?php echo e($item->puskesmas->nama_puskesmas); ?></td>

                    <td><?php echo e(number_format($item->jumlah_balita, 0, ',', '.')); ?></td>

                    <td><?php echo e(number_format($item->jumlah_stunting, 0, ',', '.')); ?></td>

                    <td>
                        <?php echo e($item->jumlah_balita > 0 ? number_format(($item->jumlah_stunting / $item->jumlah_balita) * 100, 1) : 0); ?>%
                    </td>

                    <td><?php echo e(number_format($item->jumlah_bblr, 1)); ?>%</td>

                    <td><?php echo e(number_format($item->persentase_asi, 1)); ?>%</td>

                    <td><?php echo e(number_format($item->persentase_pelayanan, 1)); ?>%</td>

                    <td>
                        <div class="action-buttons">

                            <a href="<?php echo e(route('editStunting',$item->id)); ?>"
                                class="btn-edit">
                                Edit
                            </a>

                            <form action="<?php echo e(route('deleteStunting',$item->id)); ?>"
                                method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button class="btn-delete">Hapus</button>

                            </form>
                        </div>
                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <tr class="row-total" style="background-color: #e6f4f1; font-weight: bold; border-top: 2px solid #009688;">
                    <td colspan="4" style="text-align: center; font-weight: 700; color: #004d40;">Total Keseluruhan</td>
                    <td style="font-weight: 700;"><?php echo e(number_format($summary['total_balita'] ?? 0, 0, ',', '.')); ?></td>
                    <td style="font-weight: 700;"><?php echo e(number_format($summary['total_stunting'] ?? 0, 0, ',', '.')); ?></td>
                    <td style="font-weight: 700;"><?php echo e(number_format($summary['avg_stunting_persen'] ?? 0, 1)); ?>%</td>
                    <td style="font-weight: 700;"><?php echo e(number_format($summary['avg_bblr'] ?? 0, 1)); ?>%</td>
                    <td style="font-weight: 700;"><?php echo e(number_format($summary['avg_asi'] ?? 0, 1)); ?>%</td>
                    <td style="font-weight: 700;"><?php echo e(number_format($summary['avg_pelayanan'] ?? 0, 1)); ?>%</td>
                    <td></td>
                </tr>

            <?php else: ?>

            <tr>

                <td colspan="11" class="empty-data">

                    Belum ada data stunting.

                </td>

            </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/dataStunting.blade.php ENDPATH**/ ?>