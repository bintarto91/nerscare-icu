<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQuestion;
use App\Models\BookletPage;
use App\Models\SiteSetting;
use App\Support\DeJongGierveldScale;

class PublicController extends Controller
{
    public function landing()
    {
        $settings = SiteSetting::getPublicSettings();
        $bookletSettings = SiteSetting::getBookletSettings();
        $booklets = $this->bookletData($bookletSettings);
        $homeBooklets = [
            'family' => $booklets['keluarga'],
            'nurse' => $booklets['perawat'],
        ];
        foreach ($homeBooklets as &$homeBooklet) {
            $homeBooklet['pages'] = collect($homeBooklet['pages'])->pluck('src')->all();
        }
        unset($homeBooklet);

        return view('public.landing', compact('settings', 'bookletSettings', 'homeBooklets'));
    }

    public function calculator()
    {
        $settings = SiteSetting::getPublicSettings();

        $questions = AssessmentQuestion::whereBetween('sort_order', [1, 11])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'question_text', 'sort_order'])
            ->values();

        $interpretations = DeJongGierveldScale::scoreCategoryFromClient();
        $answerOptions = DeJongGierveldScale::answerOptions();
        $scoreRules = DeJongGierveldScale::scoreRules();
        $decisionOutputs = DeJongGierveldScale::decisionOutputsForClient();

        return view('public.calculator', compact(
            'settings',
            'questions',
            'interpretations',
            'answerOptions',
            'scoreRules',
            'decisionOutputs'
        ));
    }

    public function booklet(string $audience)
    {
        $booklets = $this->bookletData(SiteSetting::getBookletSettings());

        abort_unless(array_key_exists($audience, $booklets), 404);
        abort_if(empty($booklets[$audience]['pages']), 404, 'Booklet belum memiliki halaman aktif.');

        return view('public.booklet', [
            'booklet' => $booklets[$audience],
            'audience' => $audience,
        ]);
    }

    private function bookletData(array $settings): array
    {
        $pages = BookletPage::query()
            ->where('is_active', true)
            ->whereIn('audience', ['keluarga', 'perawat'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('audience');

        $definitions = [
            'keluarga' => ['key' => 'family', 'label' => 'Untuk keluarga', 'audience_label' => 'Untuk keluarga pasien ICU', 'theme' => 'family'],
            'perawat' => ['key' => 'nurse', 'label' => 'Untuk perawat', 'audience_label' => 'Untuk perawat ICU', 'theme' => 'nurse'],
        ];

        return collect($definitions)->mapWithKeys(function (array $definition, string $audience) use ($settings, $pages) {
            $key = $definition['key'];
            $bookletPages = collect($pages->get($audience, collect()))
                ->values()
                ->map(fn (BookletPage $page, int $index) => [
                    'number' => $index + 1,
                    'src' => $page->image_url,
                    'alt' => $page->alt_text,
                ])
                ->all();

            return [$audience => [
                'label' => $definition['label'],
                'title' => $settings["booklet_{$key}_title"],
                'description' => $settings["booklet_{$key}_description"],
                'reader' => route('public.booklet', $audience),
                'pdf' => asset($settings["booklet_{$key}_pdf"]),
                'file' => $settings["booklet_{$key}_pdf"],
                'audience_label' => $definition['audience_label'],
                'theme' => $definition['theme'],
                'reader_note' => $settings['booklet_reader_note'],
                'pages' => $bookletPages,
                'page_count' => count($bookletPages),
            ]];
        })->all();
    }
}
