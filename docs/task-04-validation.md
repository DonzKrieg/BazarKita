# Task 04 — Form Usaha Saya

Tanggal pemeriksaan: 22 Oktober 2026 (WIB).

## Mencoba tampilan

Buka Usaha Saya sebagai pengguna contoh (`/me/profile?as=user`). Lima kelompok wajib mencakup jenis produk, lokasi asal (daerah serta lintang/bujur), jarak maksimal, batas sewa per hari, dan rentang tanggal tersedia dalam WIB. Panel **Tambahkan Informasi Usaha** memuat nama usaha, kisaran harga produk, dan fasilitas opsional. Tidak ada input kapasitas, margin, biaya variabel, atau anggaran total.

Gunakan **Coba profil belum lengkap** untuk mengosongkan form. **Terapkan perubahan contoh** memvalidasi isian, menampilkan kesalahan di dekat field, dan memindahkan fokus ke kesalahan pertama. Panel tambahan otomatis terbuka jika kesalahan berada di dalamnya.

- Sewa kosong ditolak; sewa 0 diterima sebagai hanya mencari sewa gratis yang dipastikan. Sewa negatif/pecahan ditolak.
- Jarak harus angka positif. Koordinat wajib valid pada rentang lintang -90–90 dan bujur -180–180; koordinat 0 valid.
- Tanggal wajib valid, dengan tanggal akhir tidak mendahului awal. Rentang satu hari diperbolehkan.
- Harga opsional boleh dikosongkan keduanya. Jika diisi, kedua batas wajib berupa rupiah bulat nonnegatif dan tidak terbalik.

Perubahan valid disimpan dalam `sessionStorage` per peran contoh, lalu digunakan ketika kembali ke form atau Beranda pada tab yang sama. **Kembalikan contoh awal** menghapus perubahan sementara. Jika storage tidak tersedia, pesan menjelaskan bahwa perubahan hanya terlihat di halaman saat ini. Tanpa JavaScript, form dinonaktifkan.

## Validasi

| Pemeriksaan | Hasil |
|---|---|
| `npm run build` | Lulus |
| `composer test` | 21 tes, 133 assertion lulus |
| `php vendor/bin/pint --test` | Lulus |
| `npm run test:browser` | 30 tes lulus pada viewport 360/768/1280 |
| Profil belum lengkap | Isian kosong ditolak, fokus ke jenis produk |
| Nilai batas | Jarak nol/negatif, sewa kosong/negatif/nol, koordinat di luar batas dan nol |
| Rentang | Tanggal terbalik, harga terbalik/sebagian kosong, harga opsional kosong |
| Perubahan contoh | Tanpa request, ringkasan Beranda berubah, reload mempertahankan isian, reset mengembalikan fixture |
| Storage diblokir | Pesan fallback tampil dan isian tidak hilang |
| Responsivitas | Tanpa overflow horizontal, screenshot form ponsel diperiksa |

Tes browser profil berada di `tests/Browser/profile.spec.js`. Pengujian lokal memakai Chromium dengan `PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH=/usr/bin/chromium`. Screenshot berada di `test-results` yang diabaikan Git.

## Batas

T04 mencakup tampilan R2.AC1–4, R14.AC2–4 dan demonstrasi P02/P18. Tidak ada penyimpanan database, geocoding, permintaan lokasi perangkat, atau pemilihan bazar personal. Beranda menunjukkan ringkasan kebutuhan terbaru tetapi tetap menyebut daftar bazar sebagai contoh umum. Pemilihan bazar frontend dilanjutkan pada T05; penyimpanan dan pemrosesan nyata menunggu backend.

Storage contoh bukan data akun atau sesi aman. Data dipisahkan berdasarkan peran contoh, bukan identitas pengguna nyata. Keluar tidak menghapus profil contoh di tab; gunakan tombol reset untuk menghapusnya. Jangan memasukkan data pribadi nyata.
