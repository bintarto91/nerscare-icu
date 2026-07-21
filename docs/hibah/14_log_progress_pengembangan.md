# Log Progress Pengembangan

## 1. Tujuan

Dokumen ini mencatat ringkasan progress pengembangan sistem dari awal sampai tahap siap demo/soft live. Dokumen ini dapat digunakan sebagai laporan pekerjaan developer kepada tim peneliti.

## 2. Ringkasan Status

Status saat ini: **siap demo/soft live**

Catatan:

- Fitur utama sudah berjalan.
- Booklet sudah admin-editable.
- Scoring sudah disesuaikan dengan De Jong Gierveld 11 item.
- Dokumen proyek dan hibah sudah disiapkan.
- Proofread konten dan UAT final masih perlu dilakukan sebelum live real.

## 3. Progress Modul

| No | Modul | Status | Catatan |
|---:|---|---|---|
| 1 | Setup project Laravel | Selesai | Aplikasi web berjalan |
| 2 | Database dasar | Selesai | Migration tersedia |
| 3 | Login dan role | Selesai | Admin/perawat/keluarga |
| 4 | Dashboard | Selesai | Ringkasan data tersedia |
| 5 | Data pasien | Selesai | Kriteria kelayakan assessment tersedia |
| 6 | Assessment loneliness | Selesai | 11 item De Jong Gierveld |
| 7 | Scoring total | Selesai | Kategori umum tersedia |
| 8 | Emotional/social loneliness | Selesai | Dimensi dominan tersedia |
| 9 | Hasil dan riwayat | Selesai | Detail hasil tersedia |
| 10 | Cetak laporan | Selesai | Format laporan tersedia |
| 11 | Edukasi perawat | Selesai | Konten dapat dikelola |
| 12 | Edukasi keluarga | Selesai | Konten dapat dikelola |
| 13 | Landing page | Selesai | Sudah disesuaikan revisi |
| 14 | Kalkulator public | Selesai | Tidak menyimpan data |
| 15 | Booklet digital | Selesai | Auto flip/manual |
| 16 | Admin booklet | Selesai | CRUD halaman booklet |
| 17 | Pengaturan landing | Selesai | Teks landing dapat dikelola |
| 18 | Pengaturan laporan | Selesai | Teks laporan dapat dikelola |
| 19 | Manajemen pertanyaan | Selesai | Pertanyaan aktif/urutan dapat diatur |
| 20 | Dokumen hibah | Selesai draft | RAB, kontrak, KAK, teknis, manual, UAT |

## 4. Revisi yang Sudah Diakomodasi

| Revisi | Status |
|---|---|
| Tombol cek loneliness kanan atas landing dihapus | Selesai |
| Kalkulator tetap ada di landing bagian bawah/CTA | Selesai |
| Assessment menggunakan De Jong Gierveld 11 item | Selesai |
| Appendix dan short scale tidak digarap | Selesai |
| Kategori sementara di assessment disesuaikan | Selesai |
| Emotional loneliness dan social loneliness ditampilkan | Selesai |
| Kategori lain menampilkan dimensi yang lebih tinggi | Selesai |
| Booklet digital di landing | Selesai |
| Booklet bisa otomatis dan manual | Selesai |
| Isi booklet bisa dikelola admin | Selesai |
| Dokumen RAB dibuat | Selesai |
| Draft kontrak dibuat | Selesai |
| Dokumen teknis dan dokumen proyek dibuat | Selesai draft |

## 5. Hal yang Perlu Dilakukan Berikutnya

| No | Pekerjaan | Penanggung Jawab | Prioritas |
|---:|---|---|---|
| 1 | Proofread isi booklet dan edukasi | Tim peneliti/ahli substansi | Tinggi |
| 2 | UAT admin dan perawat | Tim peneliti + developer | Tinggi |
| 3 | Tes mobile landing, booklet, kalkulator | Developer + tim peneliti | Tinggi |
| 4 | Backup database server | Developer/admin teknis | Tinggi |
| 5 | Finalisasi dokumen kontrak | Developer + peneliti | Sedang |
| 6 | Finalisasi manual book sesuai template institusi | Developer + peneliti | Sedang |
| 7 | Pelatihan pengguna | Developer + peneliti | Sedang |

## 6. Catatan Developer

Sistem sudah cukup matang untuk ditunjukkan ke klien/peneliti. Untuk live pemakaian real, prioritas bukan menambah fitur besar, melainkan memastikan isi ilmiah, alur penggunaan, akses role, dan tampilan mobile sudah lolos UAT.
