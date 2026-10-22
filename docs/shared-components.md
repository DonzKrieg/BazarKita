# Task 02 — Menu dan komponen bersama

## Navigasi contoh

Empat menu utama selalu tersedia: Beranda (/), Katalog Bazar (/events), Tersimpan (/me/saved-events), dan Usaha Saya (/me/profile). Menu aktif memiliki aria-current=page. Mulai lebar 1024 piksel, menu sejajar dengan logo dan akses akun dalam satu navbar. Di bawah 1024 piksel, tombol hamburger membuka menu vertikal di header. Tombol memiliki aria-expanded/aria-controls; Escape menutup menu dan mengembalikan fokus. Tanpa JavaScript, tautan menu tetap terlihat.

Identitas contoh dipilih melalui query as=guest/user/admin. Query ini hanya memilih fixture; bukan sesi, autentikasi, atau otorisasi. Seluruh layar berlabel Contoh. Tidak ada password atau data pengguna nyata.

Pengunjung yang membuka Tersimpan atau Usaha Saya diarahkan ke /login?next=saved atau next=profile. Tombol Coba sebagai pengguna meneruskan ke tujuan tersebut dengan as=user. Daftar next dibatasi pada nama route home/saved/profile agar tidak menerima URL dari luar aplikasi. Keluar membuka dialog konfirmasi dan kembali ke Beranda pengunjung. Contoh admin tetap berada di /contoh/admin, terpisah dari empat menu utama.

Halaman katalog, tersimpan, dan profil merupakan dasar navigasi dengan fixture. Filter, edit profil, simpan/hapus, serta form autentikasi lengkap mengikuti T03–T08.

## Komponen Blade

| Komponen | Parameter utama | Perilaku |
|---|---|---|
| navigation | viewer | Empat menu, penanda aktif, identitas contoh dipertahankan |
| card | headingId opsional, slot | Kerangka kartu dengan judul yang terhubung |
| event-preview | event | Kartu bazar; harga paket, hari wajib, biaya, dan status nonaktif tetap terlihat |
| badge | tone: neutral/success/warning/danger, slot | Warna dan teks status; status tidak disampaikan lewat warna saja |
| example-badge | atribut HTML opsional | Label Contoh memakai badge bersama |
| form-field | id, label, name, type, hint, error, value, options | Input/select/textarea; label, petunjuk dan error terhubung |
| disclosure | id, label, closeLabel, slot | Buka/tutup rincian, aria-expanded dan aria-controls, fallback tanpa JavaScript |
| dialog | id, title, trigger, confirmLabel, confirmUrl opsional, slot | Dialog native, fokus awal Batal, siklus Tab/Shift+Tab, Escape dan pengembalian fokus |
| screen-state | state, message, actionUrl/actionLabel opsional | Keadaan memuat/kosong/gagal/berhasil; role status/alert dan tindakan kembali |
| money | value: integer/null | Rupiah dengan pemisah ribuan Indonesia; null tetap belum diketahui |
| wib-time | value: timestamp ISO-8601/null | Konversi UTC/offset ke Asia/Jakarta, label WIB, elemen time |

Gunakan ID unik pada setiap field, panel, dan dialog. Label dan teks fixture di-escape oleh Blade. Slot hanya diisi template tepercaya; jangan memakai HTML mentah dari input pengguna.

### Field dengan error dinamis

Halaman /contoh/komponen memperagakan field dengan slot error yang diisi Alpine. aria-invalid mengikuti keadaan validasi melalui x-bind; aria-describedby menghubungkan input ke hint dan area error. Pengiriman form hanya memeriksa nama contoh, menampilkan pesan, serta memfokuskan field yang perlu diperbaiki. Tidak mengirim atau menyimpan data.

### Dialog

Pemicu berupa tombol, dan isi dirender dengan elemen dialog native melalui showModal. Bagian belakang halaman menjadi inert. Pembatas fokus memastikan Tab/Shift+Tab berputar di dalam dialog. Escape atau Batal menutup dialog dan mengembalikan fokus ke pemicu.

Jika confirmUrl diberikan, tindakan konfirmasi membuka URL yang ditentukan template (contoh: keluar ke Beranda pengunjung). Jika tidak, dialog mengirim event Alpine example-confirmed. Galeri menangani event itu dengan pesan contoh lokal.

### Format tampilan

App\Support\Display hanya memformat nilai untuk layar; tidak menghitung kelayakan, harga paket, atau ranking.

- 150000 → Rp150.000.
- 0 → Rp0; label Gratis hanya dipakai jika sumber fixture menyatakan gratis.
- null → Belum ada informasi.
- 2026-11-01T18:30:00Z → 2 November 2026, 01.30 WIB.

Harga harian pecahan tetap memakai source_amount dan rental_days seperti kontrak T01. Pemformatan tampilan tidak digunakan untuk keputusan budget.

## Panduan bahasa

Halaman /contoh/komponen memuat contoh interaktif dan daftar istilah untuk pengunjung.

| Istilah teknis dalam kode/dokumen | Teks layar |
|---|---|
| provenance | Sumber Informasi |
| unknown | Belum ada informasi |
| insufficient data | Perlu ditanyakan |
| validation error | Periksa kembali isian; sebutkan isian yang perlu diperbaiki |
| eligibility | Sesuai Pilihan Anda |
| loading | Sedang memuat bazar |
| fetch error | Informasi belum berhasil dimuat |

Biaya wajib, kewajiban paket, pembatalan, dan ketidakpastian harga tidak boleh ditempatkan hanya di panel tertutup. Tidak ada menu rekomendasi terpisah atau kalkulator.

Filter katalog memakai `hintAfter` pada form-field agar label dan input sejajar, dengan petunjuk di bawah input. Jarak dan alasan pilihan menjadi bagian dari event-preview melalui prop `distance`/`reasons`, sehingga tidak melampaui tinggi kartu.
