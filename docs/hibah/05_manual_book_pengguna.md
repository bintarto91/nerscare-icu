# Manual Book Pengguna

## 1. Pendahuluan

AI-Assisted Assessment ICU Loneliness adalah aplikasi web untuk membantu proses assessment loneliness pasien ICU, membaca hasil awal, menyiapkan edukasi, dan mendokumentasikan hasil assessment.

Sistem ini adalah alat bantu assessment dan edukasi. Interpretasi tetap perlu disesuaikan dengan kondisi klinis pasien dan clinical judgement petugas.

## 2. Role Pengguna

### Admin

Admin memiliki akses untuk mengatur:

- Pengguna
- Pertanyaan assessment
- Interpretasi
- Konten edukasi
- Landing page
- Laporan
- Booklet landing

### Petugas/Perawat

Petugas/perawat memiliki akses untuk:

- Melihat dashboard
- Mengelola data pasien
- Melakukan assessment loneliness
- Melihat hasil dan riwayat assessment
- Mencetak laporan
- Melihat materi edukasi

### Keluarga

Keluarga dapat diarahkan untuk membaca materi edukasi keluarga sesuai akses yang diberikan.

### Pengunjung Public

Pengunjung public dapat:

- Membaca landing page
- Membuka booklet edukasi
- Mencoba kalkulator loneliness public

## 3. Panduan Admin

### 3.1 Login

1. Buka halaman login.
2. Masukkan email dan password.
3. Klik tombol masuk.
4. Jika berhasil, sistem menampilkan dashboard.

### 3.2 Mengelola Booklet Landing

1. Login sebagai admin.
2. Buka menu `Administrator > Booklet Landing`.
3. Klik `Tambah Halaman` untuk menambah halaman baru.
4. Isi:
   - Label halaman
   - Urutan
   - Judul halaman
   - Isi singkat
   - Poin halaman
   - Status aktif
5. Klik simpan.
6. Buka landing page untuk melihat hasil.

Catatan:

- Halaman aktif akan tampil di landing page.
- Urutan angka kecil tampil lebih dulu.
- Satu halaman booklet idealnya berisi teks singkat agar nyaman dibaca di HP.

### 3.3 Mengelola Pertanyaan Assessment

1. Buka menu `Manajemen Pertanyaan`.
2. Tambah atau edit pertanyaan.
3. Atur urutan sesuai instrumen.
4. Pastikan status aktif.
5. Simpan perubahan.

Catatan:

- Urutan pertanyaan memengaruhi perhitungan emotional/social loneliness.
- Untuk De Jong Gierveld 11 item, jangan mengubah urutan tanpa validasi tim peneliti.

### 3.4 Mengelola Edukasi

1. Buka menu `Manajemen Konten`.
2. Tambah atau edit materi edukasi.
3. Tentukan target pembaca: perawat atau keluarga.
4. Aktifkan materi agar tampil.

### 3.5 Mengelola Pengaturan Landing dan Laporan

1. Buka `Pengaturan Landing` untuk mengubah teks public.
2. Buka `Pengaturan Laporan` untuk mengubah identitas laporan.
3. Simpan perubahan.

## 4. Panduan Petugas/Perawat

### 4.1 Menambah Data Pasien

1. Login sebagai petugas/perawat.
2. Buka menu `Data Pasien`.
3. Klik tambah pasien.
4. Isi data pasien dan informasi ICU.
5. Pastikan status kelayakan assessment:
   - pasien sadar,
   - mampu berkomunikasi,
   - memahami pertanyaan,
   - bersedia mengikuti assessment.
6. Simpan data.

### 4.2 Melakukan Assessment

1. Buka menu `Assessment Loneliness`.
2. Pilih pasien yang siap assessment.
3. Klik `Mulai Assessment`.
4. Isi seluruh pertanyaan.
5. Periksa total skor sementara.
6. Klik simpan/lihat hasil.

### 4.3 Membaca Hasil

Hasil assessment menampilkan:

- Total skor loneliness
- Kategori umum
- Emotional loneliness
- Social loneliness
- Kategori lain yang lebih dominan
- Interpretasi
- Rekomendasi edukasi untuk perawat
- Rekomendasi edukasi untuk keluarga

### 4.4 Mencetak Laporan

1. Buka hasil assessment.
2. Klik cetak laporan.
3. Periksa tampilan print.
4. Cetak atau simpan sebagai PDF.

## 5. Panduan Keluarga

Keluarga dapat membaca materi edukasi yang diberikan petugas. Materi edukasi berisi dukungan komunikasi dan pendampingan emosional yang sesuai dengan kondisi pasien ICU.

Keluarga tetap mengikuti arahan petugas kesehatan dan kebijakan ruang ICU.

## 6. Panduan Pengunjung Public

### 6.1 Membuka Kalkulator Public

1. Buka landing page.
2. Klik `Coba Kalkulator Loneliness`.
3. Isi 11 pertanyaan.
4. Klik lihat hasil.

Catatan:

- Hasil kalkulator public hanya edukatif.
- Jawaban tidak disimpan ke database.
- Hasil tidak menggantikan penilaian klinis.

### 6.2 Membuka Booklet Edukasi

1. Buka landing page.
2. Scroll ke bagian booklet.
3. Booklet akan membuka halaman otomatis.
4. Gunakan tombol panah untuk membuka manual.

## 7. Troubleshooting Singkat

| Masalah | Solusi |
|---|---|
| Tidak bisa login | Periksa email/password atau hubungi admin |
| Pasien tidak muncul di assessment | Periksa status kelayakan pasien |
| Hasil tidak muncul | Pastikan semua pertanyaan dijawab |
| Landing belum berubah | Clear cache browser/server |
| Booklet tidak berubah | Pastikan halaman booklet aktif dan sudah disimpan |

## 8. Catatan Klinis

Sistem membantu dokumentasi awal. Keputusan klinis tetap disesuaikan dengan kondisi pasien, observasi perawat, kebijakan ICU, dan pertimbangan tenaga kesehatan.
