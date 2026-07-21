# Spesifikasi Kebutuhan Sistem

## 1. Identitas Dokumen

Nama sistem: AI-Assisted Assessment ICU Loneliness

Jenis dokumen: Software Requirements Specification (SRS)

Versi: Draft 1.0

Tujuan: Menjelaskan kebutuhan fungsional dan non-fungsional aplikasi untuk proyek hibah penelitian.

## 2. Tujuan Sistem

Sistem dikembangkan untuk membantu proses assessment loneliness pasien ICU secara digital, terstruktur, terdokumentasi, dan dilengkapi edukasi untuk perawat serta keluarga.

Sistem juga menyediakan halaman public untuk edukasi awal, kalkulator simulasi, dan booklet digital.

## 3. Pengguna Sistem

| Role | Hak Akses Utama |
|---|---|
| Admin | Mengelola pengguna, konten, pertanyaan, interpretasi, landing, laporan, dan booklet |
| Perawat/Petugas | Mengelola pasien, melakukan assessment, membaca hasil, mencetak laporan, membaca edukasi |
| Keluarga | Membaca edukasi keluarga sesuai akses |
| Pengunjung Public | Membaca landing, booklet, dan memakai kalkulator public |

## 4. Kebutuhan Fungsional

### 4.1 Modul Public

| ID | Kebutuhan |
|---|---|
| F-PUB-01 | Sistem menampilkan landing page public. |
| F-PUB-02 | Sistem menampilkan informasi tujuan aplikasi. |
| F-PUB-03 | Sistem menyediakan tombol menuju kalkulator public. |
| F-PUB-04 | Sistem menyediakan tombol login petugas. |
| F-PUB-05 | Sistem menampilkan booklet digital interaktif. |
| F-PUB-06 | Booklet dapat membuka halaman otomatis. |
| F-PUB-07 | Booklet dapat dibuka manual oleh pengguna. |

### 4.2 Modul Kalkulator Public

| ID | Kebutuhan |
|---|---|
| F-CAL-01 | Sistem menampilkan 11 item kuesioner. |
| F-CAL-02 | Sistem menyediakan 5 pilihan jawaban untuk setiap item. |
| F-CAL-03 | Sistem menghitung total skor loneliness. |
| F-CAL-04 | Sistem menghitung emotional loneliness dan social loneliness. |
| F-CAL-05 | Sistem menampilkan kategori umum. |
| F-CAL-06 | Sistem menampilkan dimensi yang lebih dominan. |
| F-CAL-07 | Jawaban kalkulator public tidak disimpan ke database. |

### 4.3 Modul Auth dan Role

| ID | Kebutuhan |
|---|---|
| F-AUTH-01 | Pengguna dapat login menggunakan email dan password. |
| F-AUTH-02 | Pengguna dapat logout. |
| F-AUTH-03 | Sistem membedakan akses berdasarkan role. |
| F-AUTH-04 | Admin dapat mengelola pengguna. |

### 4.4 Modul Data Pasien

| ID | Kebutuhan |
|---|---|
| F-PAS-01 | Petugas dapat menambah data pasien. |
| F-PAS-02 | Petugas dapat mengedit data pasien. |
| F-PAS-03 | Petugas dapat melihat detail pasien. |
| F-PAS-04 | Petugas dapat menghapus data pasien sesuai kewenangan. |
| F-PAS-05 | Sistem mencatat kelayakan assessment: sadar, mampu berkomunikasi, memahami pertanyaan, dan bersedia. |

### 4.5 Modul Assessment

| ID | Kebutuhan |
|---|---|
| F-ASM-01 | Sistem menampilkan daftar pasien yang siap assessment. |
| F-ASM-02 | Petugas dapat memulai assessment pada pasien terpilih. |
| F-ASM-03 | Sistem menampilkan 11 pertanyaan De Jong Gierveld. |
| F-ASM-04 | Sistem menghitung skor item otomatis. |
| F-ASM-05 | Sistem menghitung total skor. |
| F-ASM-06 | Sistem menghitung emotional loneliness. |
| F-ASM-07 | Sistem menghitung social loneliness. |
| F-ASM-08 | Sistem menyimpan hasil assessment. |
| F-ASM-09 | Sistem menampilkan interpretasi dan rekomendasi. |

### 4.6 Modul Hasil dan Laporan

| ID | Kebutuhan |
|---|---|
| F-HSL-01 | Sistem menampilkan riwayat assessment. |
| F-HSL-02 | Sistem menampilkan detail hasil assessment. |
| F-HSL-03 | Sistem menampilkan rekomendasi edukasi. |
| F-HSL-04 | Sistem menyediakan fitur cetak laporan. |
| F-HSL-05 | Sistem menyediakan follow-up/tindak lanjut assessment. |

### 4.7 Modul Edukasi

| ID | Kebutuhan |
|---|---|
| F-EDU-01 | Sistem menampilkan edukasi perawat. |
| F-EDU-02 | Sistem menampilkan edukasi keluarga. |
| F-EDU-03 | Admin dapat menambah, mengedit, dan menghapus konten edukasi. |
| F-EDU-04 | Admin dapat menentukan status publikasi konten. |

### 4.8 Modul Booklet Landing

| ID | Kebutuhan |
|---|---|
| F-BOK-01 | Admin dapat menambah halaman booklet. |
| F-BOK-02 | Admin dapat mengedit halaman booklet. |
| F-BOK-03 | Admin dapat menghapus halaman booklet. |
| F-BOK-04 | Admin dapat mengaktifkan/menonaktifkan halaman booklet. |
| F-BOK-05 | Landing page menampilkan halaman booklet aktif berdasarkan urutan. |

### 4.9 Modul Pengaturan

| ID | Kebutuhan |
|---|---|
| F-SET-01 | Admin dapat mengatur teks landing. |
| F-SET-02 | Admin dapat mengatur teks laporan. |
| F-SET-03 | Admin dapat mengatur interpretasi. |
| F-SET-04 | Admin dapat mengatur pertanyaan assessment. |

## 5. Kebutuhan Non-Fungsional

| ID | Kebutuhan |
|---|---|
| NF-01 | Sistem berjalan pada web browser modern. |
| NF-02 | Sistem dapat digunakan pada desktop dan mobile. |
| NF-03 | Akses dashboard membutuhkan login. |
| NF-04 | Data public tidak menampilkan data pasien. |
| NF-05 | Password pengguna disimpan dalam bentuk hash. |
| NF-06 | Sistem menggunakan HTTPS pada server production. |
| NF-07 | Sistem mendukung backup database berkala. |
| NF-08 | Tampilan dibuat sederhana, profesional, dan sesuai konteks kesehatan. |
| NF-09 | Sistem menyediakan disclaimer bahwa hasil adalah alat bantu, bukan diagnosis tunggal. |

## 6. Kriteria Selesai

Sistem dianggap memenuhi kebutuhan apabila:

- Semua modul utama dapat diakses sesuai role.
- Kuesioner 11 item berjalan.
- Skoring total, emotional, dan social loneliness berjalan.
- Hasil assessment dapat dicetak.
- Booklet dapat dikelola admin.
- Kalkulator public berjalan tanpa menyimpan data.
- Tidak ada error kritis saat UAT.

## 7. Catatan Validasi Substansi

Validasi final isi instrumen, interpretasi, rekomendasi edukasi, dan booklet perlu dilakukan oleh tim peneliti/ahli substansi sebelum digunakan pada penelitian real.
