# Kerangka Acuan Kerja Teknis Pengembangan Sistem

## 1. Nama Pekerjaan

Pengembangan Web AI-Assisted Assessment ICU Loneliness untuk Penilaian Loneliness Pasien ICU dan Edukasi Perawat-Keluarga.

## 2. Latar Belakang

Pasien ICU dapat mengalami kondisi psikososial yang kompleks, termasuk rasa kesepian/loneliness akibat keterbatasan komunikasi, kondisi klinis, pembatasan interaksi, atau perubahan lingkungan perawatan. Penelitian ini membutuhkan sistem digital yang dapat membantu proses assessment loneliness secara lebih terstruktur, terdokumentasi, dan mudah digunakan oleh petugas.

Sistem dikembangkan sebagai alat bantu penelitian dan edukasi. Sistem tidak dimaksudkan sebagai alat diagnosis medis tunggal, melainkan sebagai media pencatatan, perhitungan skor, interpretasi awal, edukasi, dan dokumentasi.

## 3. Tujuan Pengembangan

- Membuat web assessment loneliness pasien ICU berbasis instrumen De Jong Gierveld Loneliness Scale 11 item.
- Membantu petugas/perawat melakukan pendataan pasien, pengisian assessment, dan pencetakan hasil.
- Menyediakan kalkulator public untuk simulasi edukatif tanpa menyimpan data ke database.
- Menyediakan edukasi untuk perawat dan keluarga pasien.
- Menyediakan booklet digital pada landing page yang dapat dikelola oleh admin.
- Menyediakan dashboard monitoring ringkas untuk kebutuhan penelitian.

## 4. Sasaran Pengguna

- Admin penelitian
- Petugas/perawat ICU
- Keluarga pasien
- Pengunjung public/awam

## 5. Ruang Lingkup Fitur

### 5.1 Landing Page Public

- Identitas aplikasi.
- Penjelasan ringkas tujuan web.
- Alur penggunaan sistem.
- Fitur utama.
- Booklet edukasi interaktif.
- Akses ke kalkulator public.
- Akses login petugas.

### 5.2 Kalkulator Loneliness Public

- Menampilkan 11 pertanyaan loneliness.
- Pengisian jawaban dengan skala 5 pilihan.
- Perhitungan skor edukatif tanpa login.
- Menampilkan total skor, kategori umum, emotional loneliness, social loneliness, dan dimensi yang lebih dominan.
- Tidak menyimpan jawaban ke database.

### 5.3 Login dan Role Pengguna

- Login pengguna.
- Role admin, perawat/petugas, dan keluarga.
- Pembatasan akses menu berdasarkan role.

### 5.4 Dashboard

- Ringkasan total pengguna.
- Ringkasan total pasien.
- Ringkasan total assessment.
- Ringkasan pertanyaan assessment.
- Ringkasan materi edukasi aktif.

### 5.5 Data Pasien

- Tambah, edit, lihat, dan hapus data pasien sesuai akses.
- Pencatatan informasi ICU.
- Pengecekan kelayakan assessment: sadar, mampu berkomunikasi, memahami pertanyaan, dan bersedia.

### 5.6 Assessment Loneliness

- Pemilihan pasien yang layak assessment.
- Pengisian 11 item De Jong Gierveld Loneliness Scale.
- Perhitungan otomatis skor item 0/1.
- Perhitungan total skor.
- Perhitungan emotional loneliness dan social loneliness.
- Penentuan kategori loneliness umum.
- Penentuan kategori lain yang lebih dominan.

### 5.7 Hasil dan Riwayat Assessment

- Menampilkan hasil assessment pasien.
- Menampilkan interpretasi dan rekomendasi edukasi.
- Menyimpan riwayat assessment.
- Cetak laporan hasil.
- Follow-up/tindak lanjut.

### 5.8 Edukasi

- Materi edukasi untuk perawat.
- Materi edukasi untuk keluarga.
- Manajemen konten edukasi oleh admin.

### 5.9 Booklet Digital Landing

- Booklet tampil pada landing page seperti buku interaktif.
- Booklet dapat membuka halaman otomatis.
- Booklet dapat dibuka manual oleh pengguna.
- Isi halaman booklet dapat ditambah, diedit, dinonaktifkan, atau dihapus oleh admin.

### 5.10 Pengaturan Sistem

- Manajemen pertanyaan.
- Pengaturan interpretasi.
- Pengaturan landing.
- Pengaturan laporan.
- Manajemen pengguna.

## 6. Batasan Sistem

- Sistem adalah alat bantu assessment dan edukasi, bukan diagnosis medis tunggal.
- Validasi isi kuesioner, istilah klinis, dan booklet menjadi tanggung jawab tim peneliti/ahli substansi.
- Sistem tidak menggantikan clinical judgement perawat/dokter.
- Penggunaan data pasien harus mengikuti aturan etik penelitian dan kebijakan institusi.
- Backup database dan pengelolaan server perlu dilakukan berkala.

## 7. Output Pekerjaan

- Source code aplikasi web.
- Database schema dan migration.
- Web terpasang di server.
- Modul public dan modul dashboard.
- Booklet digital yang dapat dikelola admin.
- Dokumen teknis.
- Manual book pengguna.
- RAB dan timeline pekerjaan.
- Rencana uji coba/UAT.

## 8. Kriteria Penerimaan

Sistem dianggap diterima apabila:

- Landing page dapat diakses.
- Kalkulator public dapat menghitung skor.
- Admin/petugas dapat login.
- Admin dapat mengelola user, pertanyaan, interpretasi, edukasi, landing, laporan, dan booklet.
- Petugas dapat mengelola pasien dan melakukan assessment.
- Hasil assessment tampil dengan skor dan rekomendasi.
- Laporan hasil dapat dicetak.
- Booklet tampil pada landing page dan dapat diedit dari admin.
- Tidak ditemukan error utama pada alur demo.

## 9. Catatan Kesiapan Live

Sistem saat ini layak untuk demo/soft live. Untuk live pemakaian real, diperlukan:

- Proofread isi booklet dan edukasi.
- UAT bersama pengguna.
- Backup database.
- Pemeriksaan mobile.
- Pemeriksaan akses role.
- Persetujuan etik dan kebijakan data pasien dari pihak terkait.
