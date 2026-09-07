  <!-- SIDEBAR -->

    <aside class="sidebar">

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
