<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booklet_pages', function (Blueprint $table) {
            $table->id();
            $table->string('kicker')->nullable();
            $table->string('title');
            $table->text('body');
            $table->json('points')->nullable();
            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        $pages = [
            [
                'kicker' => 'Halaman 1',
                'title' => 'Booklet Edukasi ICU Loneliness',
                'body' => 'Panduan singkat untuk mengenali loneliness pada pasien ICU dan membaca hasil assessment secara hati-hati.',
                'points' => [
                    'Untuk perawat, keluarga, dan pengunjung awam.',
                    'Membantu memahami hasil tanpa menggantikan penilaian klinis.',
                    'Dapat dibaca sebelum atau sesudah mencoba kalkulator.',
                ],
            ],
            [
                'kicker' => 'Halaman 2',
                'title' => 'Apa yang dinilai?',
                'body' => 'Skala De Jong Gierveld membantu melihat gambaran loneliness dari dua sisi: emotional loneliness dan social loneliness.',
                'points' => [
                    'Emotional loneliness berkaitan dengan rasa kosong, ditolak, atau kehilangan kedekatan.',
                    'Social loneliness berkaitan dengan dukungan sosial dan orang yang dapat dipercaya.',
                    'Total skor dipakai untuk melihat kategori loneliness secara umum.',
                ],
            ],
            [
                'kicker' => 'Halaman 3',
                'title' => 'Emotional Loneliness',
                'body' => 'Bagian ini menggambarkan perasaan kehilangan kedekatan emosional atau tidak adanya relasi yang benar-benar terasa dekat.',
                'points' => [
                    'Merindukan teman yang benar-benar dekat.',
                    'Merasakan kekosongan secara umum.',
                    'Merasa ditolak atau kehilangan kehadiran orang lain.',
                ],
            ],
            [
                'kicker' => 'Halaman 4',
                'title' => 'Social Loneliness',
                'body' => 'Bagian ini menggambarkan apakah pasien merasa memiliki jaringan sosial, orang yang dapat dipercaya, dan dukungan saat membutuhkan bantuan.',
                'points' => [
                    'Ada orang yang bisa diajak bicara tentang masalah sehari-hari.',
                    'Ada orang yang dapat diandalkan ketika mengalami masalah.',
                    'Ada cukup orang yang dirasa dekat dan dapat dipercaya.',
                ],
            ],
            [
                'kicker' => 'Halaman 5',
                'title' => 'Membaca Kategori Hasil',
                'body' => 'Total skor loneliness berada pada rentang 0 sampai 11. Semakin tinggi skor, semakin besar kebutuhan dukungan emosional dan sosial.',
                'points' => [
                    '0-2: Not lonely.',
                    '3-8: Moderate lonely.',
                    '9-10: Severe lonely.',
                    '11: Very severe lonely.',
                ],
            ],
            [
                'kicker' => 'Halaman 6',
                'title' => 'Catatan Klinis',
                'body' => 'Hasil assessment adalah alat bantu edukasi dan dokumentasi awal. Keputusan klinis tetap perlu menyesuaikan kondisi pasien dan kebijakan ruang ICU.',
                'points' => [
                    'Lihat kemampuan komunikasi pasien.',
                    'Perhatikan observasi perawat dan kondisi klinis.',
                    'Gunakan hasil sebagai dasar tindak lanjut, bukan diagnosis tunggal.',
                ],
            ],
            [
                'kicker' => 'Halaman 7',
                'title' => 'Panduan untuk Perawat',
                'body' => 'Perawat dapat menggunakan hasil assessment untuk menyusun komunikasi terapeutik dan edukasi yang lebih sesuai.',
                'points' => [
                    'Validasi perasaan pasien dengan bahasa tenang.',
                    'Jelaskan tindakan perawatan secara sederhana.',
                    'Fasilitasi dukungan keluarga sesuai kebijakan ICU.',
                ],
            ],
            [
                'kicker' => 'Halaman 8',
                'title' => 'Panduan untuk Keluarga',
                'body' => 'Keluarga dapat membantu pasien merasa lebih didampingi melalui komunikasi yang positif dan konsisten.',
                'points' => [
                    'Gunakan kalimat singkat, lembut, dan menenangkan.',
                    'Yakinkan pasien bahwa ia tidak sendiri.',
                    'Ikuti arahan perawat saat berkomunikasi dengan pasien.',
                ],
            ],
        ];

        foreach ($pages as $index => $page) {
            DB::table('booklet_pages')->insert([
                'kicker' => $page['kicker'],
                'title' => $page['title'],
                'body' => $page['body'],
                'points' => json_encode($page['points']),
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('booklet_pages');
    }
};
