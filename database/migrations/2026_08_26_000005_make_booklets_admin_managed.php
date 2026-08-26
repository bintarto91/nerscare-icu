<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booklet_pages', function (Blueprint $table) {
            $table->string('audience', 20)->default('keluarga')->after('id');
            $table->string('image_path')->nullable()->after('audience');
            $table->string('alt_text')->nullable()->after('image_path');
            $table->index(['audience', 'is_active', 'sort_order']);
        });

        DB::table('booklet_pages')->delete();

        $now = now();
        foreach (['keluarga', 'perawat'] as $audience) {
            for ($page = 1; $page <= 10; $page++) {
                DB::table('booklet_pages')->insert([
                    'audience' => $audience,
                    'image_path' => 'booklets/'.$audience.'/page-'.str_pad((string) $page, 2, '0', STR_PAD_LEFT).'.jpg',
                    'alt_text' => 'Halaman '.$page.' booklet edukasi '.($audience === 'keluarga' ? 'keluarga pasien ICU' : 'perawat ICU'),
                    'kicker' => 'Halaman '.$page,
                    'title' => 'Halaman '.$page,
                    'body' => 'Materi edukasi resmi untuk '.($audience === 'keluarga' ? 'keluarga pasien ICU.' : 'perawat ICU.'),
                    'points' => null,
                    'sort_order' => $page,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $settings = [
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

        foreach ($settings as $key => $value) {
            DB::table('site_settings')->updateOrInsert(
                ['setting_key' => $key],
                ['setting_value' => $value, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->where('setting_key', 'like', 'booklet_%')->delete();

        Schema::table('booklet_pages', function (Blueprint $table) {
            $table->dropIndex(['audience', 'is_active', 'sort_order']);
            $table->dropColumn(['audience', 'image_path', 'alt_text']);
        });
    }
};
