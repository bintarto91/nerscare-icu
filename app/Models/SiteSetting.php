<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return static::where('setting_key', $key)->value('setting_value') ?? $default;
    }

    public static function getPublicSettings(): array
    {
        $defaults = [
            'app_name' => 'AI-Assisted Assessment ICU',
            'landing_badge' => 'Web Public + Sistem Petugas ICU',
            'landing_title' => 'AI-Assisted Assessment untuk Loneliness Pasien ICU',
            'landing_description' => 'Web ini membantu perawat melakukan assessment loneliness pasien ICU secara terstruktur, menampilkan skor dan kategori awal, serta menyediakan edukasi pendukung bagi perawat dan keluarga pasien.',
            'landing_calculator_title' => 'Kalkulator Loneliness Public',
            'landing_calculator_description' => 'Fitur ini dapat digunakan oleh pengunjung umum untuk mencoba simulasi skor loneliness sederhana. Hasil yang tampil hanya bersifat edukatif dan tidak tersimpan ke database.',
            'clinical_disclaimer' => 'Kalkulator public bukan alat diagnosis medis. Hasilnya tidak menggantikan penilaian klinis perawat, dokter, atau tenaga kesehatan. Untuk assessment resmi pasien ICU, petugas harus login ke sistem.',
            'footer_text' => 'AI-Assisted Assessment ICU — Web penilaian loneliness pasien ICU dan edukasi perawat-keluarga.',
        ];

        $settings = static::query()
            ->whereIn('setting_key', array_keys($defaults))
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        return array_merge($defaults, $settings);
    }

    public static function getBookletSettings(): array
    {
        $defaults = [
            'booklet_section_kicker' => 'E-booklet resmi',
            'booklet_section_title' => 'Edukasi Perawat/Keluarga untuk Menurunkan Kesepian pada Pasien ICU',
            'booklet_section_description' => 'Pilih peran, lalu balik halaman langsung dari halaman ini. Isi flipbook, warna, tautan baca lengkap, dan PDF akan menyesuaikan pilihan keluarga atau perawat.',
            'booklet_clinical_note' => 'Booklet merupakan materi pendamping edukasi. Penilaian klinis, preferensi pasien, kebijakan ICU, dan SOP rumah sakit tetap menjadi acuan utama.',
            'booklet_reader_note' => 'Tetap sesuaikan penerapan isi booklet dengan kondisi klinis, preferensi pasien, kebijakan ICU, dan SOP rumah sakit.',
            'booklet_autoplay_seconds' => '3',
            'booklet_family_title' => 'Edukasi Keluarga untuk Menurunkan Kesepian pada Pasien ICU',
            'booklet_family_description' => 'Dukungan yang aman, menenangkan, dan tetap menghormati preferensi pasien.',
            'booklet_family_pdf' => 'booklets/edukasi-keluarga-icu.pdf',
            'booklet_nurse_title' => 'Edukasi Perawat untuk Menurunkan Kesepian pada Pasien ICU',
            'booklet_nurse_description' => 'Alur kaji, intervensi multimodal, dokumentasi, dan eskalasi klinis.',
            'booklet_nurse_pdf' => 'booklets/edukasi-perawat-icu.pdf',
        ];

        $settings = static::query()
            ->whereIn('setting_key', array_keys($defaults))
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        return array_merge($defaults, $settings);
    }

    public static function getReportSettings(): array
    {
        $defaults = [
            'report_institution_name' => 'Instalasi Perawatan Intensif / ICU',
            'report_app_name' => 'AI-Assisted Assessment ICU',
            'report_title' => 'Hasil AI-Assisted Assessment ICU',
            'report_subtitle' => 'Penilaian Loneliness Pasien ICU dan Rekomendasi Edukasi',
            'report_unit_name' => 'Ruang ICU',
            'report_left_signature_label' => 'Perawat Pengisi',
            'report_right_signature_label' => 'Mengetahui',
            'report_right_signature_name' => '................................',
            'report_clinical_note' => 'Hasil AI-Assisted Assessment ini merupakan alat bantu penilaian dan tidak menggantikan clinical judgement perawat. Interpretasi perlu disesuaikan dengan kondisi klinis pasien, kemampuan komunikasi pasien, observasi perawat, serta kebijakan ruang ICU.',
            'report_footer_text' => 'Dicetak dari sistem AI-Assisted Assessment ICU.',
        ];

        $settings = static::query()
            ->whereIn('setting_key', array_keys($defaults))
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        return array_merge($defaults, $settings);
    }
}
