  <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="logo">

            <img src="<?php echo e(asset('images/Logo Bru.png')); ?>" alt="Logo SIPENTA">

            <h2>SIPENTA</h2>
            <p class="logo-subtitle">Sistem Informasi Pemetaan dan Prioritas Penanganan Stunting</p>

        </div>

        <!-- MENU -->
        <ul class="menu">

            <li class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('dashboard')); ?>">
                    <img src="<?php echo e(asset('images/icon/dashboard.png')); ?>" class="menu-icon">
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="<?php echo e(request()->routeIs('pemetaan') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('pemetaan')); ?>">
                    <img src="<?php echo e(asset('images/icon/pemetaan.png')); ?>" class="menu-icon">
                    <span>Pemetaan</span>
                </a>
            </li>

            <li class="<?php echo e(request()->routeIs('prioritas') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('prioritas')); ?>">
                    <img src="<?php echo e(asset('images/icon/prioritas penanganan.png')); ?>" class="menu-icon">
                    <span>Prioritas Penanganan</span>
                </a>
            </li>

            <?php if(auth()->user() && auth()->user()->role === 'admin'): ?>
            <li class="<?php echo e(request()->routeIs('dataStunting*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('dataStunting')); ?>">
                    <img src="<?php echo e(asset('images/icon/data stunting.png')); ?>" class="menu-icon">
                    <span>Data Stunting</span>
                </a>
            </li>
            <?php endif; ?>

            <li class="<?php echo e(request()->routeIs('analisisDSS') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('analisisDSS')); ?>">
                  <img src="<?php echo e(asset('images/icon/analisis dss.png')); ?>" class="menu-icon">
                    <span>Analisis DSS</span>
                </a>
            </li>

            <?php if(auth()->user() && auth()->user()->role === 'admin'): ?>
            <?php
                $pendingCount = \App\Models\User::where('status', 'pending')->count();
            ?>
            <li class ="<?php echo e(request()->routeIs('dataPengguna*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('dataPengguna')); ?>" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="<?php echo e(asset('images/icon/pengguna.png')); ?>" class="menu-icon">
                        <span>Data Pengguna</span>
                    </div>
                    <?php if($pendingCount > 0): ?>
                        <span style="background: #e63946; color: white; font-size: 11px; font-weight: bold; padding: 2px 7px; border-radius: 10px;"><?php echo e($pendingCount); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php endif; ?>

        </ul>


    </aside>
<?php /**PATH C:\xampp\htdocs\Stunting\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>