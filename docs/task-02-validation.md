# Bukti Task 02 — Menu dan komponen bersama

Tanggal pemeriksaan: 21 Oktober 2026 (WIB).

## Hasil implementasi

- Empat menu Beranda, Katalog Bazar, Tersimpan, dan Usaha Saya tersedia di layout bersama, dengan penanda menu aktif dan susunan ponsel dua kolom.
- Pengunjung diarahkan ke Masuk contoh untuk menu pribadi, lalu diteruskan ke tujuan semula setelah memilih pengguna contoh.
- Keluar memakai dialog konfirmasi. Admin berada di halaman contoh terpisah dari empat menu utama.
- Komponen bersama tersedia untuk kartu, badge, input/select/textarea, rincian, dialog, keadaan memuat/kosong/gagal/berhasil, rupiah, dan waktu WIB.
- Halaman /contoh/komponen menyediakan contoh interaktif serta daftar istilah sederhana.
- Harga paket, hari wajib, biaya wajib, dan status bazar berakhir tetap terlihat ketika rincian ditutup.

## Validasi

| Pemeriksaan | Hasil | Bukti |
|---|---|---|
| npm run build | Lulus | Tailwind dan Alpine melalui Vite |
| composer test | 20 tes lulus, 125 assertion | FrontendFoundationTest dan SharedFrontendTest |
| php vendor/bin/pint --test | Lulus | Format PHP |
| npm run test:browser | 12 tes lulus | 4 tes × viewport 360/768/1280 |
| Navigasi dan kembali setelah Masuk | Lulus | Empat tujuan, aria-current, identitas contoh dipertahankan, next dibatasi nama route |
| Keluar dan dialog | Lulus | Batal/Escape, konfirmasi, Tab/Shift+Tab di dalam dialog, fokus kembali ke pemicu |
| Form contoh | Lulus | Label/hint/error terkait, fokus field invalid, pesan berhasil lokal, input/select/textarea |
| Rupiah/WIB | Lulus | Rp150.000, Rp0, null, perubahan tanggal UTC ke WIB |
| Database/provider | Tidak digunakan | Tes fitur melarang koneksi DB dan permintaan provider |
| Screenshot | Diperiksa | Beranda ponsel dan panduan tampilan desktop; artefak seluruh viewport di test-results |

Pengujian browser dijalankan dengan Chromium lokal melalui PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH=/usr/bin/chromium. Screenshot dan laporan hasil merupakan output yang diabaikan Git.

## Pemetaan dan batas

T02 selesai untuk fondasi R14.AC1–4, P09 (empat menu) dan P18 (bahasa, navigasi, keyboard, responsivitas komponen). Seluruh data tetap berlabel Contoh. as=user/admin adalah pilihan fixture, bukan sesi atau otorisasi.

T03 tetap mencakup form Daftar/Masuk dan berbagai kesalahan akun. T04–T08 melengkapi fitur layar. T09–T10 memeriksa seluruh alur frontend. T02 tidak menyatakan bahwa backend, keamanan akun, penyimpanan, pengurutan bazar, atau integrasi telah dibangun.
