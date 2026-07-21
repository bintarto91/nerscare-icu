# Timeline Pekerjaan Pengembangan Sistem

## 1. Catatan

Timeline ini disusun untuk menggambarkan alur pengembangan dari awal sampai sistem siap demo/soft live. Tanggal dapat disesuaikan dengan tanggal kontrak atau jadwal hibah.

## 2. Timeline Standar 6 Minggu

| Minggu | Tahap | Aktivitas | Output |
|---:|---|---|---|
| 1 | Analisis kebutuhan | Diskusi fitur, role pengguna, alur penelitian, kebutuhan data pasien, kebutuhan laporan | Scope fitur dan alur sistem |
| 1 | Perancangan awal | Penyusunan struktur menu, alur landing, alur assessment, dan rancangan database awal | Draft desain sistem |
| 2 | Pengembangan dasar | Setup Laravel, database, login, role, dashboard, layout utama | Aplikasi dasar berjalan |
| 2-3 | Modul pasien dan assessment | CRUD pasien, kelayakan assessment, instrumen 11 item, scoring | Modul assessment berjalan |
| 3 | Modul hasil dan laporan | Hasil skor, kategori, emotional/social loneliness, riwayat, cetak laporan | Modul hasil dan print |
| 4 | Modul edukasi dan admin | Edukasi perawat/keluarga, manajemen konten, pengaturan landing/laporan | Konten dapat dikelola admin |
| 4-5 | Landing dan kalkulator public | Landing page, kalkulator public, disclaimer, booklet edukasi | Public page berjalan |
| 5 | Booklet digital | Booklet interaktif dan admin CRUD halaman booklet | Booklet editable dari admin |
| 5-6 | Testing dan revisi | Perbaikan UI, revisi scoring, validasi alur, tes mobile dasar | Sistem siap demo |
| 6 | Deployment dan dokumentasi | Upload ke server, migration, view cache, manual book, UAT checklist | Soft live dan dokumen |

## 3. Status Saat Ini

| Modul | Status |
|---|---|
| Landing page | Selesai, perlu review visual final |
| Kalkulator public | Selesai |
| Login petugas | Selesai |
| Dashboard | Selesai |
| Data pasien | Selesai |
| Assessment loneliness | Selesai, sudah De Jong Gierveld 11 item |
| Emotional/Social loneliness | Selesai |
| Hasil dan riwayat | Selesai |
| Cetak laporan | Selesai |
| Edukasi perawat/keluarga | Selesai, perlu finalisasi konten |
| Booklet digital | Selesai, sudah bisa dikelola admin |
| Dokumentasi hibah | Draft dibuat |
| UAT pengguna | Belum final |
| Proofread konten | Belum final |
| Live real | Menunggu QA akhir |

## 4. Rekomendasi Tahap Berikutnya

### Tahap 1: Proofread Konten

- Cek kalimat pertanyaan.
- Cek istilah emotional loneliness dan social loneliness.
- Cek isi booklet.
- Cek disclaimer klinis.

### Tahap 2: UAT Pengguna

- Admin mencoba mengatur booklet.
- Petugas mencoba menambah pasien.
- Petugas mencoba assessment.
- Petugas mencetak laporan.
- Pengunjung mencoba kalkulator public.
- Keluarga melihat edukasi.

### Tahap 3: Persiapan Live

- Backup database.
- Cek `.env` server.
- Cek migration.
- Clear cache.
- Tes di desktop dan HP.
- Buat akun pengguna final.
- Serah terima dokumen.
