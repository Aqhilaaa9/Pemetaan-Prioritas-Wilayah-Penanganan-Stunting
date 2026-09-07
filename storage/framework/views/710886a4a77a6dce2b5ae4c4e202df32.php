

<?php $__env->startSection('title', 'Pemetaan Stunting'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="<?php echo e(asset('css/pemetaan.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="pemetaan-wrapper">
    <div class="pemetaan-container">

        <!-- ================= HEADER ================= -->
        <div class="pemetaan-header">
            <div class="header-title-container">
                <h1 class="pemetaan-title">
                    Pemetaan Stunting Di Setiap Wilayah<br>Di Pulau Lombok<?php echo e($tahunSelected ? ' ' . $tahunSelected : ''); ?>

                </h1>
            </div>

            <!-- FILTER TAHUN -->
            <form action="<?php echo e(route('pemetaan')); ?>" method="GET">
                <select name="tahun" onchange="this.form.submit()" class="tahun-select">
                    <option value="">Semua Tahun</option>
                    <?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tahun); ?>" <?php echo e($tahunSelected == $tahun ? 'selected' : ''); ?>>
                            Tahun <?php echo e($tahun); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        </div>

    </div>

    <!-- ================= BOTTOM GRADIENT BANNER ================= -->
    <div class="pemetaan-bottom-banner"></div>
</div>

<!-- ================= DATA DARI LARAVEL ================= -->
<script>
    const dataPeta = <?php echo json_encode($dataPeta, 15, 512) ?>;
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Center coordinates for Lombok island
    const map = L.map('map', {
        zoomControl: false,
        attributionControl: false,
        scrollWheelZoom: true,
        dragging: true
    }).setView([-8.60, 116.30], 10);

    // Standard high quality tile layer with clean opacity
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}{r}.png', {
        maxZoom: 18,
        subdomains: 'abcd',
    }).addTo(map);

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
                        fillOpacity: 0.95
                    };
                },

                onEachFeature: function(feature, layer) {
                    const namaWilayah = feature.properties.nama_kabupaten;
                    const data = dataPeta.find(item =>
                        item.nama.toLowerCase().trim() === namaWilayah.toLowerCase().trim()
                    );

                    if (!data) return;

                    // Hover effects
                    layer.on({
                        mouseover: function(e) {
                            e.target.setStyle({
                                weight: 3,
                                color: '#000000',
                                fillOpacity: 1.0
                            });
                        },
                        mouseout: function(e) {
                            geoLayer.resetStyle(e.target);
                        },
                        click: function(e) {
                            openStuntingPopup(e.latlng, data);
                        }
                    });

                    // Add Custom Marker Pin + Label on center of each region
                    const center = layer.getBounds().getCenter();

                    const markerHtml = `
                        <div class="marker-content">
                            <img src="<?php echo e(asset('images/icon/titik lokasi.png')); ?>" class="marker-pin" alt="Pin">
                            <div class="marker-text">
                                <div class="marker-name">${data.nama}</div>
                                <div class="marker-persen">${data.persentase}%</div>
                            </div>
                        </div>
                    `;

                    const customIcon = L.divIcon({
                        html: markerHtml,
                        className: 'custom-map-marker',
                        iconSize: [120, 75],
                        iconAnchor: [60, 25]
                    });

                    const marker = L.marker(center, { icon: customIcon }).addTo(map);
                    marker.on('click', function(e) {
                        openStuntingPopup(center, data);
                    });
                }

            }).addTo(map);

            // Fit map bounds to Lombok island GeoJSON
            map.fitBounds(geoLayer.getBounds(), { padding: [20, 20] });
        })
        .catch(err => {
            console.error("Gagal memuat geojson/lombok.geojson:", err);
        });

    // Function to format numbers in Indonesian standard (112.563)
    function formatNumber(num) {
        if (num === null || num === undefined) return '0';
        return new Intl.NumberFormat('id-ID').format(num);
    }

    // Function to render Image 2 Teal Popup Card
    function openStuntingPopup(latlng, data) {
        const popupContent = `
            <div class="popup-card">
                <div class="popup-header">
                    <img src="<?php echo e(asset('images/icon/peta prioritas.png')); ?>" class="popup-icon" alt="Wilayah Icon">
                    <h2 class="popup-title">${data.nama}</h2>
                </div>
                <div class="popup-details">
                    <div class="popup-row">
                        Presentase stunting : ${data.persentase}%
                    </div>
                    <div class="popup-row">
                        Bayi BBLR : ${formatNumber(data.jumlah_bblr)} bayi
                    </div>
                    <div class="popup-row">
                        Asi : ${formatNumber(data.persentase_asi)}
                    </div>
                    <div class="popup-row">
                        Jumlah Balita yang Diukur : ${formatNumber(data.jumlah_balita)} balita
                    </div>
                    <div class="popup-row">
                        Presentase Pelayanan : ${data.persentase_pelayanan}%
                    </div>
                    <div class="popup-row">
                        Nilai DSS : ${data.nilai_dss}
                    </div>
                    <div class="popup-row">
                        Status Prioritas : ${data.status}
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

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Stunting\resources\views/pemetaan.blade.php ENDPATH**/ ?>