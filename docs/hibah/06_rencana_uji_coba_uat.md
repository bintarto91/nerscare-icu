# Rencana Uji Coba / User Acceptance Test

## 1. Tujuan

UAT dilakukan untuk memastikan sistem dapat digunakan sesuai kebutuhan penelitian dan tidak ada error utama pada alur penggunaan.

## 2. Pihak yang Terlibat

- Developer
- Admin penelitian
- Perawat/petugas
- Perwakilan keluarga/pengunjung jika diperlukan
- Tim peneliti

## 3. Lingkungan Uji

- URL aplikasi: diisi sesuai domain server
- Browser desktop: Chrome/Edge
- Browser mobile: Chrome Android/Safari iOS jika tersedia
- Database: server penelitian
- Akun uji: admin, petugas/perawat, keluarga

## 4. Daftar Skenario UAT

| ID | Modul | Skenario | Hasil yang Diharapkan | Status |
|---|---|---|---|---|
| UAT-01 | Landing | Buka halaman utama | Landing tampil tanpa error | Belum diuji |
| UAT-02 | Landing | Klik login | Masuk ke halaman login | Belum diuji |
| UAT-03 | Landing | Klik booklet edukasi | Scroll ke bagian booklet | Belum diuji |
| UAT-04 | Booklet | Booklet auto membuka halaman | Halaman berubah otomatis | Belum diuji |
| UAT-05 | Booklet | Klik tombol halaman berikut/sebelumnya | Halaman berubah manual | Belum diuji |
| UAT-06 | Kalkulator public | Isi seluruh pertanyaan | Skor dan kategori tampil | Belum diuji |
| UAT-07 | Kalkulator public | Biarkan pertanyaan kosong lalu lihat hasil | Sistem meminta melengkapi jawaban | Belum diuji |
| UAT-08 | Login | Login admin | Dashboard admin tampil | Belum diuji |
| UAT-09 | Login | Login petugas/perawat | Dashboard sesuai role tampil | Belum diuji |
| UAT-10 | Data pasien | Tambah pasien baru | Data tersimpan | Belum diuji |
| UAT-11 | Data pasien | Edit pasien | Perubahan tersimpan | Belum diuji |
| UAT-12 | Data pasien | Pasien tidak memenuhi kriteria | Tidak disarankan assessment | Belum diuji |
| UAT-13 | Assessment | Pilih pasien siap assessment | Form assessment terbuka | Belum diuji |
| UAT-14 | Assessment | Isi 11 item | Total skor berubah otomatis | Belum diuji |
| UAT-15 | Assessment | Simpan assessment | Hasil tersimpan | Belum diuji |
| UAT-16 | Hasil | Buka detail hasil | Skor, kategori, interpretasi tampil | Belum diuji |
| UAT-17 | Hasil | Cek emotional/social loneliness | Nilai dimensi tampil benar | Belum diuji |
| UAT-18 | Laporan | Cetak laporan | Tampilan print/PDF rapi | Belum diuji |
| UAT-19 | Edukasi | Buka edukasi perawat | Materi tampil | Belum diuji |
| UAT-20 | Edukasi | Buka edukasi keluarga | Materi tampil | Belum diuji |
| UAT-21 | Admin booklet | Tambah halaman booklet | Halaman tersimpan dan tampil di landing | Belum diuji |
| UAT-22 | Admin booklet | Nonaktifkan halaman booklet | Halaman tidak tampil di landing | Belum diuji |
| UAT-23 | Admin pertanyaan | Edit pertanyaan | Perubahan tersimpan | Belum diuji |
| UAT-24 | Admin laporan | Ubah pengaturan laporan | Laporan mengikuti pengaturan | Belum diuji |
| UAT-25 | Mobile | Buka landing di HP | Layout tidak rusak | Belum diuji |
| UAT-26 | Mobile | Isi kalkulator di HP | Tombol dan teks mudah dipakai | Belum diuji |
| UAT-27 | Mobile | Buka dashboard di HP | Menu dan konten bisa diakses | Belum diuji |

## 5. Format Catatan Bug

| No | Tanggal | Modul | Masalah | Prioritas | Status | Catatan Perbaikan |
|---:|---|---|---|---|---|---|
| 1 |  |  |  |  |  |  |

Prioritas:

- Tinggi: menghambat penggunaan utama.
- Sedang: mengganggu tapi masih bisa dipakai.
- Rendah: kosmetik atau teks.

## 6. Kriteria Lulus UAT

Sistem dianggap lulus UAT apabila:

- Alur landing, kalkulator, login, data pasien, assessment, hasil, laporan, edukasi, dan booklet dapat berjalan.
- Tidak ada error utama.
- Tampilan mobile dapat digunakan.
- Tim peneliti menyetujui isi kuesioner, interpretasi, dan booklet.
- Admin dapat mengubah konten tanpa bantuan developer.

## 7. Catatan

UAT perlu dilakukan minimal satu kali sebelum live real, terutama karena sistem berkaitan dengan data pasien dan konteks penelitian kesehatan.
