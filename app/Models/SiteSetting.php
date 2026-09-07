<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const PUBLIC_DEFAULTS = [
        'app_name' => 'NersCare-ICU',
        'brand_tagline' => 'Psychosocial Screening',
        'landing_badge' => 'Web Public + Sistem Petugas ICU',
        'landing_title' => 'AI-Assisted Assessment untuk Loneliness Pasien ICU',
        'landing_description' => 'Web ini membantu perawat melakukan assessment loneliness pasien ICU secara terstruktur, menampilkan skor dan kategori awal, serta menyediakan edukasi pendukung bagi perawat dan keluarga pasien.',
        'hero_primary_cta' => 'Mulai Simulasi Asesmen',
        'hero_education_cta' => 'Lihat Materi Edukasi',
        'hero_login_cta' => 'Masuk sebagai Perawat',
        'trust_assessment_title' => 'Asesmen Terstruktur',
        'trust_assessment_description' => 'Skor, kategori, interpretasi, dan riwayat tersimpan rapi.',
        'trust_clinical_title' => 'Interpretasi Klinis',
        'trust_clinical_description' => 'Hasil asesmen ditampilkan secara terstruktur untuk membantu perawat memahami kondisi psikososial pasien.',
        'trust_education_title' => 'Edukasi Lanjutan',
        'trust_education_description' => 'Rekomendasi untuk perawat dan keluarga pasien.',
        'flow_title' => 'Alur Penggunaan Sistem',
        'flow_step_1_title' => 'Masuk ke Sistem',
        'flow_step_1_description' => 'Masuk sebagai perawat untuk memulai alur asesmen.',
        'flow_step_2_title' => 'Tambahkan Data Pasien',
        'flow_step_2_description' => 'Catat data pasien dan pastikan pasien memenuhi kelayakan asesmen.',
        'flow_step_3_title' => 'Lakukan Asesmen',
        'flow_step_3_description' => 'Isi instrumen loneliness secara bertahap.',
        'flow_step_4_title' => 'Analisis Hasil',
        'flow_step_4_description' => 'Sistem menghitung skor dan menyajikan interpretasi hasil asesmen secara terstruktur.',
        'flow_step_5_title' => 'Rekomendasi Intervensi Perawat dan Kolaborasi dengan Keluarga',
        'flow_step_5_description' => 'Tinjau rekomendasi pendukung intervensi dan bentuk keterlibatan keluarga.',
        'flow_step_6_title' => 'Dokumentasi dan Reasesmen',
        'flow_step_6_description' => 'Dokumentasikan hasil, tindak lanjut, dan asesmen ulang pasien.',
        'features_title' => 'Fitur Utama Web',
        'features_description' => 'Satu alur kerja untuk mendata pasien, melakukan asesmen, membaca hasil, dan menyiapkan edukasi yang sesuai untuk perawat maupun keluarga.',
        'feature_patient_title' => 'Data Pasien ICU',
        'feature_patient_description' => 'Mengelola identitas pasien, kondisi komunikasi, status kesadaran, dan kelayakan asesmen.',
        'feature_patient_action' => 'Kelola Data',
        'feature_assessment_title' => 'Asesmen Loneliness',
        'feature_assessment_description' => 'Instrumen diisi bertahap dengan skor otomatis, kategori, interpretasi, dan rekomendasi awal.',
        'feature_assessment_action' => 'Mulai Asesmen',
        'feature_history_title' => 'Hasil dan Riwayat',
        'feature_history_description' => 'Riwayat asesmen dapat dilihat kembali, ditindaklanjuti, dan dicetak untuk dokumentasi.',
        'feature_history_action' => 'Lihat Hasil',
        'feature_nurse_title' => 'Edukasi Perawat',
        'feature_nurse_description' => 'Materi komunikasi terapeutik, dukungan emosional, dan dokumentasi edukasi keperawatan.',
        'feature_nurse_action' => 'Pelajari Materi',
        'feature_family_title' => 'Edukasi Keluarga',
        'feature_family_description' => 'Panduan komunikasi positif dan dukungan emosional keluarga sesuai arahan petugas ICU.',
        'feature_family_action' => 'Lihat Edukasi',
        'feature_calculator_title' => 'Simulasi Asesmen',
        'feature_calculator_description' => 'Simulasi edukatif tanpa login, tanpa menyimpan data, dan bukan pengganti penilaian klinis.',
        'feature_calculator_action' => 'Coba Simulasi',
        'landing_calculator_title' => 'Simulasi Asesmen Loneliness',
        'landing_calculator_description' => 'Fitur ini memberikan gambaran mengenai proses pengisian dan interpretasi awal instrumen loneliness yang digunakan dalam NersCare-ICU.',
        'calculator_primary_cta' => 'Mulai Simulasi',
        'calculator_secondary_cta' => 'Masuk sebagai Perawat',
        'clinical_disclaimer' => 'Fitur simulasi tidak digunakan untuk menegakkan diagnosis klinis dan tidak menggantikan penilaian profesional tenaga kesehatan. Interpretasi hasil harus mempertimbangkan kondisi klinis, psikososial, dan konteks perawatan pasien secara menyeluruh.',
        'audience_title' => 'Dirancang untuk Mendukung Perawat, Pasien dan Keluarga ICU',
        'audience_description' => 'Setiap pengguna memperoleh akses dan informasi sesuai dengan perannya dalam proses asesmen, edukasi, dan dukungan psikososial pasien.',
        'audience_public_title' => 'Pengunjung Awam',
        'audience_public_description' => 'Dapat mencoba simulasi tanpa login dan memahami gambaran loneliness secara edukatif.',
        'audience_public_features' => "Bahasa sederhana dan tidak terasa teknis.\nHasil langsung tampil setelah pertanyaan dijawab.\nAda catatan bahwa hasil bukan diagnosis klinis.",
        'audience_nurse_title' => 'Perawat ICU',
        'audience_nurse_description' => 'Menggunakan NersCare-ICU untuk melakukan asesmen, meninjau hasil, dan memperoleh rekomendasi pendukung intervensi keperawatan.',
        'audience_nurse_features' => "Asesmen loneliness.\nInterpretasi hasil.\nRekomendasi intervensi.\nRiwayat asesmen.\nEdukasi intervensi keperawatan.",
        'audience_family_title' => 'Keluarga Pasien',
        'audience_family_description' => 'Memperoleh informasi dan materi edukasi untuk mendukung komunikasi dan kebutuhan psikososial pasien selama menjalani perawatan di ICU.',
        'audience_family_features' => "Booklet edukasi.\nDukungan komunikasi.\nInformasi keterlibatan keluarga.",
        'footer_text' => 'NersCare-ICU - Psychosocial Screening untuk asesmen dan edukasi pasien ICU.',
    ];

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
        $defaults = static::PUBLIC_DEFAULTS;

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
