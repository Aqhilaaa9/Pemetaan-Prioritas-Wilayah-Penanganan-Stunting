<header class="navbar">

    <button type="button" class="sidebar-toggle" data-sidebar-toggle aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu navigasi">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
            <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="user dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle user-menu-link" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-1">
                {{ Auth::check() ? (Auth::user()->username ?? 'Admin') : 'Admin' }}
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger fw-bold">
                        Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>

</header>