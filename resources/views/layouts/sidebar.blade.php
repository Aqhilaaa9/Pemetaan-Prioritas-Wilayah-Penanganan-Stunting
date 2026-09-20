  <!-- SIDEBAR -->

    <aside class="sidebar" id="sidebar">

        <button type="button" class="sidebar-close" data-sidebar-close aria-label="Tutup menu navigasi">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>

        <div class="logo">

            <img src="{{ asset('images/Logo Bru.png') }}" alt="Logo SIPENTA">

            <h2>SIPENTA</h2>
            <p class="logo-subtitle">Sistem Informasi Pemetaan dan Prioritas Penanganan Stunting</p>

        </div>

        <!-- MENU -->
        <ul class="menu">

            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/icon/dashboard.png') }}" class="menu-icon">
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('pemetaan') ? 'active' : '' }}">
                <a href="{{ route('pemetaan') }}">
                    <img src="{{ asset('images/icon/pemetaan.png') }}" class="menu-icon">
                    <span>Pemetaan</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('prioritas') ? 'active' : '' }}">
                <a href="{{ route('prioritas') }}">
                    <img src="{{ asset('images/icon/prioritas penanganan.png') }}" class="menu-icon">
                    <span>Prioritas Penanganan</span>
                </a>
            </li>

            @if(auth()->user() && auth()->user()->role === 'admin')
            <li class="{{ request()->routeIs('dataStunting*') ? 'active' : '' }}">
                <a href="{{ route('dataStunting') }}">
                    <img src="{{ asset('images/icon/data stunting.png') }}" class="menu-icon">
                    <span>Data Stunting</span>
                </a>
            </li>
            @endif

            <li class="{{ request()->routeIs('analisisDSS') ? 'active' : '' }}">
                <a href="{{ route('analisisDSS') }}">
                  <img src="{{ asset('images/icon/analisis dss.png') }}" class="menu-icon">
                    <span>Analisis DSS</span>
                </a>
            </li>

            @if(auth()->user() && auth()->user()->role === 'admin')
            @php
                $pendingCount = \App\Models\User::where('status', 'pending')->count();
            @endphp
            <li class ="{{ request()->routeIs('dataPengguna*') ? 'active' : '' }}">
                <a href="{{ route('dataPengguna') }}" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ asset('images/icon/pengguna.png') }}" class="menu-icon">
                        <span>Data Pengguna</span>
                    </div>
                    @if($pendingCount > 0)
                        <span style="background: #e63946; color: white; font-size: 11px; font-weight: bold; padding: 2px 7px; border-radius: 10px;">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            @endif

        </ul>


    </aside>

    <div class="sidebar-backdrop" data-sidebar-close></div>

    <script>
    (function () {
        var body = document.body;

        function setOpen(open) {
            body.classList.toggle('sidebar-open', open);
            document.querySelectorAll('[data-sidebar-toggle]').forEach(function (btn) {
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-sidebar-toggle]')) {
                setOpen(!body.classList.contains('sidebar-open'));
            } else if (e.target.closest('[data-sidebar-close]')) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });

        window.matchMedia('(min-width: 992px)').addEventListener('change', function (mq) {
            if (mq.matches) setOpen(false);
        });
    })();
    </script>
