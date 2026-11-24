# 🌸 PGWEB 12 – WebGIS Kabupaten Sleman

WebGIS Kabupaten Sleman merupakan aplikasi Sistem Informasi Geografis berbasis web yang menyajikan informasi persebaran lokasi 17 kecamatan di Kabupaten Sleman. Aplikasi ini dikembangkan menggunakan PHP, MySQL, Leaflet JS, dan GeoServer untuk menampilkan informasi geografis secara interaktif.

## 🔗 Link Akses

- **WebGIS:** http://localhost/Acara12/index.php
- **Database (phpMyAdmin):** http://localhost/phpmyadmin/
- **GeoServer:** http://localhost:8080/geoserver
- **Folder Proyek:** `C:\xampp\htdocs\Acara12`

> Catatan: Link localhost hanya dapat diakses ketika server XAMPP dan GeoServer berjalan pada komputer yang digunakan.

## ✨ Fitur WebGIS

- Menampilkan peta interaktif Kabupaten Sleman.
- Menampilkan 17 titik lokasi kecamatan.
- Menyediakan tabel informasi kecamatan.
- Menampilkan detail lokasi melalui tombol **Lihat**.
- Menampilkan informasi kecamatan melalui popup pada peta.
- Menyediakan pilihan basemap OpenStreetMap dan Esri Satellite.
- Menampilkan layer tambahan dari GeoServer, meliputi batas administrasi desa, jaringan jalan, dan lokasi rumah sakit.

## 🛠️ Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| HTML & CSS | Struktur dan desain halaman web |
| PHP | Mengolah dan menampilkan data |
| MySQL | Menyimpan data kecamatan |
| Leaflet JS | Menampilkan peta interaktif |
| GeoServer | Menyediakan layanan data spasial |
| Bootstrap | Membantu pengaturan tampilan antarmuka |

## 📂 Struktur Folder

```text
Acara12/
├── index.php
├── data_kecamatan.php
└── README.md
```

## 🚀 Cara Menjalankan

1. Aktifkan Apache dan MySQL melalui XAMPP.
2. Pastikan GeoServer telah dijalankan.
3. Pastikan database `latihan` dan tabel `penduduk` telah tersedia.
4. Simpan folder proyek di direktori `C:\xampp\htdocs\Acara12`.
5. Buka WebGIS melalui browser dengan mengakses:

   `http://localhost/Acara12/index.php`

## 🗺️ Hasil Akhir

WebGIS Kabupaten Sleman menampilkan persebaran lokasi 17 kecamatan dalam bentuk peta interaktif yang terintegrasi dengan tabel informasi. Pengguna dapat melihat detail setiap kecamatan melalui marker pada peta maupun tombol **Lihat** pada tabel.

---

**PGWEB 12 | WebGIS Kabupaten Sleman**  
Dikembangkan sebagai bagian dari kegiatan pembelajaran Praktik Geografi Web.