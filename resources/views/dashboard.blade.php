<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <title>Dashboard | SIPENTA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

</head>

<body>

<div class="wrapper">

    @include('layouts.sidebar')

    <!-- MAIN -->
    <main class="main">

        @include('layouts.navbar')

        <section class="content">

            <!-- HEADER & TAHUN FILTER -->
            <div class="dashboard-header-row">
                <h1 class="dashboard-title">Dashboard</h1>

                <div class="tahun-filter">
                    <form method="GET" action="{{ route('dashboard') }}" id="tahunForm">
                        <select name="tahun" onchange="this.form.submit()">
                            <option value="" {{ empty($tahunSelected) ? 'selected' : '' }}>Semua Tahun</option>
                            @if(isset($tahunList) && count($tahunList) > 0)
                                @foreach($tahunList as $th)
                                    <option value="{{ $th }}" {{ ($tahunSelected == $th) ? 'selected' : '' }}>
                                        Tahun {{ $th }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </form>
                </div>
            </div>

            <!-- 1. STATS CARDS -->
            <div class="top-card">
                <div class="card-dashboard">
                    <h4>Jumlah Balita :</h4>
                    <div class="jumlah">
                        {{ number_format($jumlahBalita ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="card-dashboard">
                    <h4>Jumlah Balita Stunting :</h4>
                    <div class="jumlah">
                        {{ number_format($jumlahStunting ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- 2. MIDDLE (DONUT CHART & PERSENTASE KABUPATEN) -->
            <div class="dashboard-middle">
            <h2 class="section-title">
                Diagram Data Stunting Di Pulau Lombok
            </h2>
                <!-- Donut Chart -->
                <div class="chart-column">
                    <div class="chart-wrapper">
                        <canvas id="stuntingChart"></canvas>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item"><span class="dot red"></span> Tinggi</div>
                        <div class="legend-item"><span class="dot yellow"></span> Sedang</div>
                        <div class="legend-item"><span class="dot green"></span> Rendah</div>
                    </div>
                </div>

                <!-- Persentase Kabupaten (Data Real Hasil Input User) -->
                <div class="persentase-card">
                    @if(isset($kabupatenData) && count($kabupatenData) > 0)
                        @foreach($kabupatenData as $index => $kab)
                            @php
                                $colorClass = $kab['kategori'] ?? 'kuning';
                                if ($loop->last && count($kabupatenData) % 2 != 0) {
                                    $colorClass .= ' full-width';
                                }
                            @endphp
                            <div class="persen {{ $colorClass }}">
                                <h2>{{ number_format($kab['persentase'], 1) }}%</h2>
                                <p>{{ $kab['nama'] }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="persen kuning full-width">
                            <h2>0%</h2>
                            <p>Belum Ada Data Stunting</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- 3. SECTION PRIORITAS -->
            <h2 class="section-title">
                Prioritas Utama Penanganan Stunting Di Pulau Lombok
            </h2>

            <div class="bottom-grid">
                <!-- CARD KIRI: PRIORITAS UTAMA (Data Real) -->
                <div class="bottom-card">
                    <h3>Prioritas</h3>

                    @if(isset($prioritasUtama) && $prioritasUtama)
                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/peta prioritas.png') }}" alt="Wilayah" width="42">
                            <span>Wilayah : {{ $prioritasUtama['puskesmas'] ?? ($prioritasUtama['kabupaten'] ?? '-') }}</span>
                        </div>

                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/status.png') }}" alt="Status" width="42">
                            <span>Status : {{ $prioritasUtama['prioritas'] ?? '-' }}</span>
                        </div>

                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/persen.png') }}" alt="Persen" width="42">
                            <span>Nilai DSSS : {{ number_format($prioritasUtama['nilai_dss'] ?? 0, 2) }}</span>
                        </div>
                    @else
                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/peta prioritas.png') }}" alt="Wilayah" width="42">
                            <span>Wilayah : Belum ada data</span>
                        </div>

                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/status.png') }}" alt="Status" width="42">
                            <span>Status : -</span>
                        </div>

                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/persen.png') }}" alt="Persen" width="42">
                            <span>Nilai DSSS : 0</span>
                        </div>
                    @endif
                </div>

                <!-- CARD KANAN: TOP 3 WILAYAH (Data Real) -->
                <div class="bottom-card">
                    <h3>Top 3 Wilayah</h3>

                    @if(isset($top3Prioritas) && count($top3Prioritas) > 0)
                        @foreach($top3Prioritas as $rankIndex => $item)
                            <div class="ranking-item">
                                <img src="{{ asset('images/icon/ranking ' . ($rankIndex + 1) . '.png') }}" alt="Rank {{ $rankIndex + 1 }}" width="42">
                                <span>{{ $item['puskesmas'] ?? ($item['kabupaten'] ?? '-') }}</span>
                            </div>
                        @endforeach
                        @for($r = count($top3Prioritas); $r < 3; $r++)
                            <div class="ranking-item">
                                <img src="{{ asset('images/icon/ranking ' . ($r + 1) . '.png') }}" alt="Rank {{ $r + 1 }}" width="42">
                                <span>Belum ada data</span>
                            </div>
                        @endfor
                    @else
                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/ranking 1.png') }}" alt="Rank 1" width="42">
                            <span>Belum ada data</span>
                        </div>

                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/ranking 2.png') }}" alt="Rank 2" width="42">
                            <span>Belum ada data</span>
                        </div>

                        <div class="ranking-item">
                            <img src="{{ asset('images/icon/ranking 3.png') }}" alt="Rank 3" width="42">
                            <span>Belum ada data</span>
                        </div>
                    @endif
                </div>
            </div>

        </section>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('stuntingChart');
    if (ctx) {
        Chart.register(ChartDataLabels);

        const tinggiVal = {{ $chartData['tinggi'] ?? 0 }};
        const sedangVal = {{ $chartData['sedang'] ?? 0 }};
        const rendahVal = {{ $chartData['rendah'] ?? 0 }};

        const hasData = (tinggiVal + sedangVal + rendahVal) > 0;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Tinggi', 'Sedang', 'Rendah'],
                datasets: [{
                    data: hasData ? [tinggiVal, sedangVal, rendahVal] : [0, 0, 100],
                    backgroundColor: hasData ? [
                        '#ff3131', // Merah - Tinggi
                        '#fff000', // Kuning - Sedang
                        '#b7f57a'  // Hijau Muda - Rendah
                    ] : ['#e2e8f0', '#e2e8f0', '#e2e8f0'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        color: '#000000',
                        font: {
                            family: 'Poppins',
                            weight: 'bold',
                            size: 13
                        },
                        formatter: (value) => {
                            return (hasData && value > 0) ? value + '%' : '';
                        }
                    }
                }
            }
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>