@extends('layouts.app')

@section('title', 'Pemetaan Stunting')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/pemetaan.css') }}">
@endpush

@section('content')

<div class="pemetaan-wrapper">
    <div class="pemetaan-container">

        <!-- ================= HEADER ================= -->
        <div class="pemetaan-header">
            <div class="header-title-container">
                <h1 class="pemetaan-title">
                    Pemetaan Stunting Di Setiap Wilayah Di Pulau Lombok{{ $tahunSelected ? ' ' . $tahunSelected : '' }}
                </h1>
            </div>

            <!-- FILTER TAHUN -->
            <form action="{{ route('pemetaan') }}" method="GET">
                <select name="tahun" onchange="this.form.submit()" class="tahun-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ $tahunSelected == $tahun ? 'selected' : '' }}>
                            Tahun {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- ================= PETA ================= -->
        <div id="map"></div>

        <!-- ================= LEGENDA ================= -->
        <div class="legend-container">
            <div class="legend-item">
                <span class="legend-dot tinggi"></span>
                <span>Tinggi</span>
            </div>

            <div class="legend-item">
                <span class="legend-dot sedang"></span>
                <span>Sedang</span>
            </div>

            <div class="legend-item">
                <span class="legend-dot rendah"></span>
                <span>Rendah</span>
            </div>

            <div class="legend-item">
                <img src="{{ asset('images/icon/titik lokasi.png') }}" class="legend-pin-icon" alt="Pin Puskesmas">
                <span>Titik Lokasi Puskesmas</span>
            </div>
        </div>

    </div>

</div>

<!-- ================= DATA DARI LARAVEL ================= -->
<script>
    const dataPeta = @json($dataPeta);
    const dataPuskesmas = @json($dataPuskesmas);
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Center coordinates for Lombok island
    const map = L.map('map', {
        zoomControl: true,
        attributionControl: false,
        scrollWheelZoom: true,
        dragging: true
    }).setView([-8.60, 116.30], 10);

    // Standard high quality tile layer with clean opacity
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}{r}.png', {
        maxZoom: 18,
        subdomains: 'abcd',
    }).addTo(map);

    // Function to format numbers in Indonesian standard (112.563)
    function formatNumber(num) {
        if (num === null || num === undefined) return '0';
        return new Intl.NumberFormat('id-ID').format(num);
    }

    // Function to render Kabupaten Popup Card
    function openKabupatenPopup(latlng, data) {
        const popupContent = `
            <div class="popup-card">
                <div class="popup-header">
                    <img src="{{ asset('images/icon/peta prioritas.png') }}" class="popup-icon" alt="Wilayah Icon">
                    <div>
                        <h2 class="popup-title">${data.nama}</h2>
                        <div class="popup-badge">Wilayah Kabupaten/Kota</div>
                    </div>
                </div>
                <div class="popup-details">
                    <div class="popup-row">
                        <strong>Presentase Stunting :</strong> ${data.persentase}%
                    </div>
                    <div class="popup-row">
                        <strong>Jumlah Balita Diukur :</strong> ${formatNumber(data.jumlah_balita)} balita
                    </div>
                    <div class="popup-row">
                        <strong>Jumlah Balita Stunting :</strong> ${formatNumber(data.jumlah_stunting)} balita
                    </div>
                    <div class="popup-row">
                        <strong>Bayi BBLR :</strong> ${formatNumber(data.jumlah_bblr)} bayi
                    </div>
                    <div class="popup-row">
                        <strong>ASI Eksklusif :</strong> ${formatNumber(data.persentase_asi)}%
                    </div>
                    <div class="popup-row">
                        <strong>Presentase Pelayanan :</strong> ${data.persentase_pelayanan}%
                    </div>
                    <div class="popup-row">
                        <strong>Nilai DSS :</strong> ${data.nilai_dss}
                    </div>
                    <div class="popup-row">
                        <strong>Status Prioritas :</strong> <span class="status-tag status-${(data.status || 'rendah').toLowerCase()}">${data.status}</span>
                    </div>
                </div>
            </div>
        `;

        L.popup({
            offset: [0, -10],
            closeButton: true,
            className: 'stunting-popup-modal'
        })
        .setLatLng(latlng)
        .setContent(popupContent)
        .openOn(map);
    }

    // Function to render Puskesmas Popup Card
    function openPuskesmasPopup(latlng, pkm) {
        const popupContent = `
            <div class="popup-card puskesmas-card">
                <div class="popup-header">
                    <img src="{{ asset('images/icon/titik lokasi.png') }}" class="popup-icon puskesmas-icon" alt="Puskesmas Icon">
                    <div>
                        <h2 class="popup-title">${pkm.nama}</h2>
                        <div class="popup-subtitle">${pkm.kabupaten}</div>
                    </div>
                </div>
                <div class="popup-details">
                    <div class="popup-row highlight-row">
                        <strong>Presentase Stunting :</strong> <span class="badge-persen" style="background:${pkm.warna}; color:${pkm.warna === '#fff000' ? '#222' : '#fff'};">${pkm.persentase}%</span>
                    </div>
                    <div class="popup-row">
                        <strong>Jumlah Balita Diukur :</strong> ${formatNumber(pkm.jumlah_balita)} balita
                    </div>
                    <div class="popup-row">
                        <strong>Jumlah Balita Stunting :</strong> ${formatNumber(pkm.jumlah_stunting)} balita
                    </div>
                    <div class="popup-row">
                        <strong>Bayi BBLR :</strong> ${formatNumber(pkm.jumlah_bblr)} bayi
                    </div>
                    <div class="popup-row">
                        <strong>ASI Eksklusif :</strong> ${formatNumber(pkm.persentase_asi)}%
                    </div>
                    <div class="popup-row">
                        <strong>Presentase Pelayanan :</strong> ${pkm.persentase_pelayanan}%
                    </div>
                    <div class="popup-row">
                        <strong>Nilai DSS :</strong> ${pkm.nilai_dss}
                    </div>
                    <div class="popup-row">
                        <strong>Status Prioritas :</strong> <span class="status-tag status-${(pkm.status || 'rendah').toLowerCase()}">${pkm.status}</span>
                    </div>
                </div>
            </div>
        `;

        L.popup({
            offset: [0, -20],
            closeButton: true,
            className: 'stunting-popup-modal'
        })
        .setLatLng(latlng)
        .setContent(popupContent)
        .openOn(map);
    }

    // Load GeoJSON Lombok
    fetch('/geojson/lombok.geojson')
        .then(response => response.json())
        .then(geojson => {

            const geoLayer = L.geoJSON(geojson, {

                style: function(feature) {
                    const namaWilayah = feature.properties.nama_kabupaten;
                    const data = dataPeta.find(item =>
                        item.nama.toLowerCase().trim() === namaWilayah.toLowerCase().trim()
                    );

                    return {
                        fillColor: data ? data.warna : '#ffff00',
                        weight: 1.5,
                        color: '#222222',
                        fillOpacity: 0.85
                    };
                },

                onEachFeature: function(feature, layer) {
                    const namaWilayah = feature.properties.nama_kabupaten;
                    const data = dataPeta.find(item =>
                        item.nama.toLowerCase().trim() === namaWilayah.toLowerCase().trim()
                    );

                    if (!data) return;

                    // Hover effects on region
                    layer.on({
                        mouseover: function(e) {
                            e.target.setStyle({
                                weight: 3,
                                color: '#000000',
                                fillOpacity: 0.95
                            });
                        },
                        mouseout: function(e) {
                            geoLayer.resetStyle(e.target);
                        },
                        click: function(e) {
                            openKabupatenPopup(e.latlng, data);
                        }
                    });

                    // Add Region Label in center of each Kabupaten
                    const center = layer.getBounds().getCenter();

                    const kabLabelHtml = `
                        <div class="kabupaten-label-box" title="Klik untuk info wilayah ${data.nama}">
                            <div class="kabupaten-label-name">${data.nama}</div>
                            <div class="kabupaten-label-persen">${data.persentase}%</div>
                        </div>
                    `;

                    const kabIcon = L.divIcon({
                        html: kabLabelHtml,
                        className: 'custom-kabupaten-marker',
                        iconSize: [130, 45],
                        iconAnchor: [65, 22]
                    });

                    const kabMarker = L.marker(center, { icon: kabIcon }).addTo(map);
                    kabMarker.on('click', function(e) {
                        openKabupatenPopup(center, data);
                    });
                }

            }).addTo(map);

            // Fit map bounds to Lombok island GeoJSON
            map.fitBounds(geoLayer.getBounds(), { padding: [20, 20] });

            // ===============================================
            // TAMBAHKAN TITIK LOKASI PUSKESMAS DARI DATA INPUT
            // ===============================================
            if (Array.isArray(dataPuskesmas) && dataPuskesmas.length > 0) {
                dataPuskesmas.forEach(pkm => {
                    if (!pkm.latitude || !pkm.longitude) return;

                    const pkmMarkerHtml = `
                        <div class="puskesmas-marker-container">
                            <div class="puskesmas-pin-wrapper">
                                <img src="{{ asset('images/icon/titik lokasi.png') }}" class="puskesmas-pin-img" alt="Pin">
                                <span class="puskesmas-status-dot" style="background-color: ${pkm.warna};"></span>
                            </div>
                            <div class="puskesmas-marker-card">
                                <div class="puskesmas-marker-title">${pkm.nama}</div>
                                <div class="puskesmas-marker-rate">${pkm.persentase}%</div>
                            </div>
                        </div>
                    `;

                    const pkmIcon = L.divIcon({
                        html: pkmMarkerHtml,
                        className: 'custom-puskesmas-marker',
                        iconSize: [110, 65],
                        iconAnchor: [55, 30]
                    });

                    const pkmMarker = L.marker([pkm.latitude, pkm.longitude], {
                        icon: pkmIcon,
                        zIndexOffset: 1000
                    }).addTo(map);

                    pkmMarker.on('click', function(e) {
                        L.DomEvent.stopPropagation(e);
                        openPuskesmasPopup([pkm.latitude, pkm.longitude], pkm);
                    });
                });
            }
        })
        .catch(err => {
            console.error("Gagal memuat geojson/lombok.geojson:", err);
        });

});
</script>

@endsection
