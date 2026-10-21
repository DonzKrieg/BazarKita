# Overview — Gambaran Singkat

Rencana ini mengikuti Requirement dan Design Document revisi terbaru: bahasa sederhana, empat menu utama, maksimal tiga pilihan di Beranda, katalog lengkap, dan sewa stan per hari. Kalkulator impas dan simulasinya dihapus; tidak ada tab rekomendasi terpisah. Ketentuan paket dan biaya wajib tetap terlihat.

Laravel dipasang sejak T01 dan seluruh halaman langsung dibuat dengan Blade, Tailwind CSS serta Alpine.js. Route tampilan dan controller sederhana untuk mengirim array contoh termasuk persiapan frontend. Pengerjaan tetap berurutan: **seluruh frontend Blade → backend fungsional → integrasi → pengujian akhir dan rilis**. Frontend mencakup semua halaman pengguna dan admin, seluruh interaksi, bahasa, responsif, serta keadaan memuat/kosong/gagal. Gunakan data contoh berlabel dan kontrak bentuk respons. Sebelum checkpoint T10 lulus, proyek hanya merender halaman dan interaksi contoh; database aplikasi, autentikasi nyata, aturan bisnis server, API bisnis, Apify dan AI belum dibangun.

Rencana ini menggantikan penomoran task sebelumnya dengan T01–T24. R1–R15 dan AC mengacu ke requirements-id.md saat ini; P01–P20 mengacu ke design-id.md. Task frontend hanya menyelesaikan bagian tampilan/interaksi dari requirement yang dirujuk. Keamanan, penyimpanan, aturan server dan layanan nyata baru ditutup setelah backend dan integrasi diuji. Checklist ditandai selesai hanya setelah implementasi dan pemeriksaan terkait memiliki bukti.

| Tahap | Task | Syarat berpindah tahap |
|---|---|---|
| Seluruh frontend | T01–T10 | Semua halaman, interaksi contoh, bahasa dan tampilan lulus checklist T10. |
| Seluruh backend | T11–T20 | Seluruh layanan yang dibutuhkan layar tersedia dan lulus uji backend. |
| Integrasi | T21 | Semua layar dihubungkan ke layanan nyata, dengan status dan error yang benar. |
| Pengujian dan rilis | T22–T24 | Seluruh AC, kinerja, setup bersih dan pemeriksaan live memiliki bukti. |

Perubahan kecil pada frontend setelah integrasi dapat dilakukan untuk memperbaiki temuan. Ini tidak mengubah ketentuan bahwa frontend lengkap harus selesai sebelum pembangunan backend dimulai. Jika aplikasi lama sudah ada, periksa kode/data nyata dahulu dan migrasikan bagian terdampak secara terkontrol.

# Tasks — Langkah Pengembangan

## Tahap 1 — Selesaikan Seluruh Frontend

### Task 01 — Menyiapkan frontend

**Dependensi:** Tidak ada.

**Requirement:** R14.AC4, R15.AC3

**Properti uji:** P18, P20

- [x] Pasang Laravel; siapkan Blade, Tailwind CSS dan Alpine.js, aset, layout/komponen di resources/views, serta route tampilan di routes/web.php. Gunakan controller sederhana hanya bila diperlukan untuk mengirim array contoh, tanpa database aplikasi atau API bisnis.
- [x] Siapkan data contoh berlabel untuk pengguna, admin, bazar, harga harian/paket, dan berbagai status; bentuk respons disepakati sebagai kontrak layar.

**Selesai jika:** Halaman .blade.php dapat dibuka melalui Laravel dengan data contoh tanpa database aplikasi, autentikasi nyata atau panggilan provider; komponen langsung dibuat dalam Blade.

**Bukti T01:** [Hasil pemeriksaan fondasi frontend](../docs/task-01-validation.md). Kelulusan ini hanya mencakup fondasi tampilan; R14/R15 secara keseluruhan dan T02–T24 belum dinyatakan selesai.


### Task 02 — Menyusun menu dan komponen bersama

**Dependensi:** T01

**Requirement:** R14.AC1–4

**Properti uji:** P09, P18

- [x] Buat empat menu Beranda, Katalog Bazar, Tersimpan dan Usaha Saya; sediakan akses masuk/keluar dan halaman admin terpisah.
- [x] Buat kartu, form, badge, panel rincian, dialog, loading/empty/error, format rupiah/WIB dan daftar istilah sederhana; tidak ada tab rekomendasi atau kalkulator.

**Selesai jika:** Navigasi dan komponen konsisten, dapat digunakan dengan keyboard dan tidak memakai istilah teknis pada layar UMKM.

**Bukti T02:** [Hasil pemeriksaan menu dan komponen](../docs/task-02-validation.md), [panduan komponen](../docs/shared-components.md). Akses akun masih contoh; Status tugas berikutnya dicatat pada bagian masing-masing.


### Task 03 — Membuat tampilan akun

**Dependensi:** T02

**Requirement:** R1.AC1–3, R13.AC2, R14.AC4

**Properti uji:** P01, P18

- [x] Buat Daftar, Masuk, Keluar dan pesan validasi sederhana; contohkan email salah, password salah dan percobaan masuk dibatasi.
- [x] Simulasikan pengguna keluar, pengguna masuk dan admin untuk perpindahan layar; beri label demonstrasi, tanpa menyimpan password atau mengaku sesi aman.

**Selesai jika:** Semua alur tampilan akun dapat dicoba; keamanan dan sesi nyata belum dinyatakan selesai.


**Bukti T03:** [Panduan dan hasil pemeriksaan akun contoh](../docs/task-03-validation.md). Autentikasi, pembatasan percobaan, dan sesi nyata tetap menunggu backend.

### Task 04 — Membuat form Usaha Saya

**Dependensi:** T03

**Requirement:** R2.AC1–4, R14.AC2–4

**Properti uji:** P02, P18

- [ ] Buat lima isian wajib dan panel tambahan sesuai R2, dengan batas sewa per hari, label pendek serta contoh pengisian.
- [ ] Tampilkan validasi di browser untuk nilai kosong, nol/negatif, koordinat dan rentang; contohkan edit serta profil belum lengkap tanpa input margin/kapasitas/budget total.

**Selesai jika:** Form mudah dipahami dan perubahan dapat dicoba menggunakan data contoh; penyimpanan nyata menunggu backend.


### Task 05 — Membuat Beranda, katalog dan detail

**Dependensi:** T04

**Requirement:** R5.AC1–4, R6.AC1–4, R7.AC1–4, R8.AC1–2, R10.AC1–4

**Properti uji:** P06, P07, P08, P09, P11, P13, P14

- [ ] Buat Beranda maksimal tiga pilihan dan dua alasan, fallback Bazar Mendatang, keadaan tanpa hasil, serta Lihat Semua Bazar menuju katalog lengkap.
- [ ] Buat pencarian/filter interaktif berbasis fixture dan detail bertahap; tampilkan harga/hari, Setara untuk paket, hari wajib, biaya wajib, sumber, kontak dan laporan koreksi. Jangan tampilkan skor/likes.

**Selesai jika:** Kasus 0/1/2/3/5 pilihan dan data belum pasti dapat diperagakan; harga paket tidak terkesan sebagai sewa satu hari.


### Task 06 — Membuat Tersimpan dan Bandingkan

**Dependensi:** T05

**Requirement:** R9.AC1–3, R11.AC1–3, R14.AC1–4

**Properti uji:** P12, P15, P18

- [ ] Buat simpan/hapus pilihan contoh, keadaan kosong, perubahan harga/status dan tindakan membuka detail.
- [ ] Buat pemilihan dua/tiga bazar berbeda dan tabel singkat yang berfungsi di ponsel; sertakan ketentuan sewa dan biaya wajib, tanpa kalkulator atau simulasi.

**Selesai jika:** Tindakan tersimpan/perbandingan berjalan pada data contoh; tidak ada pilihan ganda atau jalur kalkulator aktif.


### Task 07 — Membuat pengalaman dan pengaturan akun

**Dependensi:** T06

**Requirement:** R12.AC1–3, R13.AC3, R14.AC2–4

**Properti uji:** P16, P17, P18

- [ ] Buat Tulis Pengalaman setelah bazar selesai, edit/hapus, serta Tambah Catatan untuk angka opsional dengan validasi tampilan.
- [ ] Buat pengaturan akun, konfirmasi hapus akun dan semua keadaan sukses/gagal menggunakan data contoh; tindakan belum menghapus data nyata.

**Selesai jika:** Alur pengguna lengkap sampai pengalaman dan pengaturan akun dapat dicoba dengan bahasa sederhana.


### Task 08 — Membuat seluruh halaman admin

**Dependensi:** T07

**Requirement:** R3.AC1–4, R4.AC1–4, R6.AC3, R12.AC3, R14.AC2–4

**Properti uji:** P03, P04, P05, P08, P16, P18

- [ ] Buat daftar/form bazar dan penawaran, sumber aktif, kandidat, pemeriksaan per field, konfirmasi publish/withdraw/cancel, merge, laporan koreksi dan review bukti pengalaman.
- [ ] Buat tampilan run manual/jadwal, antrean, hasil pengambilan, gagal/kuota, riwayat perubahan dan konflik edit; seluruh aksi disimulasikan dengan fixture dan istilah sederhana.

**Selesai jika:** Semua layar admin dan keadaan penting tersedia; belum menjalankan scraping, AI, publikasi atau perubahan database nyata.


### Task 09 — Memeriksa seluruh frontend

**Dependensi:** T08

**Requirement:** R14.AC1–4, R5.AC2, R6.AC1–4, R8.AC1–2, R9.AC2–3, R10.AC1–4

**Properti uji:** P08, P09, P11, P12, P13, P14, P18

- [ ] Uji semua halaman pengguna/admin pada 360/768/1280 piksel dan keyboard; periksa fokus, label, error, alt, kontras status dan rincian yang dapat dibuka.
- [ ] Audit seluruh heading/tombol/pesan agar formal sederhana; uji calon pengguna memahami sewa harian/paket, mencari dan menyimpan bazar, serta menemukan biaya wajib.

**Selesai jika:** Temuan yang menghalangi alur selesai diperbaiki; screenshot, daftar halaman dan hasil pemeriksaan tersedia.


### Task 10 — Menutup tahap frontend sebelum backend

**Dependensi:** T09

**Requirement:** R1–R14, R15.AC3

**Properti uji:** P01–P18

- [ ] Periksa checklist seluruh layar termasuk admin, empat menu, keadaan normal/kosong/gagal, data contoh berlabel, dan tidak adanya fitur yang dihapus.
- [ ] Bekukan acuan komponen, teks, bentuk data dan navigasi; tandai AC frontend yang diuji serta AC layanan/keamanan yang masih menunggu. Backend T11 hanya dimulai jika checklist frontend lulus.

**Selesai jika:** Semua halaman pengguna/admin sudah berupa Blade di proyek Laravel yang sama dan dapat didemokan dengan data contoh. Tidak ada masalah penghalang; backend fungsional dan AC layanan nyata tetap menunggu tahap berikutnya.

## Tahap 2 — Bangun Backend Setelah Frontend Selesai

### Task 11 — Menyiapkan backend dan database

**Dependensi:** T10

**Requirement:** R1.AC1, R2.AC1–3, R3.AC2, R4.AC1–4, R10.AC1–4, R11.AC1–3, R12.AC1–3, R13.AC3, R15.AC3

**Properti uji:** P01–P05, P13–P17, P20

- [ ] Lanjutkan proyek Laravel dari T01: hubungkan PostgreSQL, siapkan konfigurasi server, sesi nyata, antrean, worker dan scheduler, lalu buat skema seluruh entitas sesuai desain revisi. Laravel dan tampilan Blade tidak dibuat ulang.
- [ ] Tambahkan constraint, index, versi, audit, harga sumber/hari eksplisit dan aturan v2. Instalasi baru tidak memuat kalkulator; jika kode/data lama ada, buat migrasi terkontrol dan uji rollback.

**Selesai jika:** Migration/constraint dan lingkungan backend lulus pemeriksaan; implementasi backend baru dimulai setelah T10.


### Task 12 — Membangun akun dan hak akses nyata

**Dependensi:** T11

**Requirement:** R1.AC1–3, R13.AC1–2

**Properti uji:** P01, P19

- [ ] Implementasikan register/login/logout, email unik, hash password, sesi dapat dicabut, role/ownership policy dan reautentikasi tindakan sensitif.
- [ ] Tambahkan validasi server, CSRF, cookie aman, limiter dan respons error sesuai kontrak frontend; uji akses silang dan replay sesi.

**Selesai jika:** API akun dan policy lolos uji backend; frontend masih memakai contoh sampai tahap integrasi.


### Task 13 — Membangun profil dan aturan sewa harian

**Dependensi:** T12

**Requirement:** R2.AC1–4, R10.AC1–4, R4.AC2

**Properti uji:** P02, P13, P14

- [ ] Implementasikan simpan/update profil, field opsional, versi profil dan validasi server sesuai R2.
- [ ] Implementasikan tarif harian/paket/bervariasi, hitungan tepat sebelum filter, pembulatan tampilan, gratis berbukti, hari wajib dan biaya tambahan; uji Rp450.000/3 dan Rp100.000/3 hari.

**Selesai jika:** Profil persisten dan harga benar pada batas anggaran; hari sewa tidak diketahui tidak ditebak.


### Task 14 — Membangun pengelolaan bazar

**Dependensi:** T13

**Requirement:** R4.AC1–4, R6.AC2–3

**Properti uji:** P04, P05, P08

- [ ] Implementasikan CRUD bazar/offer/sumber, pemeriksaan field, publish/withdraw/cancel, konflik tanggal/lokasi dan audit atomik.
- [ ] Implementasikan edit dengan version check, merge yang menjaga sumber/data pengguna, serta laporan koreksi yang menunggu admin.

**Selesai jika:** Data valid dapat diterbitkan dan penggabungan/rollback tidak kehilangan sumber; tidak ada perubahan publik otomatis.


### Task 15 — Membangun katalog dan pengurutan Beranda

**Dependensi:** T14

**Requirement:** R5.AC1–4, R6.AC1–4, R7.AC1–4

**Properti uji:** P06–P10

- [ ] Implementasikan katalog lengkap, filter tiga status, pagination, Haversine, status waktu WIB, detail/sumber dan warning pemeriksaan.
- [ ] Implementasikan aturan v2, eligibility per offer, sewa per hari, top tiga, tie-break, guest fallback dan keadaan tanpa hasil. Katalog tetap memuat semua bazar aktif; skor tidak dikirim untuk tampilan UMKM.

**Selesai jika:** Respons katalog/Beranda sesuai kontrak dan aturan domain lulus tanpa Apify/AI pada request inti.


### Task 16 — Membangun alasan dan layanan perbandingan

**Dependensi:** T15

**Requirement:** R8.AC1–3, R9.AC1–3

**Properti uji:** P11, P12

- [ ] Implementasikan fact/reason code, renderer kalimat dan maksimal dua alasan per kartu; peringatan wajib terpisah. AI asinkron hanya mengurutkan kode sah, dengan fallback.
- [ ] Implementasikan endpoint compare dua/tiga ID berbeda, harga/ketentuan sewa benar, dan respons tanpa data pribadi pengguna lain.

**Selesai jika:** Alasan tidak membuat klaim baru atau mengubah ranking; layanan perbandingan menolak pilihan invalid.


### Task 17 — Membangun Tersimpan dan pengalaman

**Dependensi:** T16

**Requirement:** R11.AC1–3, R12.AC1–3

**Properti uji:** P05, P15, P16

- [ ] Implementasikan bookmark unik/persisten dan status/harga terkini; tidak ada endpoint atau penyimpanan simulasi aktif.
- [ ] Implementasikan pengalaman sesudah bazar selesai, angka opsional, edit/delete pemilik, bukti privat dan review admin. Uji ulang merge untuk bookmark/evaluasi ganda.

**Selesai jika:** Pilihan dan pengalaman tersimpan nyata, terisolasi per pemilik; angka keuangan tidak dipakai untuk ranking.


### Task 18 — Membangun pengambilan data Apify

**Dependensi:** T14

**Requirement:** R3.AC1–2, R3.AC4

**Properti uji:** P03, P19

- [ ] Implementasikan sumber aktif/nonaktif, run manual, scheduler 02.00 WIB, lock dan unique run harian.
- [ ] Hubungkan Actor asinkron, polling singkat, pagination dataset, upsert post ID dan hasil/error; katalog/manual input tetap berfungsi saat gagal.

**Selesai jika:** Pengambilan sumber uji berhasil dan retry tidak membuat kandidat ganda; pencarian tidak memicu scraping.


### Task 19 — Membangun ekstraksi dan tinjauan data

**Dependensi:** T18, T13

**Requirement:** R3.AC3, R4.AC2–3, R10.AC1–4

**Properti uji:** P04, P05, P13, P14

- [ ] Implementasikan AI/OCR dengan JSON schema dan bukti per field, validasi caption/poster tidak tepercaya serta pembatasan unduhan.
- [ ] Ekstrak harga, satuan dan hari sewa sesuai sumber; ketidakjelasan tetap unknown/conflicted. Kandidat menunggu admin dan tidak menimpa data publik.

**Selesai jika:** Data parsial/ambigu tidak ditebak; satu contoh nyata melewati pengambilan dan pemeriksaan sebelum publikasi.


### Task 20 — Menuntaskan keamanan dan ketahanan backend

**Dependensi:** T12, T16, T17, T19

**Requirement:** R13.AC1–4, R3.AC4, R15.AC2

**Properti uji:** P01, P17, P19

- [ ] Implementasikan hapus akun/data/bukti/cache/sesi, penghentian job pribadi dan prosedur restore yang menerapkan ulang penghapusan; sertakan data lama jika ada.
- [ ] Terapkan timeout 30 detik, job 120 detik, maksimal tiga percobaan, deadline Apify 15 menit, log aman, HTTPS dan payload tanpa lokasi/keuangan pribadi; uji provider down dan akses silang.

**Selesai jika:** Seluruh layanan backend yang dibutuhkan frontend tersedia dan lulus uji; data terhapus tidak hidup kembali dan kegagalan tidak menghilangkan katalog.

## Tahap 3 — Integrasi, Pengujian dan Rilis

### Task 21 — Menghubungkan frontend yang selesai ke backend

**Dependensi:** T10, T20

**Requirement:** R1–R15

**Properti uji:** P01–P20

- [ ] Hubungkan halaman dan komponen Blade yang sudah selesai ke controller/service/database pada proyek yang sama; sambungkan form, Beranda/katalog, bookmark, compare, pengalaman serta admin ke layanan nyata tanpa konversi HTML ke Blade.
- [ ] Ganti adapter data contoh dengan respons server; periksa sesi, CSRF, error, loading dan pembaruan status. Data demo tetap berlabel; hapus tautan/API kalkulator dan redirect rekomendasi lama bila ada.

**Selesai jika:** Semua layar memakai layanan nyata sesuai kontrak tanpa menu yang dihapus; perbaikan integrasi tidak mengembalikan istilah teknis ke UMKM.


### Task 22 — Menguji alur lengkap dan kebutuhan

**Dependensi:** T21

**Requirement:** R1–R14, R15.AC2

**Properti uji:** P01–P19

- [ ] Jalankan tes integrasi/browser dari akun sampai pengalaman serta admin ingest→review→publish; ulangi uji bahasa, keyboard dan tiga viewport.
- [ ] Verifikasi harga paket/pembulatan, katalog lengkap/top tiga, unknown, otorisasi, penghapusan data dan fitur yang dihapus; simpan bukti test ID, property ID, AC, input/seed dan hasil.

**Selesai jika:** Semua AC fungsional lulus dengan bukti; pengujian beban dan rilis masih menunggu T23–T24.


### Task 23 — Menguji kecepatan dan gangguan layanan

**Dependensi:** T22

**Requirement:** R15.AC1–2, R3.AC4

**Properti uji:** P19

- [ ] Uji 500 bazar/20 pengguna bersamaan pada lingkungan setara rilis untuk Beranda, katalog, detail, filter dan ranking.
- [ ] Pastikan p95 server ≤2 detik, aset/AI diukur terpisah, tanpa provider pada request inti; perbaiki query/index/pagination dan ukur ulang kasus yang gagal.

**Selesai jika:** Target terukur tercapai dan laporan beban mencatat lingkungan/dataset; katalog tetap tersedia saat provider gagal.


### Task 24 — Menerbitkan website dan menutup rilis

**Dependensi:** T23

**Requirement:** R15.AC3; R1–R15

**Properti uji:** P01–P20

- [ ] Lengkapi README, konfigurasi tanpa rahasia, lisensi, worker/scheduler, backup/restore dan rollback; jalankan instalasi bersih.
- [ ] Deploy versi teruji dengan HTTPS dan repo publik; lakukan smoke test empat menu, harga harian/paket, top tiga, admin dan fitur dihapus. Catat commit/URL dan bukti seluruh AC.

**Selesai jika:** Website live dan setup dapat digunakan; tidak ada AC gagal yang diklaim selesai.

## Pemetaan Requirement ke Tahap Pengerjaan

Task frontend membuktikan tampilan/interaksi contoh saja. Task backend membuktikan layanan dan aturan server. R14 tetap menjadi acuan bahasa pesan server agar integrasi tidak mengembalikan istilah sulit. Requirement dinyatakan selesai setelah seluruh AC terkait lulus pemeriksaan akhir; jangan menandai requirement selesai hanya karena layar sudah dibuat.

| Requirement | Frontend | Backend | Integrasi dan validasi akhir |
|---|---|---|---|
| R1 | T03 | T12 | T21–T22, T24 |
| R2 | T04 | T13, T15 | T21–T22, T24 |
| R3 | T08 | T18–T20 | T21–T24 |
| R4 | T08 | T14, T19 | T21–T22, T24 |
| R5 | T05 | T15 | T21–T24 |
| R6 | T05, T08 | T14–T15 | T21–T22, T24 |
| R7 | T05 | T15 | T21–T24 |
| R8 | T05 | T16 | T21–T22, T24 |
| R9 | T06 | T16 | T21–T22, T24 |
| R10 | T05–T06, T08 | T13, T19 | T21–T22, T24 |
| R11 | T06 | T17 | T21–T22, T24 |
| R12 | T07–T08 | T17 | T21–T22, T24 |
| R13 | T03, T07 | T12, T20 | T21–T22, T24 |
| R14 | T02–T10 | T12–T20 | T21–T22, T24 |
| R15 | T01, T09–T10 | T11, T20 | T21–T24 |