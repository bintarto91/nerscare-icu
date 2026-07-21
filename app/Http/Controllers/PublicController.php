<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQuestion;
use App\Models\BookletPage;
use App\Models\SiteSetting;
use App\Support\DeJongGierveldScale;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    public function landing()
    {
        $settings = SiteSetting::getPublicSettings();
        $bookletPages = $this->bookletPages();
        $bookletSpreads = $this->bookletSpreads($bookletPages);
        $bookletTotal = $bookletPages->count();

        return view('public.landing', compact('settings', 'bookletPages', 'bookletSpreads', 'bookletTotal'));
    }

    public function calculator()
    {
        $settings = SiteSetting::getPublicSettings();

        $questions = AssessmentQuestion::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'question_text', 'sort_order'])
            ->values();

        $interpretations = DeJongGierveldScale::scoreCategoryFromClient();
        $answerOptions = DeJongGierveldScale::answerOptions();
        $scoreRules = DeJongGierveldScale::scoreRules();

        return view('public.calculator', compact(
            'settings',
            'questions',
            'interpretations',
            'answerOptions',
            'scoreRules'
        ));
    }

    private function bookletPages(): Collection
    {
        if (Schema::hasTable('booklet_pages')) {
            $pages = BookletPage::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(function (BookletPage $page, int $index) {
                    return $this->formatBookletPage([
                        'kicker' => $page->kicker,
                        'title' => $page->title,
                        'text' => $page->body,
                        'list' => $page->points ?? [],
                    ], $index);
                })
                ->values();

            if ($pages->isNotEmpty()) {
                return $this->ensureEvenBookletPages($pages);
            }
        }

        return $this->ensureEvenBookletPages(
            collect($this->defaultBookletPages())
                ->map(fn (array $page, int $index) => $this->formatBookletPage($page, $index))
                ->values()
        );
    }

    private function ensureEvenBookletPages(Collection $pages): Collection
    {
        if ($pages->count() % 2 === 0) {
            return $pages;
        }

        $nextNumber = $pages->count() + 1;

        return $pages->push([
            'kicker' => 'Halaman ' . $nextNumber,
            'title' => 'Catatan Tambahan',
            'text' => 'Halaman booklet berikutnya dapat ditambahkan dari dashboard admin sesuai kebutuhan edukasi.',
            'list' => [
                'Aktifkan halaman baru dari menu Booklet Landing.',
                'Atur urutan agar halaman kiri dan kanan terbaca nyaman.',
            ],
            'number' => (string) $nextNumber,
        ]);
    }

    private function bookletSpreads(Collection $pages): Collection
    {
        return $pages
            ->chunk(2)
            ->map(function (Collection $spread) {
                $items = $spread->values();

                return [
                    'left' => $items->get(0),
                    'right' => $items->get(1),
                ];
            })
            ->values();
    }

    private function formatBookletPage(array $page, int $index): array
    {
        $number = $index + 1;

        return [
            'kicker' => $page['kicker'] ?: 'Halaman ' . $number,
            'title' => $page['title'] ?? 'Halaman Booklet',
            'text' => $page['text'] ?? '',
            'list' => array_values(array_filter($page['list'] ?? [])),
            'number' => (string) $number,
        ];
    }

    private function defaultBookletPages(): array
    {
        return [
            [
                'kicker' => 'Halaman 1',
                'title' => 'Booklet Edukasi ICU Loneliness',
                'text' => 'Panduan singkat untuk mengenali loneliness pada pasien ICU dan membaca hasil assessment secara hati-hati.',
                'list' => [
                    'Untuk perawat, keluarga, dan pengunjung awam.',
                    'Membantu memahami hasil tanpa menggantikan penilaian klinis.',
                    'Dapat dibaca sebelum atau sesudah mencoba kalkulator.',
                ],
            ],
            [
                'kicker' => 'Halaman 2',
                'title' => 'Apa yang dinilai?',
                'text' => 'Skala De Jong Gierveld membantu melihat gambaran loneliness dari dua sisi: emotional loneliness dan social loneliness.',
                'list' => [
                    'Emotional loneliness berkaitan dengan rasa kosong, ditolak, atau kehilangan kedekatan.',
                    'Social loneliness berkaitan dengan dukungan sosial dan orang yang dapat dipercaya.',
                    'Total skor dipakai untuk melihat kategori loneliness secara umum.',
                ],
            ],
            [
                'kicker' => 'Halaman 3',
                'title' => 'Emotional Loneliness',
                'text' => 'Bagian ini menggambarkan perasaan kehilangan kedekatan emosional atau tidak adanya relasi yang benar-benar terasa dekat.',
                'list' => [
                    'Merindukan teman yang benar-benar dekat.',
                    'Merasakan kekosongan secara umum.',
                    'Merasa ditolak atau kehilangan kehadiran orang lain.',
                ],
            ],
            [
                'kicker' => 'Halaman 4',
                'title' => 'Social Loneliness',
                'text' => 'Bagian ini menggambarkan apakah pasien merasa memiliki jaringan sosial, orang yang dapat dipercaya, dan dukungan saat membutuhkan bantuan.',
                'list' => [
                    'Ada orang yang bisa diajak bicara tentang masalah sehari-hari.',
                    'Ada orang yang dapat diandalkan ketika mengalami masalah.',
                    'Ada cukup orang yang dirasa dekat dan dapat dipercaya.',
                ],
            ],
            [
                'kicker' => 'Halaman 5',
                'title' => 'Membaca Kategori Hasil',
                'text' => 'Total skor loneliness berada pada rentang 0 sampai 11. Semakin tinggi skor, semakin besar kebutuhan dukungan emosional dan sosial.',
                'list' => [
                    '0-2: Not lonely.',
                    '3-8: Moderate lonely.',
                    '9-10: Severe lonely.',
                    '11: Very severe lonely.',
                ],
            ],
            [
                'kicker' => 'Halaman 6',
                'title' => 'Catatan Klinis',
                'text' => 'Hasil assessment adalah alat bantu edukasi dan dokumentasi awal. Keputusan klinis tetap perlu menyesuaikan kondisi pasien dan kebijakan ruang ICU.',
                'list' => [
                    'Lihat kemampuan komunikasi pasien.',
                    'Perhatikan observasi perawat dan kondisi klinis.',
                    'Gunakan hasil sebagai dasar tindak lanjut, bukan diagnosis tunggal.',
                ],
            ],
            [
                'kicker' => 'Halaman 7',
                'title' => 'Panduan untuk Perawat',
                'text' => 'Perawat dapat menggunakan hasil assessment untuk menyusun komunikasi terapeutik dan edukasi yang lebih sesuai.',
                'list' => [
                    'Validasi perasaan pasien dengan bahasa tenang.',
                    'Jelaskan tindakan perawatan secara sederhana.',
                    'Fasilitasi dukungan keluarga sesuai kebijakan ICU.',
                ],
            ],
            [
                'kicker' => 'Halaman 8',
                'title' => 'Panduan untuk Keluarga',
                'text' => 'Keluarga dapat membantu pasien merasa lebih didampingi melalui komunikasi yang positif dan konsisten.',
                'list' => [
                    'Gunakan kalimat singkat, lembut, dan menenangkan.',
                    'Yakinkan pasien bahwa ia tidak sendiri.',
                    'Ikuti arahan perawat saat berkomunikasi dengan pasien.',
                ],
            ],
        ];
    }
}
