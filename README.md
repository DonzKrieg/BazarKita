# BazarKita

Fondasi frontend untuk membantu UMKM makanan dan minuman mengenali bazar di Bandung. Dibangun dengan Laravel 13, Blade, Tailwind CSS 4, Alpine.js 3, dan Vite 8.

## Status pengerjaan

Task 01: Laravel, aset, layout/komponen Blade, halaman contoh pengguna/admin, fixture, dan kontrak data layar. Semua informasi diberi label **Contoh**. Empat menu dan komponen lengkap dilanjutkan pada T02; alur layar lengkap mengikuti T03–T10.

Tahap ini tidak menggunakan database aplikasi, autentikasi nyata, API bisnis, worker, Apify, atau AI. Halaman /contoh/admin merupakan halaman contoh publik, bukan area admin yang sudah dilindungi. Jangan gunakan data pribadi atau kredensial nyata.

## Persyaratan

- PHP 8.3+ beserta ekstensi Laravel dan PHPUnit (ctype, curl, dom, fileinfo, filter, hash, mbstring, openssl, pcre, PDO, session, tokenizer, xml, xmlwriter, zip).
- Composer 2.10 atau lebih baru, dengan instalasi paket dari arsip distribusi (dist).
- Node.js 22.12+ atau 24, npm.
- Tidak memerlukan PostgreSQL pada tahap frontend.

Di cloud environment yang telah disiapkan:

~~~bash
source /workspace/.cloud-tools/activate
export npm_config_cache=/workspace/.cloud-tools/npm-cache
cd /workspace/BazarKita
~~~

## Instalasi

~~~bash
composer install --prefer-dist
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
npm ci
npm run build
~~~

Pembuatan APP_KEY dilakukan sekali pada instalasi baru. Pertahankan kunci yang sudah ada pada lingkungan yang digunakan. Berkas .env tidak masuk Git. Tidak perlu menjalankan migrasi atau membuat berkas SQLite.

### Windows: gagal membuat nul.env saat composer install

Dependensi vlucas/phpdotenv memiliki tests/fixtures/env/nul.env dalam repositori Git. Windows tidak dapat membuat nama perangkat NUL, termasuk bila memakai ekstensi. Folder tes tersebut dikecualikan oleh .gitattributes upstream dari ZIP distribusi resminya. Karena itu gunakan instalasi dist, bukan checkout source.

Proyek sudah menetapkan preferred-install: dist. Pada Composer sebelum 2.10, kegagalan mengunduh ZIP masih dapat memicu fallback otomatis ke Git. Mulai Composer 2.10, fallback itu dinonaktifkan secara default. Jalankan dari root proyek di PowerShell:

~~~powershell
composer self-update --stable
composer --version
php --ri zip
php --ri fileinfo
composer install --prefer-dist
~~~

Pastikan versi Composer minimal 2.10 dan ekstensi ZIP serta fileinfo aktif di PHP CLI. Jika Composer dikelola oleh installer atau package manager, perbarui melalui alat tersebut ketika self-update tidak tersedia. Perintah --prefer-dist mengesampingkan preferensi source dari konfigurasi global. Jangan mengaktifkan kembali source-fallback.

Jika folder vendor hanya berisi hasil instalasi gagal dan tidak memiliki perubahan manual, hapus folder yang belum lengkap lalu ulangi:

~~~powershell
if (Test-Path vendor) { Remove-Item -Recurse -Force vendor }
composer install --prefer-dist
~~~

Pertahankan composer.lock dan .env; tidak perlu menjalankan composer update. Bila unduhan ZIP tetap gagal, tangani pesan unduhan yang mendahuluinya (misalnya proxy, TLS, atau batas GitHub API). Akses HTTPS ke api.github.com dan codeload.github.com diperlukan untuk arsip GitHub. Jangan menonaktifkan pemeriksaan TLS atau mengubah proteksi nama file Git untuk melewati kegagalan ini.

CI memiliki job windows-install untuk menjalankan instalasi dist dan boot Laravel di Windows. Hasil CI perlu diperiksa setelah perubahan di-push; pengujian Linux saja tidak membuktikan instalasi Windows.

Rujukan: [.gitattributes phpdotenv pada versi terkunci](https://github.com/phpdotenv/phpdotenv/blob/301c07936b16d88628b126b01d082ba153cf4c40/.gitattributes) dan [perubahan fallback pada Composer 2.10](https://github.com/composer/composer/blob/main/CHANGELOG.md#2100-2026-05-28).

## Menjalankan

Dengan aset hasil build:

~~~bash
php artisan serve --no-reload --host=0.0.0.0 --port=8000
~~~

Untuk perubahan aset secara langsung, jalankan:

~~~bash
composer dev
~~~

Perintah ini menjalankan Laravel dan Vite. Alternatifnya gunakan dua terminal: php artisan serve --no-reload dan npm run dev. Opsi --no-reload menjaga konfigurasi PHP portabel di cloud; restart server setelah mengubah .env.

Halaman yang tersedia:

- /: contoh halaman awal dan tiga bazar.
- /?state=loading, /?state=empty, /?state=error, /?state=success: contoh keadaan layar.
- /contoh/admin: contoh identitas admin dan berbagai status bazar.
- /up: pemeriksaan kesehatan Laravel.

Tautan sumber informasi pada kartu menggunakan Alpine untuk membuka/menutup panel; biaya wajib dan ketentuan paket selalu terlihat. Sumber contoh tidak mengarah ke akun atau acara nyata.

## Pemeriksaan

~~~bash
npm run build
composer test
vendor/bin/pint --test
npx playwright install chromium
npm run test:browser
~~~

Tes fitur memeriksa rendering Blade, label contoh, harga/ketentuan paket, keadaan layar, escaping, dan halaman admin. Akses database serta HTTP provider dilarang di tes ini. Build harus dijalankan sebelum tes agar manifest Vite tersedia. Tes browser menjalankan server sendiri di port 8001 dan memeriksa lebar 360/768/1280 piksel, keyboard, panel Alpine, serta keadaan layar. Screenshot tersimpan di test-results (diabaikan Git). Di cloud ini Chromium tersedia: gunakan PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH=/usr/bin/chromium npm run test:browser tanpa mengunduh browser lagi.

## Struktur

- routes/web.php: route tampilan GET.
- app/Http/Controllers/FrontendPreviewController.php: meneruskan fixture ke Blade.
- resources/views/layouts: layout dasar.
- resources/views/components: label contoh, kartu awal, keadaan layar.
- resources/views/pages: halaman awal dan contoh admin.
- resources/fixtures/frontend.php: array contoh; bukan database/aturan bisnis.
- resources/css/app.css dan resources/js/app.js: aset lokal melalui Vite.
- [Kontrak data frontend](docs/frontend-contract.md).
- [Bukti Task 01](docs/task-01-validation.md).
- Dokumen acuan: [requirement](specs/requirements-id.md), [design](specs/design-id.md), [implementation plan](specs/implementation-plan-id.md).

Tanggal fixture tetap, dengan tanggal acuan 1 November 2026. Status bukan hasil perhitungan waktu nyata. Konfigurasi waktu aplikasi tetap UTC; tanggal dan label acara menggunakan WIB. Penghitungan, penyimpanan, keamanan, dan integrasi baru dikerjakan sesuai tahap backend.
