# Bukti Task 01 — Fondasi frontend

Tanggal pemeriksaan: 21 Oktober 2026 (WIB).

## Ruang lingkup

Laravel 13, Blade, Tailwind CSS 4 dan Alpine.js 3 terpasang dengan lockfile Composer/npm. Halaman awal dan contoh admin memakai layout serta komponen Blade. Fixture berlabel Contoh mencakup pengunjung/pengguna/admin, profil lengkap/tidak lengkap, tujuh bazar, harga harian/paket/bervariasi/gratis/belum jelas, serta berbagai status. Kontrak layar disimpan di frontend-contract.md.

Konfigurasi sesi/cache memakai array; antrean sync tidak menjalankan job apa pun. Tidak ada migrasi, SQLite aplikasi, autentikasi nyata, endpoint bisnis, atau panggilan provider.

## Hasil pemeriksaan

| Pemeriksaan | Hasil | Bukti/cakupan |
|---|---|---|
| composer validate --strict | Lulus | Manifest dan lockfile konsisten |
| npm run build | Lulus | CSS Tailwind dan JavaScript Alpine dibangun lewat Vite |
| composer test | 9 tes lulus, 62 assertion | tests/Feature/FrontendFoundationTest.php |
| vendor/bin/pint --test | Lulus | Format PHP |
| npm run test:browser dengan Chromium | 6 tes lulus | tests/Browser/foundation.spec.js; 2 tes × 3 viewport |
| Rendering HTTP nyata | Lulus | Browser membuka /, /contoh/admin dan empat keadaan layar melalui server Laravel |
| Ukuran 360/768/1280 | Lulus untuk dua halaman T01 | Tidak ada overflow horizontal; screenshot halaman awal/admin di test-results |
| Keyboard/Alpine | Lulus | Skip link, fokus konten, Enter untuk buka/tutup sumber, aria-expanded sesuai |
| Ketentuan harga | Lulus untuk fixture | Harga paket, hari wajib, dan biaya terlihat ketika panel sumber tertutup |
| Tanpa provider/database | Lulus | Tes fitur menolak koneksi DB/HTTP; tes browser tidak menemukan permintaan eksternal atau error JavaScript |

Screenshot desktop dan ponsel halaman awal juga diperiksa secara visual. Perintah tes browser di cloud:

~~~bash
source /workspace/.cloud-tools/activate
PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH=/usr/bin/chromium npm run test:browser
~~~

## Pemetaan dan batas bukti

- **P18 / R14.AC4:** bukti dasar bahasa Indonesia, rupiah/WIB, responsivitas, dan keyboard pada halaman T01. Audit seluruh alur dan aksesibilitas tetap T09–T10.
- **P20 / R15.AC3:** tersedia README instalasi, lockfile, konfigurasi contoh tanpa rahasia, dan halaman lokal berlabel Contoh. Deployment/URL live dan validasi rilis tetap T24.
- Empat menu lengkap, autentikasi contoh, profil interaktif, katalog/detail lengkap, dan seluruh admin mengikuti T02–T10.
- Tidak membuktikan keamanan akun, persistensi, pengurutan, perhitungan bisnis, kinerja 500 bazar, atau integrasi Apify/AI.
