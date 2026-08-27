<?php

namespace Tests\Unit;

use App\Support\DeJongGierveldScale;
use PHPUnit\Framework\TestCase;

class DeJongGierveldScaleTest extends TestCase
{
    public function test_decision_support_maps_each_score_profile_to_its_expected_code(): void
    {
        $cases = [
            'no dominant need' => [0, 0, 'N0', 'Tidak kesepian', 'Tidak ada domain menonjol'],
            'low emotional need' => [1, 0, 'NE', 'Tidak kesepian', 'Emotional dominan'],
            'low social need' => [0, 1, 'NS', 'Tidak kesepian', 'Social dominan'],
            'low balanced need' => [1, 1, 'NB', 'Tidak kesepian', 'Emotional dan Social relatif seimbang'],
            'moderate emotional need' => [3, 1, 'ME', 'Kesepian tingkat sedang', 'Emotional dominan'],
            'moderate social need' => [1, 3, 'MS', 'Kesepian tingkat sedang', 'Social dominan'],
            'moderate balanced need' => [3, 3, 'MB', 'Kesepian tingkat sedang', 'Emotional dan Social relatif seimbang'],
            'severe emotional need' => [6, 3, 'HE', 'Kesepian tingkat berat', 'Emotional dominan'],
            'severe social need' => [4, 5, 'HS', 'Kesepian tingkat berat', 'Social dominan'],
            'severe balanced need' => [5, 4, 'HB', 'Kesepian tingkat berat', 'Emotional dan Social relatif seimbang'],
            'very severe need' => [6, 5, 'VHB', 'Kesepian tingkat sangat berat', 'Emotional dan Social sangat menonjol'],
        ];

        foreach ($cases as $caseName => [$emotionalScore, $socialScore, $expectedCode, $expectedCategory, $expectedProfile]) {
            $result = DeJongGierveldScale::decisionForScores($emotionalScore, $socialScore);

            $this->assertSame($expectedCode, $result['code'], $caseName);
            $this->assertSame($expectedCategory, $result['category'], $caseName);
            $this->assertSame($expectedProfile, $result['profile'], $caseName);
        }
    }

    public function test_score_answer_applies_the_revised_reverse_scoring_rules(): void
    {
        $this->assertSame(1, DeJongGierveldScale::scoreAnswer(2, 3));
        $this->assertSame(0, DeJongGierveldScale::scoreAnswer(2, 2));
        $this->assertSame(1, DeJongGierveldScale::scoreAnswer(1, 3));
        $this->assertSame(0, DeJongGierveldScale::scoreAnswer(1, 4));
    }

    public function test_all_42_score_pairs_match_the_decision_ai_matrix(): void
    {
        $expected = [
            ['N0', 'NS', 'NS', 'MS', 'MS', 'MS'],
            ['NE', 'NB', 'MS', 'MS', 'MS', 'MS'],
            ['NE', 'MB', 'MB', 'MS', 'MS', 'MS'],
            ['ME', 'ME', 'MB', 'MB', 'MS', 'MS'],
            ['ME', 'ME', 'ME', 'MB', 'MB', 'HS'],
            ['ME', 'ME', 'ME', 'ME', 'HB', 'HS'],
            ['ME', 'ME', 'ME', 'HE', 'HE', 'VHB'],
        ];

        foreach ($expected as $emotionalScore => $socialCodes) {
            foreach ($socialCodes as $socialScore => $expectedCode) {
                $this->assertSame(
                    $expectedCode,
                    DeJongGierveldScale::decisionForScores($emotionalScore, $socialScore)['code'],
                    "E={$emotionalScore}, S={$socialScore}"
                );
            }
        }
    }

    public function test_safety_gate_returns_condition_specific_clinical_actions(): void
    {
        $selected = DeJongGierveldScale::selectedSafetyAlerts([
            'self_harm',
            'severe_confusion_agitation',
            'hallucination_psychosis',
            'severe_distress',
            'beyond_routine_support',
        ]);

        $this->assertCount(5, $selected);
        $this->assertSame('segera', $selected[0]['urgency']);
        $this->assertStringContainsString('evaluasi klinis segera', $selected[0]['response']);
        $this->assertStringContainsString('delirium', $selected[1]['response']);
        $this->assertStringContainsString('evaluasi profesional', $selected[2]['response']);
        $this->assertStringContainsString('eskalasi', $selected[3]['response']);
        $this->assertStringContainsString('tenaga profesional', $selected[4]['response']);
    }

    public function test_revised_categories_have_consistent_risk_levels(): void
    {
        $this->assertSame('low', DeJongGierveldScale::categoryRiskLevel('Tidak kesepian'));
        $this->assertSame('medium', DeJongGierveldScale::categoryRiskLevel('Kesepian tingkat sedang'));
        $this->assertSame('high', DeJongGierveldScale::categoryRiskLevel('Kesepian tingkat berat'));
        $this->assertSame('high', DeJongGierveldScale::categoryRiskLevel('Kesepian tingkat sangat berat'));
    }

    public function test_complete_responses_keep_both_subscales_valid_and_return_a_decision(): void
    {
        $result = DeJongGierveldScale::scoreResponses(array_fill(1, 11, 1));

        $this->assertSame(0, $result['missing_item_count']);
        $this->assertTrue($result['emotional_score_valid']);
        $this->assertTrue($result['social_score_valid']);
        $this->assertNotNull($result['code']);
    }

    public function test_one_missing_emotional_item_keeps_total_valid_but_invalidates_emotional_subscale(): void
    {
        $responses = array_fill(1, 11, 1);
        $responses[2] = null;

        $result = DeJongGierveldScale::scoreResponses($responses);

        $this->assertSame(1, $result['missing_item_count']);
        $this->assertSame(5, $result['total_score']);
        $this->assertFalse($result['emotional_score_valid']);
        $this->assertTrue($result['social_score_valid']);
        $this->assertNull($result['code']);
        $this->assertStringContainsString('skor total tetap valid', mb_strtolower($result['interpretation']));
    }

    public function test_one_missing_social_item_invalidates_only_social_subscale(): void
    {
        $responses = array_fill(1, 11, 1);
        $responses[1] = null;

        $result = DeJongGierveldScale::scoreResponses($responses);

        $this->assertTrue($result['emotional_score_valid']);
        $this->assertFalse($result['social_score_valid']);
        $this->assertNull($result['code']);
    }

    public function test_more_than_one_missing_item_is_rejected(): void
    {
        $responses = array_fill(1, 11, 1);
        $responses[1] = null;
        $responses[2] = null;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Maksimal satu item');

        DeJongGierveldScale::scoreResponses($responses);
    }
}
