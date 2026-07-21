# Dokumen Teknis Sistem

## 1. Nama Sistem

AI-Assisted Assessment ICU Loneliness

## 2. Teknologi

| Komponen | Teknologi |
|---|---|
| Backend | PHP Laravel |
| Frontend | Blade, HTML, CSS, JavaScript |
| Database | MySQL/MariaDB |
| Server | VPS/CloudPanel |
| Deployment | SFTP dan command server |
| Authentication | Login Laravel/session |
| PWA ringan | Service worker |

## 3. Modul Sistem

### 3.1 Public

- Landing page
- Kalkulator loneliness public
- Booklet digital
- Login petugas

### 3.2 Petugas/Perawat

- Dashboard
- Data pasien
- Pilih pasien untuk assessment
- Form assessment
- Hasil assessment
- Riwayat assessment
- Follow-up
- Cetak laporan
- Edukasi perawat
- Edukasi keluarga

### 3.3 Admin

- Manajemen pengguna
- Manajemen konten edukasi
- Pengaturan interpretasi
- Manajemen pertanyaan
- Pengaturan landing
- Pengaturan laporan
- Booklet landing

## 4. Struktur Data Utama

Tabel utama yang digunakan:

- `users`
- `patients`
- `assessments`
- `assessment_answers`
- `assessment_questions`
- `assessment_interpretations`
- `education_contents`
- `site_settings`
- `booklet_pages`
- `sessions`
- `jobs`
- `failed_jobs`
- `migrations`

## 5. Alur Assessment

1. Petugas login.
2. Petugas membuka menu Assessment Loneliness.
3. Sistem menampilkan pasien yang memenuhi kriteria assessment.
4. Petugas memilih pasien.
5. Petugas mengisi 11 item kuesioner.
6. Sistem menghitung:
   - skor per item,
   - total skor,
   - emotional loneliness,
   - social loneliness,
   - kategori umum,
   - kategori lain yang lebih dominan.
7. Sistem menyimpan hasil assessment.
8. Petugas melihat detail hasil.
9. Petugas dapat mencetak laporan.

## 6. Aturan Skoring De Jong Gierveld

Jumlah item: 11.

Dimensi emotional loneliness:

- Item 2
- Item 3
- Item 5
- Item 6
- Item 9
- Item 10

Dimensi social loneliness:

- Item 1
- Item 4
- Item 7
- Item 8
- Item 11

Skor emotional:

- Jawaban 3, 4, 5 dihitung 1.
- Jawaban 1, 2 dihitung 0.

Skor social:

- Jawaban 1, 2, 3 dihitung 1.
- Jawaban 4, 5 dihitung 0.

Kategori total skor:

- 0-2: Not lonely
- 3-8: Moderate lonely
- 9-10: Severe lonely
- 11: Very severe lonely

## 7. Keamanan dan Privasi

Rekomendasi keamanan:

- Gunakan HTTPS.
- Password pengguna tidak dibagikan secara terbuka.
- Akun admin dibatasi.
- Backup database berkala.
- Jangan menampilkan data identitas pasien secara berlebihan pada halaman public.
- Gunakan data penelitian sesuai izin etik.
- Batasi akses server dan SFTP hanya untuk developer/admin teknis.

## 8. Deployment Server

Command umum setelah upload perubahan:

```bash
php artisan migrate --force
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

Jika ingin optimasi setelah semua stabil:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 9. Backup

Backup yang perlu disiapkan:

- Backup database sebelum update besar.
- Backup source code.
- Backup file `.env`.
- Backup folder upload jika ada.

Minimal backup dilakukan:

- sebelum live,
- sebelum migration,
- sebelum revisi besar,
- setelah UAT diterima.

## 10. Risiko Teknis

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Migration belum dijalankan | Fitur baru error | Jalankan `php artisan migrate --force` |
| Cache lama | Tampilan tidak berubah | Jalankan clear cache dan refresh browser |
| Data pasien sensitif | Risiko privasi | Batasi akses, gunakan izin etik, backup aman |
| Konten belum proofread | Salah interpretasi edukasi | Validasi oleh tim peneliti/ahli |
| Tampilan mobile belum diuji | Pengguna HP kurang nyaman | UAT mobile sebelum live |

## 11. Status Teknis Saat Ini

Sistem sudah siap untuk demo dan soft live. Tahap berikutnya adalah QA akhir, proofread konten, dan UAT pengguna.
