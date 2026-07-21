# SOP Deployment dan Backup

## 1. Tujuan

Dokumen ini menjelaskan langkah standar untuk upload perubahan aplikasi ke server, menjalankan migration, membersihkan cache, dan melakukan backup.

## 2. Pihak yang Berwenang

- Developer
- Admin teknis server
- Tim IT yang ditunjuk peneliti/institusi

## 3. Persiapan Sebelum Deployment

Checklist:

- [ ] Perubahan sudah diuji lokal.
- [ ] File baru sudah ikut ter-upload.
- [ ] Backup database tersedia.
- [ ] Akses server tersedia.
- [ ] Akses panel/SSH tersedia.
- [ ] Waktu deployment disepakati.
- [ ] Pengguna diberitahu jika ada downtime.

## 4. Backup Database

Contoh backup via command server:

```bash
mysqldump -u USER_DATABASE -p NAMA_DATABASE > backup_nerscare_icu_YYYYMMDD.sql
```

Catatan:

- Ganti `USER_DATABASE` dan `NAMA_DATABASE` sesuai server.
- Simpan file backup di lokasi aman.
- Jangan membagikan file backup secara public.

## 5. Upload File

Metode upload:

- SFTP dari VS Code.
- Upload manual via panel.
- Git pull jika repository server disiapkan.

Checklist upload:

- [ ] File controller baru ter-upload.
- [ ] File model baru ter-upload.
- [ ] File migration baru ter-upload.
- [ ] File view baru ter-upload.
- [ ] File route ter-upload.
- [ ] File public/service-worker jika berubah ter-upload.

## 6. Command Setelah Upload

Masuk ke folder project server:

```bash
cd /home/nama-user/htdocs/nama-domain.com
```

Jalankan migration:

```bash
php artisan migrate --force
```

Clear cache:

```bash
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

Opsional setelah stabil:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7. Verifikasi Setelah Deployment

Checklist:

- [ ] Landing page terbuka.
- [ ] Booklet tampil.
- [ ] Kalkulator public berjalan.
- [ ] Login admin berjalan.
- [ ] Menu Booklet Landing muncul.
- [ ] Tambah/edit booklet bisa dilakukan.
- [ ] Assessment berjalan.
- [ ] Hasil assessment tampil.
- [ ] Cetak laporan berjalan.
- [ ] Tidak ada error 500.

## 8. Rollback Sederhana

Jika terjadi error setelah deployment:

1. Catat error yang muncul.
2. Clear cache terlebih dahulu.
3. Jika error berasal dari file baru, upload ulang file versi benar.
4. Jika error berasal dari migration, cek struktur database dan migration status.
5. Jika perlu, restore database dari backup.

Command cek migration:

```bash
php artisan migrate:status
```

## 9. SOP Backup Berkala

Rekomendasi backup:

- Backup sebelum deployment.
- Backup setelah UAT diterima.
- Backup mingguan selama penelitian berjalan.
- Backup sebelum export/olah data.

Yang dibackup:

- Database.
- Source code.
- File `.env`.
- File upload jika ada.
- Dokumen proyek.

## 10. Keamanan Akses

- Jangan membagikan password server ke pihak yang tidak berkepentingan.
- Gunakan password kuat.
- Simpan `.env` secara aman.
- Batasi akun admin.
- Cabut akses developer jika kontrak selesai dan tidak ada maintenance lanjutan.

## 11. Catatan Khusus Mobile/PWA

Jika tampilan mobile belum berubah setelah deployment:

1. Clear cache browser.
2. Tutup dan buka ulang browser.
3. Jika menggunakan PWA/service worker, lakukan hard refresh atau clear site data.
4. Pastikan `public/service-worker.js` terbaru sudah ter-upload.
