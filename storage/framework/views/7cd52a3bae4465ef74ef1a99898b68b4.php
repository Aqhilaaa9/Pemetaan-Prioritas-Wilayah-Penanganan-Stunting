<?php $__env->startSection('title', 'Analisis DSS'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/analisisDSS.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content">
    <!-- ================= SECTION 1: DATA AWAL STUNTING ================= -->
    <div class="section-header-wrap">
        <h2 class="judul-section">
            Data Awal Stunting Di Pulau Lombok
        </h2>

        <div class="filter-area">
            <form method="GET" action="<?php echo e(route('analisisDSS')); ?>" class="filter-form">
                <select name="kabupaten" onchange="this.form.submit()">
                    <option value="">Semua Kabupaten</option>
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

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Puskesmas</th>
                    <th>Stunting (TB/U)</th>
                    <th>Jumlah Balita yang Diukur Tinggi Badan</th>
                    <th>Bayi BBLR</th>
                    <th>ASI</th>
                    <th>Pelayanan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($data) > 0): ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $stuntingPersen = ($item->jumlah_balita > 0)
                                ? ($item->jumlah_stunting / $item->jumlah_balita) * 100
                                : 0;
                        ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($item->puskesmas->nama_puskesmas ?? '-'); ?></td>
                            <td><?php echo e(number_format($stuntingPersen, 1)); ?>%</td>
                            <td><?php echo e(number_format($item->jumlah_balita)); ?></td>
                            <td><?php echo e(number_format($item->jumlah_bblr, 1)); ?>%</td>
                            <td><?php echo e(number_format($item->persentase_asi, 1)); ?>%</td>
                            <td><?php echo e(number_format($item->persentase_pelayanan, 1)); ?>%</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="row-total">
                        <td colspan="2" class="fw-bold">Total Keseluruhan</td>
                        <td class="fw-bold"><?php echo e(number_format($summary['avg_stunting_persen'] ?? 0, 1)); ?>%</td>
                        <td class="fw-bold"><?php echo e(number_format($summary['total_balita'] ?? 0)); ?></td>
                        <td class="fw-bold"><?php echo e(number_format($summary['avg_bblr_persen'] ?? 0, 1)); ?>%</td>
                        <td class="fw-bold"><?php echo e(number_format($summary['avg_asi_persen'] ?? 0, 1)); ?>%</td>
                        <td class="fw-bold"><?php echo e(number_format($summary['avg_pelayanan_persen'] ?? 0, 1)); ?>%</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="kosong">Belum ada data stunting.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 2: MATRIKS PERBANDINGAN KRITERIA AHP ================= -->
    <h2 class="judul-section">
        Matriks Perbandingan Kriteria untuk Pemetaan Stunting
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                    <th>C5</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $matrixDisplay = $ahp['matrixDisplay'] ?? [
                        [1,       3,       5,     5,     7],
                        ['1/3',   1,       3,     3,     5],
                        ['1/5',  '1/3',    1,     3,     3],
                        ['1/7',  '1/5',   '1/3',  1,     1],
                        ['1/7',  '1/5',   '1/3',  1,     1],
                    ];
                    $kriteriaList = $ahp['bobotKriteria'] ?? [];
                    $i = 0;
                ?>
                <?php $__currentLoopData = $kriteriaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td style="text-align: left; padding-left: 20px;"><?php echo e($info['kriteria'] ?? $kode); ?></td>
                        <td><?php echo e($matrixDisplay[$i][0] ?? '1'); ?></td>
                        <td><?php echo e($matrixDisplay[$i][1] ?? '1'); ?></td>
                        <td><?php echo e($matrixDisplay[$i][2] ?? '1'); ?></td>
                        <td><?php echo e($matrixDisplay[$i][3] ?? '1'); ?></td>
                        <td><?php echo e($matrixDisplay[$i][4] ?? '1'); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 3: BOBOT KRITERIA AHP ================= -->
    <h2 class="judul-section">
        Bobot Kriteria AHP untuk Pemetaan Stunting
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Bobot</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php $__currentLoopData = $ahp['bobotKriteria']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($no++); ?></td>
                        <td><?php echo e($info['kode']); ?></td>
                        <td style="text-align: left; padding-left: 20px;"><?php echo e($info['nama_lengkap']); ?></td>
                        <td><?php echo e(number_format($info['bobot'], 2)); ?></td>
                        <td><?php echo e($info['tipe']); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 4: NORMALISASI SAW ================= -->
    <h2 class="judul-section">
        Normalisasi SAW untuk Pemetaan Stunting
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Puskesmas</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                    <th>C4</th>
                    <th>C5</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($normalisasiSaw) > 0): ?>
                    <?php $__currentLoopData = $normalisasiSaw; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($item['puskesmas']); ?></td>
                            <td><?php echo e(number_format($item['C1'], 2)); ?></td>
                            <td><?php echo e(number_format($item['C2'], 2)); ?></td>
                            <td><?php echo e(number_format($item['C3'], 2)); ?></td>
                            <td><?php echo e(number_format($item['C4'], 2)); ?></td>
                            <td><?php echo e(number_format($item['C5'], 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="kosong">Belum ada data normalisasi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ================= SECTION 5: PENENTUAN PRIORITAS WILAYAH ================= -->
    <h2 class="judul-section">
        Penentuan Prioritas Wilayah Penanganan Stunting Di Pulau Lombok
    </h2>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Puskesmas</th>
                    <th>Nilai DSS</th>
                    <th>Ranking</th>
                    <th>Prioritas</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($hasil) > 0): ?>
                    <?php $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
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
                        <td colspan="5" class="kosong">Belum ada data hasil prioritas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/analisisDSS.blade.php ENDPATH**/ ?>