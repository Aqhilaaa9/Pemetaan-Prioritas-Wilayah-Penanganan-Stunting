<header class="navbar">

    <div></div>

    <div class="user dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle user-menu-link" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-1">
                <?php echo e(Auth::check() ? (Auth::user()->username ?? 'Admin') : 'Admin'); ?>

            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
            <li>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="dropdown-item text-danger fw-bold">
                        Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>

</header><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>