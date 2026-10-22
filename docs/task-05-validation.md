# Task 05 — Beranda, katalog, dan detail bazar

Tanggal pemeriksaan: 22 Oktober 2026 (WIB).

## Alur yang tersedia

- Beranda pengunjung atau skenario profil belum lengkap menampilkan tiga Bazar Mendatang menurut tanggal/ID. Pengguna contoh dengan profil lengkap melihat maksimal tiga pilihan berbeda, dengan dua alasan singkat. Pilihan tidak diisi ulang dari bazar yang tidak cocok ketika hasil kurang dari tiga.
- Menu Coba jumlah pilihan pada Beranda pengguna menyediakan 0, 1, 2, 3, dan 5 kandidat (tetap maksimal tiga tampil), serta profil belum lengkap. Skenario hanya membatasi kandidat yang sesuai; fixture default menyediakan lima kandidat sesuai.
- Katalog `/events` memuat enam bazar aktif contoh. Nama/tempat, tanggal, jenis produk, batas sewa, jarak, dan fasilitas dapat disaring tanpa permintaan server. Hapus filter tidak mengubah profil usaha.
- Informasi yang diperlukan filter tetapi belum diketahui masuk kelompok Perlu ditanyakan. Ketidakcocokan pasti mengalahkan informasi yang belum diketahui. Draf, dibatalkan, ditarik, dan berakhir tidak masuk katalog aktif.
- Lihat Bazar membuka `/events/{id}`. Detail memperlihatkan hari wajib, harga paket, biaya wajib, status pendaftaran dan kontak contoh. Informasi Lainnya memuat fasilitas, kategori, penyelenggara, sumber, pemeriksaan, tenggat, dan tarif per tanggal jika bervariasi.
- Detail pengguna yang cocok menyediakan rincian Alasan pilihan. Tidak ada skor, likes/views, atau janji omzet.
- Pemeriksaan lebih dari tujuh hari atau belum tersedia memunculkan ajakan konfirmasi. Laporkan Informasi memerlukan alasan dan hanya menampilkan simulasi antrean admin; tidak mengirim laporan atau mengubah bazar.

## Ketentuan contoh

Acuan fixture adalah **1 November 2026 WIB**, bukan tanggal sistem. Data tambahan T05 berada di `resources/fixtures/browse.php`; fixture admin lama tetap terpisah. Gratis adalah penawaran eksplisit. Paket Rp100.000/3 hari dibandingkan terhadap batas harian × 3 sebelum pembulatan tampilan Rp33.334. Tarif bervariasi menggunakan tarif tertinggi. Sewa dan biaya wajib selalu dipisahkan.

Lokasi asal tetap nama daerah tanpa isian lintang/bujur. Pemetaan contoh tersedia untuk Coblong, Bandung; Dago, Bandung; dan Braga, Bandung. Nama lain tidak diterjemahkan menjadi koordinat rekaan: hasil jarak menjadi belum pasti. Jarak Haversine adalah garis lurus, memakai nilai mentah untuk filter dan satu desimal untuk tampilan. Ini belum layanan geocoding.

Penawaran satu hari dapat cocok bila ada satu tanggal tersedia yang beririsan; paket dan tarif dengan seluruh periode wajib harus tercakup seluruhnya. Kandidat personal memerlukan kategori, tanggal, jarak, sewa, fasilitas, dan pendaftaran terbuka. Urutan lokal deterministik menggunakan faktor desain yang memiliki bukti fixture; kisaran harga sasaran pembeli belum tersedia sehingga tidak menambah nilai. Urutan ini masih demonstrasi frontend, bukan implementasi layanan rekomendasi backend.

Tanpa JavaScript, katalog dan detail tetap dapat dibaca; Beranda menampilkan tiga contoh umum. Filter, pilihan personal, kontak dialog dan laporan membutuhkan JavaScript. Kontak yang tersedia hanya alamat rekaan dalam dialog, tanpa pesan keluar. Sumber fixture adalah catatan contoh; tautan sumber nyata belum tersedia.

## Pemeriksaan

| Pemeriksaan | Hasil |
|---|---|
| `npm run build` | Lulus |
| `composer test` | 23 tes, 159 assertion lulus |
| `php vendor/bin/pint --test` | Lulus |
| `npm run test:browser` | 39 tes lulus pada viewport 360/768/1280 |
| Jumlah Beranda | 0/1/2/3/5 kandidat, maksimal tiga, dua alasan, fallback profil belum lengkap |
| Filter | Gratis vs kosong/unknown, kategori tidak cocok mengalahkan unknown, fasilitas, tanggal terbalik, lokasi tidak dikenali |
| Harga batas | Rp33.333 vs Rp33.334 untuk paket; Rp139.999 vs Rp140.000 untuk tarif tertinggi |
| Profil | Perubahan sewa menjadi nol menghasilkan satu pilihan gratis di Beranda |
| Detail | Paket/biaya wajib terlihat, sumber terbuka, kontak contoh, peringatan pemeriksaan lama |
| Laporan | Alasan wajib, fokus pada input kosong, tanpa request atau perubahan data |
| Route publik | Detail yang tidak dikenal atau status tidak aktif memberi 404 |
| Responsivitas | Screenshot detail ponsel diperiksa; tidak ada overflow pada katalog/detail |

Tes utama berada di `tests/Browser/browse.spec.js` dan `tests/Feature/BrowseFrontendTest.php`. Screenshot hasil lokal berada di `test-results` (diabaikan Git). Browser lokal memakai Chromium melalui `PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH=/usr/bin/chromium`.

T05 menyelesaikan demonstrasi frontend R5–R8, R10 serta P06/P07/P08/P09/P11/P13/P14 sesuai lingkupnya. Integrasi sumber, penyimpanan laporan, lokasi nyata, aturan produksi, dan otorisasi tetap menunggu backend. T06 (Tersimpan dan Bandingkan) belum dikerjakan.
