<?php

namespace App\Http\Controllers;

use App\Models\AssessmentQuestion;
use App\Models\SiteSetting;
use App\Support\DeJongGierveldScale;

class PublicController extends Controller
{
    public function landing()
    {
        $settings = SiteSetting::getPublicSettings();

        return view('public.landing', compact('settings'));
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
        $booklets = [
            'keluarga' => [
                'title' => 'Edukasi Keluarga untuk Menurunkan Kesepian pada Pasien ICU',
                'description' => 'Tetap terhubung, mendukung, dan menenangkan pasien selama perawatan intensif.',
                'audience_label' => 'Untuk keluarga pasien ICU',
                'theme' => 'family',
                'file' => 'booklets/edukasi-keluarga-icu.pdf',
                'page_directory' => 'booklets/keluarga',
                'page_count' => 10,
            ],
            'perawat' => [
                'title' => 'Edukasi Perawat untuk Menurunkan Kesepian pada Pasien ICU',
                'description' => 'Panduan intervensi multimodal untuk mengurangi rasa kesepian dan keterputusan sosial pasien ICU.',
                'audience_label' => 'Untuk perawat ICU',
                'theme' => 'nurse',
                'file' => 'booklets/edukasi-perawat-icu.pdf',
                'page_directory' => 'booklets/perawat',
                'page_count' => 10,
            ],
        ];

        abort_unless(array_key_exists($audience, $booklets), 404);

        return view('public.booklet', [
            'booklet' => $booklets[$audience],
            'audience' => $audience,
        ]);
    }
}
