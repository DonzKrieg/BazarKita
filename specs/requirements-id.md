# Pendahuluan

Website ini membantu UMKM makanan dan minuman menemukan bazar yang sesuai dengan jenis usaha, tanggal, lokasi, dan batas sewa stan per hari. Versi awal berfokus pada Bandung. Informasi berasal dari Instagram publik melalui Apify, dilengkapi input dan pemeriksaan admin.

Revisi ini menyederhanakan pengalaman pengguna: pilihan teratas muncul di Beranda dan semua bazar lain tersedia di Katalog Bazar. Kalkulator impas beserta simulasinya dihapus. Harga utama menggunakan sewa per hari dengan ketentuan paket yang tetap jelas. Website membantu memilih bazar tanpa menjanjikan penjualan atau keuntungan.

Nomor R1–R15 dipertahankan untuk menghubungkan ketiga dokumen. R10 kini mengatur sewa per hari dan menggantikan kebutuhan kalkulator lama; rujukan acceptance criteria (AC) mengikuti revisi ini. Judul dan istilah yang tampil di produk wajib menggunakan bahasa sederhana. Dokumen Inggris menjelaskan kebutuhan yang sama; bahasa produk tetap Indonesia.

Laravel dipasang sejak awal. Seluruh halaman frontend langsung dibuat sebagai template Blade (.blade.php), dengan Tailwind CSS untuk tampilan dan Alpine.js untuk interaksi. Route tampilan serta pengiriman array data contoh diperbolehkan sebagai persiapan menjalankan halaman. Pengembangan dilakukan dengan menyelesaikan seluruh frontend terlebih dahulu, termasuk halaman admin, bahasa, interaksi, keadaan kosong/gagal, serta tampilan ponsel. Tahap ini memakai data contoh berlabel dan belum membuktikan penyimpanan, keamanan, atau layanan nyata. Backend fungsional—database aplikasi, autentikasi nyata, aturan bisnis server, dan integrasi layanan—dimulai setelah pemeriksaan frontend selesai; setiap requirement baru dinyatakan terpenuhi setelah fungsi terkait terhubung dan lulus validasi akhir.

# Istilah Singkat

| Istilah | Arti |
|---|---|
| UMKM | Usaha mikro, kecil, dan menengah yang menggunakan website. |
| Bazar | Kegiatan berjualan pada tempat dan tanggal tertentu. |
| Stan | Tempat berjualan yang disewakan kepada pelaku usaha. |
| Sewa per hari | Harga sewa stan untuk satu hari, dengan ketentuan lama sewa yang disebutkan. |
| Setara per hari | Pembagian harga paket dengan jumlah hari sewanya; bukan tawaran sewa satu hari. |
| Sumber informasi | Unggahan, tautan, atau konfirmasi yang menjadi dasar informasi bazar. |
| Belum ada informasi | Keterangan belum tersedia atau belum dapat dipastikan. |
| Apify | Layanan untuk mengambil informasi dari sumber publik yang dipilih admin. |
| AI/OCR | Bantuan untuk membaca caption/poster dan memilih urutan alasan berdasarkan data. |
| AC | Kriteria yang perlu dipenuhi agar suatu kebutuhan dinyatakan selesai. |

# Kebutuhan 1 — Masuk dan mengelola akun

**User Story:** Sebagai pemilik UMKM, saya ingin memiliki akun agar pilihan bazar dan data usaha tersimpan.

**Acceptance Criteria:**

1. Pengguna dapat mendaftar, masuk, dan keluar dengan email unik yang valid dan kata sandi.
2. Pengunjung dapat membuka Beranda, Katalog Bazar, dan detail. Menyimpan bazar, mengubah usaha, atau menulis pengalaman memerlukan akun.
3. Pengguna hanya dapat mengakses data pribadinya; halaman dan tindakan admin dibatasi di server. Sesi yang sudah keluar tidak dapat digunakan lagi.

# Kebutuhan 2 — Mengisi Usaha Saya

**User Story:** Sebagai pemilik UMKM, saya ingin mengisi data singkat agar pilihan bazar sesuai usaha saya.

**Acceptance Criteria:**

1. Isian wajib untuk pilihan personal: jenis produk, lokasi asal, jarak maksimal, batas sewa stan per hari, dan tanggal tersedia. Gunakan label sederhana dan contoh singkat.
2. Nama usaha, kisaran harga produk, dan fasilitas yang diperlukan tersedia sebagai isian tambahan. Tidak ada pertanyaan kapasitas produksi, margin, biaya variabel, atau anggaran total partisipasi.
3. Tolak sewa negatif, jarak nol/negatif, koordinat tidak valid, dan rentang tanggal/harga terbalik. Nol sewa berarti hanya mencari sewa gratis yang sudah dipastikan; kolom kosong tidak berarti nol.
4. Tampilkan petunjuk pada isian yang belum benar; perubahan data usaha digunakan pada pembukaan Beranda berikutnya.

# Kebutuhan 3 — Mengumpulkan informasi bazar

**User Story:** Sebagai admin, saya ingin mengumpulkan informasi dari akun publik pilihan agar katalog mudah diperbarui.

**Acceptance Criteria:**

1. Admin dapat mengatur sumber Instagram publik melalui Apify, menonaktifkannya, menjalankan pengambilan manual, serta menjadwalkan satu pengambilan harian untuk sumber aktif.
2. Catat sumber, waktu, hasil, dan jumlah kandidat. Pengambilan ulang unggahan sama tidak membuat data ganda, dan pencarian pengguna tidak memicu pengambilan.
3. AI/OCR membaca caption dan poster yang tersedia; detail tanpa bukti tetap belum tersedia. Semua kandidat menunggu pemeriksaan admin sebelum tampil ke pengguna.
4. Saat layanan gagal, katalog terakhir dan input manual tetap tersedia; admin dapat melihat dan menangani kegagalan.

# Kebutuhan 4 — Memeriksa dan menerbitkan bazar

**User Story:** Sebagai admin, saya ingin memeriksa informasi agar pengguna memperoleh keterangan yang jelas dan benar.

**Acceptance Criteria:**

1. Admin dapat membuat, mengubah, menggabungkan data ganda, menerbitkan, membatalkan, dan menarik bazar. Publikasi memerlukan nama, tanggal valid, tempat beserta koordinat, penyelenggara, dan referensi sumber.
2. Simpan harga sewa beserta jenis stan, satuan sumber, hari sewa, dan biaya tambahan. Gunakan aturan harga per hari pada R10; informasi yang belum jelas tidak ditebak.
3. Pemeriksaan berlaku untuk informasi tertentu, bukan jaminan seluruh bazar. Simpan sumber dan waktu konfirmasi; konflik tanggal/lokasi harus selesai sebelum publikasi, konflik lain ditandai belum pasti.
4. Penggabungan mempertahankan sumber dan data pengguna terkait. Catat pengubah, waktu, nilai lama/baru; pembaruan bersamaan tidak boleh menghapus perubahan orang lain.

# Kebutuhan 5 — Menjelajahi Katalog Bazar

**User Story:** Sebagai pemilik UMKM, saya ingin melihat dan menyaring semua bazar yang tersedia.

**Acceptance Criteria:**

1. Katalog menampilkan seluruh bazar terpublikasi yang belum berakhir dan tidak dibatalkan, termasuk yang tidak masuk tiga pilihan Beranda. Pencarian berdasarkan nama/tempat; filter tanggal, jenis produk, sewa per hari, jarak, dan fasilitas.
2. Kartu hanya menampilkan nama, tanggal, lokasi singkat, sewa per hari, dan satu keterangan penting bila perlu. Tombol utamanya “Lihat Bazar”; jarak ditampilkan jika lokasi asal tersedia.
3. Bazar dengan data filter yang belum tersedia ditempatkan di kelompok “Perlu ditanyakan” dan tidak dianggap memenuhi filter; ketidakcocokan yang sudah pasti tidak lolos filter aktif.
4. Jarak adalah garis lurus dalam kilometer dan diberi keterangan tersebut. Hasil kosong menampilkan “Belum ada bazar yang sesuai. Coba ubah pilihan pencarian.” tanpa menghapus data usaha.

# Kebutuhan 6 — Melihat informasi bazar

**User Story:** Sebagai pemilik UMKM, saya ingin membaca informasi penting lebih dulu dan membuka rincian bila diperlukan.

**Acceptance Criteria:**

1. Bagian awal detail menampilkan nama, tanggal, lokasi, sewa per hari, ketentuan hari sewa, status pendaftaran, serta tombol “Hubungi Penyelenggara” jika kontak ada. Biaya tambahan wajib dan kewajiban sewa paket terlihat tanpa membuka rincian.
2. Jenis produk yang diterima, fasilitas, penyelenggara, tenggat, serta sumber dan tanggal pemeriksaan tersedia di “Informasi Lainnya”. Nilai kosong menggunakan “Belum ada informasi”, tidak berubah menjadi gratis atau tidak ada fasilitas.
3. Setelah lebih dari tujuh hari tanpa pemeriksaan, tampilkan “Silakan pastikan kembali kepada penyelenggara.” Pengguna dapat memilih “Laporkan Informasi” dengan alasan; laporan menunggu admin dan tidak langsung mengubah data.
4. Jangan tampilkan angka likes/views, skor AI, persentase kelengkapan, atau istilah teknis kepada UMKM. Informasi sumber tetap dapat dibuka dan data contoh diberi label “Contoh”.

# Kebutuhan 7 — Menampilkan pilihan di Beranda

**User Story:** Sebagai pemilik UMKM, saya ingin menemukan beberapa bazar yang sesuai langsung dari Beranda.

**Acceptance Criteria:**

1. Beranda menampilkan maksimal tiga bazar berbeda di “Pilihan untuk Usaha Anda”, dengan tautan “Lihat Semua Bazar” menuju katalog. Tidak ada tab atau halaman rekomendasi terpisah.
2. Pilihan personal harus memenuhi kategori, seluruh tanggal tersedia, jarak, batas sewa harian, fasilitas wajib, dan pendaftaran terbuka. Data wajib belum pasti tidak masuk pilihan teratas; informasi tersebut tetap dapat ditemukan di katalog.
3. Urutan memakai aturan tetap yang dijelaskan dalam desain, dengan skor internal 0–100 dan bobot total 100. Data hilang tidak mendapat nilai tambahan; likes, laporan penjualan, dan AI tidak menentukan skor. Input dan versi aturan sama menghasilkan urutan sama, seri diurutkan menurut tanggal mulai lalu ID bazar.
4. Jika belum masuk atau data usaha belum lengkap, Beranda menampilkan “Bazar Mendatang” menurut tanggal dan ajakan “Lengkapi Usaha Saya”, tanpa mengaku personal. Jika hanya satu/dua pilihan sesuai, tampilkan jumlah itu; jika tidak ada, arahkan ke katalog tanpa mengisi dengan bazar yang tidak sesuai.

# Kebutuhan 8 — Menjelaskan alasan dengan singkat

**User Story:** Sebagai pemilik UMKM, saya ingin mengetahui alasan suatu bazar dipilih dengan kalimat yang mudah dipahami.

**Acceptance Criteria:**

1. Setiap pilihan Beranda menampilkan maksimal dua alasan singkat, misalnya “Dekat dari lokasi usaha” dan “Sewa sesuai anggaran”. Rincian alasan dapat dibuka di detail.
2. Semua alasan berdasarkan data atau hitungan yang dapat ditelusuri. Tidak ada janji ramai, laris, omzet, atau keuntungan. Peringatan penting tidak disembunyikan untuk memenuhi batas dua alasan.
3. AI hanya membantu memilih urutan alasan yang sudah sah; tidak mengubah urutan bazar atau angka. Jika AI gagal, alasan standar tetap tersedia dan halaman dapat dipakai.

# Kebutuhan 9 — Membandingkan pilihan bazar

**User Story:** Sebagai pemilik UMKM, saya ingin membandingkan beberapa bazar tanpa membaca terlalu banyak informasi.

**Acceptance Criteria:**

1. Pengguna dapat memilih dua atau tiga bazar berbeda dari katalog, detail, atau Tersimpan melalui tindakan “Bandingkan”; perbandingan bukan tab utama baru.
2. Tabel awal hanya berisi nama, tanggal, lokasi/jarak, sewa per hari, ketentuan hari sewa, dan fasilitas penting. Biaya tambahan wajib dan kondisi paket tetap terlihat; rincian lain dapat dibuka.
3. Nilai belum tersedia tetap diberi keterangan, pilihan dapat dihapus, detail dapat dibuka, dan tabel dapat digunakan di ponsel. Tidak ada skor atau angka kelengkapan pada tabel.

# Kebutuhan 10 — Menampilkan sewa stan per hari

**User Story:** Sebagai pemilik UMKM, saya ingin memahami sewa stan dalam satuan harian beserta ketentuannya.

**Acceptance Criteria:**

1. Semua harga utama dan batas anggaran menggunakan rupiah per hari, misalnya “Rp150.000/hari”. Pilihan jenis stan memiliki harga sendiri; harga gratis hanya jika sumber menyatakan gratis.
2. Jika sumber hanya memberi harga paket, nilai harian hanya dihitung bila total paket dan jumlah hari sewa yang dicakup jelas: total dibagi hari sewa. Labelnya “Setara Rp…/hari”; tampilkan “Wajib sewa … hari” dan harga paket asli. Nilai tersebut tidak berarti boleh menyewa satu hari.
3. Jika hari sewa/harga belum jelas, tampilkan “Tanyakan harga sewa” dan jangan masukkan ke pilihan yang pasti sesuai anggaran. Bila tarif berbeda antarhari, tampilkan rentang dan gunakan tarif harian tertinggi dalam periode wajib untuk batas anggaran.
4. Simpan nilai sumber; hitungan paket tidak membulat sebelum penyaringan, tampilan rupiah dibulatkan ke atas. Tampilkan biaya tambahan wajib terpisah dan jelaskan bila belum diketahui. Harga sewa harian bukan total seluruh biaya mengikuti bazar.

# Kebutuhan 11 — Menyimpan bazar

**User Story:** Sebagai pemilik UMKM, saya ingin menyimpan bazar agar mudah ditemukan kembali.

**Acceptance Criteria:**

1. Pengguna dapat menyimpan/menghapus bazar dari Tersimpan; satu bazar tidak muncul ganda dan pilihan tetap ada setelah masuk kembali.
2. Tersimpan menampilkan harga per hari dan status terbaru; bazar berakhir, dibatalkan, atau ditarik tetap diberi keterangan dan tidak dianggap aktif.
3. Tidak ada tombol kalkulator, target impas, maupun penyimpanan simulasi. Rekomendasi hanya berada di Beranda dan tidak menjadi tab Tersimpan.

# Kebutuhan 12 — Menceritakan pengalaman mengikuti bazar

**User Story:** Sebagai pemilik UMKM, saya ingin mencatat pengalaman agar dapat mempertimbangkannya pada kesempatan berikutnya.

**Acceptance Criteria:**

1. Setelah bazar berakhir, pengguna dapat membuat satu catatan per bazar melalui Tersimpan/detail. Isian awal hanya konfirmasi keikutsertaan dan pengalaman singkat; angka penjualan, unit, atau biaya aktual opsional di “Tambah Catatan”.
2. Pengguna dapat mengubah/menghapus catatannya. Nilai negatif dan rentang penjualan terbalik ditolak; informasi keuangan bersifat pribadi dan tidak digunakan untuk mengurutkan bazar.
3. Keikutsertaan hanya ditandai telah diperiksa setelah admin memeriksa bukti. Jika ringkasan pengalaman dipublikasikan, tampilkan jumlah laporan dan jumlah yang diperiksa, tanpa identitas atau keuangan individual.

# Kebutuhan 13 — Menjaga data pengguna

**User Story:** Sebagai pengguna, saya ingin data usaha dan catatan pribadi saya terlindungi.

**Acceptance Criteria:**

1. Lokasi asal, anggaran, catatan keuangan, dan bukti keikutsertaan tidak tampil publik; akses hanya bagi pemilik dan admin yang memerlukannya untuk pengelolaan.
2. Validasi dilakukan di server; kata sandi disimpan dengan hashing, layanan publik menggunakan HTTPS dan pembatasan percobaan masuk. Rahasia layanan tidak masuk browser, repositori publik, atau log.
3. Pengguna dapat menghapus akun beserta profil, Tersimpan, pengalaman, dan bukti pribadi; sesi dicabut dan catatan operasional tidak mempertahankan identitas yang dihapus.
4. Pengambilan hanya dari sumber publik pilihan admin; data lokasi/keuangan pribadi tidak dikirim ke layanan pengumpulan sosial.

# Kebutuhan 14 — Membuat semua halaman mudah dipahami

**User Story:** Sebagai pemilik UMKM, saya ingin memakai website dengan bahasa formal yang sederhana dan tampilan ringkas.

**Acceptance Criteria:**

1. Navigasi utama hanya “Beranda”, “Katalog Bazar”, “Tersimpan”, “Usaha Saya”. Detail, Bandingkan, dan catatan pengalaman dibuka dari tindakan terkait; akun masuk/keluar tersedia. Tidak ada halaman/tab Rekomendasi atau Kalkulator Impas.
2. Semua halaman, tombol, isian, heading, dan pesan menggunakan kalimat pendek yang formal dan mudah dipahami. Ganti “provenance” dengan “Sumber Informasi”, “eligible” dengan “Sesuai Pilihan Anda”, dan “unknown” dengan “Belum ada informasi”. Pesan untuk admin juga sederhana; detail teknis hanya pada log pengembang.
3. Utamakan informasi R5/R6/R9; informasi tambahan dibuka bila dibutuhkan. Jangan sembunyikan biaya wajib, kewajiban paket, pembatalan, atau ketidakpastian harga. Maksimal tiga pilihan personal dan dua alasan per pilihan di Beranda.
4. Semua alur berfungsi pada 360/768/1280 piksel, dengan keyboard, fokus terlihat, label/error dekat isian, alternatif teks, dan status tidak hanya berupa warna. Gunakan bahasa Indonesia, rupiah, WIB, serta keadaan memuat/kosong/berhasil/gagal yang jelas.

# Kebutuhan 15 — Menjaga website cepat dan siap dipakai

**User Story:** Sebagai pengguna, saya ingin membuka pilihan bazar tanpa menunggu pengambilan data atau AI.

**Acceptance Criteria:**

1. Dengan 500 bazar terpublikasi dan 20 pengguna bersamaan, 95% permintaan Beranda, katalog, detail, filter, dan pengurutan selesai di server dalam dua detik; unduhan aset dan pemilihan alasan AI diukur terpisah.
2. Beranda/katalog memakai data tersimpan dan tidak menunggu Apify/AI. Kegagalan provider dibatasi waktu, diberi pesan sederhana, dan tidak menghapus data terakhir atau menyembunyikan waktu pemeriksaannya.
3. Website memiliki URL live, repositori publik dengan petunjuk menjalankan dan konfigurasi contoh tanpa rahasia, serta label jelas untuk data contoh.