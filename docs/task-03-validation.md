# Task 03 — Tampilan akun contoh

Tanggal pemeriksaan: 21 Oktober 2026.

## Mencoba alur

1. Buka `/login` atau pilih Tersimpan/Usaha Saya sebagai pengunjung. Pilih Daftar untuk membuka `/register`; tujuan semula tetap dibawa melalui `next`.
2. Gunakan email rekaan seperti `rani@example.test` dan kata sandi rekaan minimal delapan karakter. Pada Daftar, isi konfirmasinya sama. Jangan gunakan kredensial pribadi.
3. Coba email tidak valid, kata sandi terlalu pendek, atau konfirmasi berbeda. Pesan muncul di dekat isian dan fokus pindah ke isian pertama yang salah.
4. Pilih skenario Email sudah terdaftar pada Daftar; pilih Kata sandi salah atau Percobaan masuk dibatasi pada Masuk. Skenario menentukan hasil contoh, bukan pemeriksaan akun atau pembatasan oleh server. Tombol Atur ulang demonstrasi menghapus isian dan mengembalikan skenario Berhasil.
5. Pada skenario Berhasil, lanjutkan sebagai pengguna ke tujuan semula. Untuk admin, pilih Peran contoh Admin pada Masuk, lalu lanjut ke halaman admin contoh.
6. Pilih Keluar pada header. Batal/Escape mempertahankan peran; konfirmasi mengembalikan tampilan pengunjung. Ini memakai dialog bersama dari T02.

Tautan Navigasi contoh tanpa mengisi form tersedia untuk menjelajahi peran. Tanpa JavaScript, form dinonaktifkan dan tautan navigasi tetap bekerja.

## Batas implementasi

Alpine memvalidasi isian di browser, tanpa POST, database, atau layanan autentikasi. Kata sandi dihapus dari input/model setelah setiap percobaan dan saat mengganti skenario/peran. Aplikasi tidak menulis isian ke cookie, localStorage, sessionStorage, URL, atau server. Identitas yang ditampilkan selalu fixture Rani/Dina, bukan identitas dari email isian.

Parameter `as` hanya memilih fixture dan dapat diganti siapa saja. `next` hanya menerima home, saved, atau profile; URL eksternal dan parameter array ditolak. Pendaftaran tidak membuat akun, pembatasan percobaan hanya skenario demonstrasi, dan keluar tidak mengakhiri sesi keamanan nyata. Tombol kembali browser dapat menampilkan peran contoh sebelumnya. Autentikasi, keunikan email nyata, hashing, otorisasi, sesi, dan rate limiting tetap pekerjaan backend T12.

## Hasil validasi

| Pemeriksaan | Hasil |
|---|---|
| `npm run build` | Lulus |
| `composer test` | 21 tes, 133 assertion lulus |
| `php vendor/bin/pint --test` | Lulus |
| `npm run test:browser` | 21 tes lulus pada 360/768/1280 piksel |
| Alur akun | Email salah, kata sandi pendek/salah, konfirmasi berbeda, email duplikat, pembatasan contoh, reset, sukses pengguna/admin, keluar |
| Aksesibilitas | Label/error terkait, aria-invalid, fokus isian salah/pesan hasil, dialog keyboard, tanpa overflow horizontal |
| Isian sensitif | Pengiriman form tidak menghasilkan request; input password dikosongkan, storage browser kosong, URL/body request tidak membawa isian |
| Tanpa JavaScript | Form dinonaktifkan, navigasi pengunjung tetap berfungsi |
| Screenshot | Form Daftar ponsel diperiksa; hasil tiga viewport tersedia di test-results yang diabaikan Git |

Tes terkait: `tests/Browser/account.spec.js`, `tests/Browser/shared-frontend.spec.js`, `tests/Feature/SharedFrontendTest.php`. Browser memakai Chromium lokal melalui `PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH=/usr/bin/chromium`.

T03 memenuhi bagian tampilan R1.AC1–3, R13.AC2, R14.AC4 serta demonstrasi P01/P18. Hasil ini tidak menyatakan properti keamanan backend terpenuhi. T04 (form Usaha Saya) belum dikerjakan.
