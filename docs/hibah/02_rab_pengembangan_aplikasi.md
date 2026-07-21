# Rencana Anggaran Biaya Pengembangan Aplikasi

## 1. Nama Kegiatan

Pengembangan Web AI-Assisted Assessment ICU Loneliness untuk Proyek Hibah Penelitian.

## 2. Catatan RAB

RAB ini adalah draft estimasi untuk pekerjaan developer sampai tahap sistem siap demo/soft live dan persiapan live awal. Nominal dapat disesuaikan dengan pagu hibah, kebijakan institusi, dan kesepakatan kontrak.

RAB ini tidak termasuk:

- Biaya ethical clearance.
- Biaya administrasi rumah sakit/institusi.
- Honor enumerator atau pengumpul data.
- Biaya publikasi jurnal.
- Biaya perjalanan penelitian.
- Biaya domain/hosting jika sudah disediakan oleh klien.
- Biaya proofread ilmiah oleh pakar substansi.

## 3. RAB Versi Standar

| No | Komponen Pekerjaan | Output | Volume | Satuan | Estimasi Biaya | Total |
|---:|---|---|---:|---|---:|---:|
| 1 | Analisis kebutuhan sistem | Alur sistem, daftar fitur, role pengguna | 1 | paket | Rp750.000 | Rp750.000 |
| 2 | Desain UI/UX awal | Landing, login, dashboard, assessment, hasil | 1 | paket | Rp900.000 | Rp900.000 |
| 3 | Pengembangan backend dan database | Struktur database, model, controller, route | 1 | paket | Rp1.500.000 | Rp1.500.000 |
| 4 | Modul landing page dan kalkulator public | Landing, booklet area, kalkulator tanpa login | 1 | paket | Rp1.000.000 | Rp1.000.000 |
| 5 | Modul login, role, dan dashboard | Login, menu role, ringkasan dashboard | 1 | paket | Rp750.000 | Rp750.000 |
| 6 | Modul data pasien | CRUD pasien dan kelayakan assessment | 1 | paket | Rp750.000 | Rp750.000 |
| 7 | Modul assessment loneliness | 11 item, scoring, emotional/social loneliness | 1 | paket | Rp1.200.000 | Rp1.200.000 |
| 8 | Modul hasil, riwayat, follow-up, dan cetak laporan | Riwayat assessment dan print hasil | 1 | paket | Rp950.000 | Rp950.000 |
| 9 | Modul edukasi perawat dan keluarga | Manajemen dan tampilan materi edukasi | 1 | paket | Rp650.000 | Rp650.000 |
| 10 | Modul booklet digital admin-editable | CRUD halaman booklet dan tampilan landing | 1 | paket | Rp800.000 | Rp800.000 |
| 11 | Testing, revisi, dan debugging | Perbaikan bug dan penyesuaian revisi klien | 1 | paket | Rp900.000 | Rp900.000 |
| 12 | Deployment dan konfigurasi server | Upload, migration, cache, konfigurasi awal | 1 | paket | Rp500.000 | Rp500.000 |
| 13 | Dokumentasi teknis dan manual book | Dokumen teknis, manual, UAT, serah terima | 1 | paket | Rp850.000 | Rp850.000 |

**Total estimasi pengembangan: Rp11.500.000**

## 4. Opsional Maintenance

| No | Komponen | Output | Volume | Satuan | Estimasi Biaya | Total |
|---:|---|---|---:|---|---:|---:|
| 1 | Maintenance ringan | Bug fixing kecil, backup check, bantuan operasional | 3 | bulan | Rp500.000 | Rp1.500.000 |
| 2 | Maintenance sedang | Revisi minor UI/konten, monitoring, support pengguna | 3 | bulan | Rp750.000 | Rp2.250.000 |
| 3 | Maintenance penuh | Revisi fitur kecil, support prioritas, laporan teknis bulanan | 3 | bulan | Rp1.200.000 | Rp3.600.000 |

Rekomendasi untuk hibah penelitian: **maintenance sedang 3 bulan**.

## 5. Skema Pembayaran yang Disarankan

| Tahap | Persentase | Nilai | Keterangan |
|---|---:|---:|---|
| DP / Awal pekerjaan | 30% | Rp3.450.000 | Setelah scope disepakati |
| Progress development | 40% | Rp4.600.000 | Setelah modul utama berjalan |
| UAT dan deployment | 20% | Rp2.300.000 | Setelah sistem diuji di server |
| Serah terima | 10% | Rp1.150.000 | Setelah dokumen dan source diserahkan |

## 6. Catatan Developer

RAB ini dapat disesuaikan menjadi lebih rendah atau lebih tinggi tergantung:

- Jumlah revisi desain.
- Jumlah role pengguna.
- Kompleksitas laporan.
- Kebutuhan import/export data.
- Kebutuhan audit log.
- Kebutuhan integrasi sistem rumah sakit.
- Lama maintenance.
- Format dokumen akhir yang diminta institusi.
