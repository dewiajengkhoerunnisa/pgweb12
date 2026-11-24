<?php

header("Content-Type: application/json; charset=UTF-8");

// Koneksi database MySQL
$koneksi = new mysqli("localhost", "root", "", "latihan");

// Memeriksa koneksi database
if ($koneksi->connect_error) {
    http_response_code(500);

    echo json_encode([
        "status" => "error",
        "pesan" => "Koneksi database gagal"
    ]);

    exit;
}

// Mengambil data kecamatan
$sql = "SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk
        FROM penduduk
        ORDER BY kecamatan ASC";

$result = $koneksi->query($sql);

// Menyiapkan data
$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "kecamatan" => $row["kecamatan"],
            "longitude" => (float) $row["longitude"],
            "latitude" => (float) $row["latitude"],
            "luas" => (float) $row["luas"],
            "jumlah_penduduk" => (int) $row["jumlah_penduduk"]
        ];
    }
}

// Mengirim data dalam format JSON
echo json_encode([
    "status" => "success",
    "data" => $data
]);

$koneksi->close();

?>