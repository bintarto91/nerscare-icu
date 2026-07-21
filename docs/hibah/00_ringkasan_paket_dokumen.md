# Ringkasan Paket Dokumen Hibah Penelitian

## Nama Sistem

AI-Assisted Assessment ICU Loneliness

## Tujuan Paket Dokumen

Dokumen ini disiapkan sebagai bahan administrasi, teknis, dan pertanggungjawaban pengembangan aplikasi web untuk proyek hibah penelitian. Paket ini dapat dipakai oleh developer, peneliti, pembimbing, reviewer hibah, maupun pihak institusi/rumah sakit untuk memahami ruang lingkup pekerjaan, biaya, timeline, dan output sistem.

## Isi Dokumen

1. `01_kak_teknis_pengembangan.md`
   Kerangka Acuan Kerja teknis pengembangan sistem.

2. `02_rab_pengembangan_aplikasi.md`
   Rencana Anggaran Biaya untuk pekerjaan developer sampai tahap saat ini dan tahap live awal.

3. `03_timeline_pekerjaan.md`
   Jadwal kerja dari analisis kebutuhan sampai deployment dan serah terima.

4. `04_dokumen_teknis_sistem.md`
   Ringkasan teknis aplikasi, modul, database, deployment, keamanan, dan backup.

5. `05_manual_book_pengguna.md`
   Panduan penggunaan untuk admin, petugas/perawat, keluarga, dan pengunjung public.

6. `06_rencana_uji_coba_uat.md`
   Daftar skenario uji coba/UAT untuk memastikan sistem siap digunakan.

7. `07_serah_terima_maintenance.md`
   Draft serah terima pekerjaan, ruang lingkup support, dan maintenance.

8. `08_checklist_kesiapan_penelitian.md`
   Checklist non-teknis yang perlu disiapkan untuk konteks penelitian kesehatan.

9. `09_draft_kontrak_developer_peneliti.md`
   Draft kontrak kerja antara developer dan tim peneliti/klien, termasuk scope, RAB, termin pembayaran, revisi, maintenance, kerahasiaan data, dan serah terima.

10. `10_spesifikasi_kebutuhan_sistem_srs.md`
    Spesifikasi kebutuhan sistem atau SRS, berisi kebutuhan fungsional dan non-fungsional.

11. `11_arsitektur_dan_alur_sistem.md`
    Dokumen arsitektur, diagram alur sistem, role, dan proses assessment/booklet.

12. `12_skema_database.md`
    Ringkasan tabel database, relasi utama, dan catatan skoring.

13. `13_sop_deployment_backup.md`
    SOP upload perubahan, migration, clear cache, backup, dan verifikasi server.

14. `14_log_progress_pengembangan.md`
    Catatan progress pengembangan, status modul, revisi yang sudah selesai, dan next step.

15. `15_matriks_kesesuaian_revisi.md`
    Matriks kesesuaian revisi klien, PDF/manual, dan implementasi sistem.

## Status Sistem Saat Ini

Sistem sudah berada pada tahap siap demo/soft live, dengan catatan:

- Modul landing page, kalkulator public, login, dashboard, data pasien, assessment, hasil/riwayat, edukasi, laporan, dan booklet sudah tersedia.
- Instrumen assessment sudah disesuaikan dengan De Jong Gierveld Loneliness Scale 11 item.
- Hasil assessment sudah menampilkan total skor, kategori umum, emotional loneliness, social loneliness, dan kategori lain yang lebih dominan.
- Booklet landing sudah dapat dikelola dari dashboard admin.
- Proofread final isi booklet/manual edukasi tetap perlu dilakukan oleh tim peneliti atau ahli substansi.
- Uji coba mobile, UAT pengguna, dan backup database perlu dilakukan sebelum live pemakaian real.

## Catatan Penggunaan

Dokumen ini masih berupa draft kerja. Untuk kebutuhan pengajuan hibah atau laporan akhir, isi dokumen dapat dipindahkan ke format Word/PDF sesuai template institusi.
