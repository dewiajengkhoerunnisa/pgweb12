<?php
// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "latihan");

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset("utf8mb4");

// Mengambil data kecamatan
$sql = "SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk
        FROM penduduk
        ORDER BY kecamatan ASC";

$result = $koneksi->query($sql);

$dataKecamatan = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dataKecamatan[] = [
            "kecamatan" => $row["kecamatan"],
            "longitude" => (float) $row["longitude"],
            "latitude" => (float) $row["latitude"],
            "luas" => (float) $row["luas"],
            "jumlah_penduduk" => (int) $row["jumlah_penduduk"]
        ];
    }
}

$koneksi->close();

$dataJson = json_encode(
    $dataKecamatan,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WebGIS Kabupaten Sleman - Acara 12</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #fff5f8;
            font-family: Arial, sans-serif;
            color: #444;
        }

        /* NAVBAR */
        .navbar {
            background-color: #d96b91;
            min-height: 52px;
            padding: 6px 0;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 18px;
        }

        /* JUDUL */
        .judul {
            color: #bd527b;
            font-weight: bold;
        }

        /* PETA */
        .map-container {
            height: 55vh;
            min-height: 380px;
            width: 100%;
            border: 3px solid #f1c3d3;
            border-radius: 12px;
            overflow: hidden;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* TABEL */
        .table-container {
            height: 37vh;
            min-height: 250px;
            overflow: auto;
            background-color: white;
            border: 2px solid #f1c3d3;
            border-radius: 10px;
        }

        .table {
            margin-bottom: 0;
            font-size: 12px;
        }

        .table thead th {
            background-color: #f5c3d3;
            color: #71364d;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 2;
            padding: 7px 9px;
        }

        .table tbody td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            padding: 4px 9px;
            line-height: 1.2;
        }

        .table tbody tr:hover {
            background-color: #fff0f5;
        }

        /* TOMBOL LIHAT */
        .btn-lokasi {
            background-color: #dc7298;
            color: white;
            border: none;
            padding: 3px 9px;
            border-radius: 6px;
            font-size: 11px;
        }

        .btn-lokasi:hover {
            background-color: #bd527b;
            color: white;
        }

        /* JUDUL TABEL */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #bd527b;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            padding: 8px;
            color: #8d5269;
            font-size: 12px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .map-container {
                height: 55vh;
                min-height: 330px;
            }

            .table-container {
                height: 37vh;
                min-height: 220px;
            }

            .table {
                font-size: 11px;
            }

            .table thead th {
                padding: 6px;
            }

            .table tbody td {
                padding: 4px 6px;
            }

            .navbar-brand {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="index.php">
                <i class="fa-solid fa-map-location-dot"></i>
                WebGIS Kabupaten Sleman
            </a>
        </div>
    </nav>

    <main class="container-fluid px-3 py-2">

        <!-- JUDUL PETA -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h5 class="judul mb-0">
                    Peta Administrasi Kabupaten Sleman
                </h5>

                <small class="text-muted">
                    Peta persebaran titik kecamatan
                </small>
            </div>
        </div>

        <!-- PETA UTAMA -->
        <div class="map-container mb-3">
            <div id="map"></div>
        </div>

        <!-- JUDUL TABEL -->
        <div class="d-flex justify-content-between align-items-center mb-2">

            <div class="section-title">
                <i class="fa-solid fa-table-list"></i>
                Data Kecamatan Kabupaten Sleman
            </div>

            <span class="badge rounded-pill" style="background-color:#d96b91;">
                <?= count($dataKecamatan) ?> Kecamatan
            </span>

        </div>

        <!-- TABEL DATA KECAMATAN -->
        <div class="table-container">

            <table class="table table-bordered table-striped table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Luas Area (km²)</th>
                        <th>Jumlah Penduduk (jiwa)</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($dataKecamatan) > 0): ?>

                        <?php foreach ($dataKecamatan as $index => $kecamatan): ?>

                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <?= htmlspecialchars($kecamatan["kecamatan"]) ?>
                                </td>

                                <td><?= $kecamatan["longitude"] ?></td>

                                <td><?= $kecamatan["latitude"] ?></td>

                                <td>
                                    <?= number_format($kecamatan["luas"], 2, ",", ".") ?>
                                </td>

                                <td>
                                    <?= number_format($kecamatan["jumlah_penduduk"], 0, ",", ".") ?>
                                </td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-lokasi tombol-lokasi"
                                        data-index="<?= $index ?>">

                                        <i class="fa-solid fa-location-dot"></i>
                                        Lihat

                                    </button>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7">
                                Data kecamatan belum tersedia.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            WebGIS Kabupaten Sleman | PGWEB Acara 12
        </div>

    </main>

    <!-- LEAFLET JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Data kecamatan dari PHP dan MySQL
        const dataKecamatan = <?= $dataJson ?: '[]' ?>;

        // Membuat peta utama
        const map = L.map('map').setView(
            [-7.715, 110.35],
            11
        );

        // Basemap OpenStreetMap
        const osm = L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }
        ).addTo(map);

        // Basemap Esri Satellite
        const esri = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            {
                attribution: 'Tiles &copy; Esri',
                maxZoom: 19
            }
        );

        // Layer administrasi desa GeoServer
        const administrasiDesa = L.tileLayer.wms(
            'http://localhost:8080/geoserver/wms',
            {
                layers: 'pgweb11:ADMINISTRASIDESA_AR_25K',
                format: 'image/png',
                transparent: true,
                version: '1.1.0'
            }
        );

        // Layer jalan GeoServer
        const jalan = L.tileLayer.wms(
            'http://localhost:8080/geoserver/wms',
            {
                layers: 'pgweb11:jalan',
                format: 'image/png',
                transparent: true,
                version: '1.1.0'
            }
        );

        // Layer rumah sakit GeoServer
        const rumahSakit = L.tileLayer.wms(
            'http://localhost:8080/geoserver/wms',
            {
                layers: 'pgweb11:RUMAHSAKIT_PT_25K',
                format: 'image/png',
                transparent: true,
                version: '1.1.0'
            }
        );

        // Pengaturan basemap
        const baseMaps = {
            "OpenStreetMap": osm,
            "Esri Satellite": esri
        };

        // Pengaturan overlay
        const overlayMaps = {
            "Administrasi Desa": administrasiDesa,
            "Jalan": jalan,
            "Rumah Sakit": rumahSakit
        };

        L.control.layers(baseMaps, overlayMaps, {
            collapsed: false
        }).addTo(map);

        // Menampung marker seluruh kecamatan
        const markerKecamatan = [];

        // Membuat marker setiap kecamatan
        dataKecamatan.forEach(function(data, index) {

            const marker = L.circleMarker(
                [data.latitude, data.longitude],
                {
                    radius: 7,
                    color: '#b83268',
                    weight: 2,
                    fillColor: '#f08bb0',
                    fillOpacity: 0.9
                }
            ).addTo(map);

            // Informasi popup
            marker.bindPopup(`
                <div style="min-width:190px;">
                    <h6 style="color:#bd527b; font-weight:bold;">
                        ${data.kecamatan}
                    </h6>

                    <b>Luas Area:</b> ${data.luas} km²<br>

                    <b>Jumlah Penduduk:</b>
                    ${Number(data.jumlah_penduduk).toLocaleString('id-ID')} jiwa<br>

                    <b>Latitude:</b> ${data.latitude}<br>

                    <b>Longitude:</b> ${data.longitude}
                </div>
            `);

            markerKecamatan[index] = marker;

        });

        // Menampilkan seluruh titik kecamatan
        if (markerKecamatan.length > 0) {

            const semuaTitik = L.featureGroup(markerKecamatan);

            map.fitBounds(semuaTitik.getBounds(), {
                padding: [30, 30]
            });

        }

        // Tombol Lihat pada tabel
        document.querySelectorAll('.tombol-lokasi').forEach(function(tombol) {

            tombol.addEventListener('click', function() {

                const index = Number(this.dataset.index);

                const data = dataKecamatan[index];

                if (!data || !markerKecamatan[index]) {
                    return;
                }

                // Mengarahkan peta ke kecamatan terpilih
                map.flyTo(
                    [data.latitude, data.longitude],
                    14,
                    {
                        animate: true,
                        duration: 1.5
                    }
                );

                // Membuka popup kecamatan
                markerKecamatan[index].openPopup();

            });

        });

    </script>

</body>
</html>