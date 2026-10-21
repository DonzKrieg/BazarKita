# Kontrak layar frontend v1

Kontrak awal untuk T01; dipakai kembali dan dilengkapi pada T02–T10. Sumber: resources/fixtures/frontend.php. Controller hanya memilih array dan menyerahkannya ke Blade. Tidak ada endpoint JSON, pencarian database, pemeringkatan, atau perhitungan harga server.

## Data yang diterima halaman

Variabel screen memuat:

| Field | Bentuk | Makna |
|---|---|---|
| meta | object | schema_version: frontend.v1, is_example: true, label: Contoh, reference_date: 2026-11-01, timezone: Asia/Jakarta, currency: IDR |
| state | string | ready, loading, empty, error, success |
| viewer | object | id: string/null, name: string, role: guest/user/admin, is_example: true |
| events | array | Bazar contoh untuk layar; kosong pada keadaan selain ready |
| message | object, halaman awal | title, description untuk keadaan layar |

Peran di fixture hanya identitas contoh, bukan bukti login atau izin akses. Beranda memakai pengunjung; contoh admin memakai admin. Fixture pengguna dan profil disediakan untuk task layar berikutnya. Tampilan publik tidak menerima seluruh fixture profil/pengalaman.

## Bazar

| Field | Bentuk |
|---|---|
| id, name, is_example | ID stabil, nama, penanda contoh |
| location | label, latitude, longitude |
| starts_on, ends_on | Tanggal acara YYYY-MM-DD, WIB |
| date_label | Teks Indonesia yang sudah disiapkan |
| status, status_label | published/draft/cancelled/ended/withdrawn dan teks Indonesia |
| registration_status, registration_label | open/closed/unknown dan teks Indonesia |
| categories, facilities | Daftar string; fasilitas null berarti belum diketahui, [] berarti diketahui kosong |
| organizer | Nama penyelenggara contoh |
| source | label, url: null untuk fixture, checked_at: ISO-8601 UTC/null, checked_label dalam WIB |
| offer | Satu penawaran contoh; multi-penawaran dilengkapi pada task terkait |

## Harga dan biaya

offer memuat id, basis: daily/package/variable, source_amount: integer/null, rental_days: integer/null, daily_amount: integer/null, price_label, commitment_label, package_label: string/null, mandatory_fees: array/null, dan fees_label. Tarif bervariasi memiliki daily_rates: [{date, amount}].

- Nilai uang dalam rupiah integer. daily_amount hanya terisi jika nilainya tepat dan diketahui; paket pecahan tetap memakai nilai sumber dan jumlah hari, tanpa angka harian hasil pembulatan untuk penyaringan.
- Label sudah ditulis dalam fixture. Contoh Rp450.000/3 hari: **Setara Rp150.000/hari**, **Wajib sewa 3 hari**, **Harga paket Rp450.000**.
- Contoh Rp100.000/3 hari menyimpan source_amount: 100000, rental_days: 3, daily_amount: null, dengan label **Setara Rp33.334/hari**. Hitungan rasional dan filter tepat adalah pekerjaan T13.
- Paket dengan hari tidak diketahui tetap daily_amount: null dan **Tanyakan harga sewa**, meski tanggal acara diketahui.
- mandatory_fees: null berarti belum ada informasi; [] berarti sumber contoh menyatakan tidak ada biaya. Entri biaya berisi label, amount, unit.
- Gratis hanya diberikan pada fixture dengan sumber eksplisit. Null tidak boleh diubah menjadi nol.
- Ketentuan hari, harga paket, serta biaya wajib berada di luar panel sumber yang dapat ditutup.

## Fixture lanjutan

viewers berisi pengunjung/pengguna/admin; profiles berisi profil lengkap/tidak lengkap; home_selections berisi daftar ID contoh kosong/satu/dua/pengunjung; saved_event_ids dan experiences menjadi titik awal task terkait. Semua masih lokal dan tidak menyimpan perubahan.

Tanggal acuan tetap menjaga pengujian bisa diulang. Status sudah ditentukan di fixture, bukan dihitung dari jam mesin. Jangan menganggap fixture membuktikan aturan rekomendasi, hak akses, atau integrasi backend.

## Keadaan dan interaksi

Keadaan layar dipilih melalui GET /?state=... Nilai di luar daftar menghasilkan 404. loading merupakan keadaan statis yang sengaja diperagakan, bukan permintaan jaringan yang sedang berjalan. Tombol kembali/coba lagi membuka fixture normal. Panel sumber dibuka/ditutup menggunakan Alpine, dilengkapi aria-expanded, aria-controls, dan fallback teks tanpa JavaScript.
