<?php

namespace Tests\Feature;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentMissingDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_clinical_assessment_saves_administration_mode_and_one_missing_item(): void
    {
        [$user, $patient] = $this->clinicalContext();
        $questions = AssessmentQuestion::query()->orderBy('sort_order')->get();
        $answers = [];

        foreach ($questions as $question) {
            if ((int) $question->sort_order !== 2) {
                $answers[$question->id] = 1;
            }
        }

        $response = $this->actingAs($user)->post(route('assessments.store', $patient), [
            'assessment_date' => '2026-08-27',
            'administration_mode' => 'dibacakan',
            'answers' => $answers,
        ]);

        $assessment = Assessment::query()->latest('id')->firstOrFail();

        $response->assertRedirect(route('assessments.show', $assessment));
        $this->assertSame('dibacakan', $assessment->administration_mode);
        $this->assertSame(1, $assessment->missing_item_count);
        $this->assertFalse($assessment->emotional_score_valid);
        $this->assertTrue($assessment->social_score_valid);
        $this->assertNull($assessment->decision_code);
        $this->assertSame(11, $assessment->answers()->count());
        $this->assertSame(1, $assessment->answers()->where('is_missing', true)->count());
    }

    public function test_clinical_assessment_rejects_more_than_one_missing_item(): void
    {
        [$user, $patient] = $this->clinicalContext();
        $questions = AssessmentQuestion::query()->orderBy('sort_order')->get();
        $answers = [];

        foreach ($questions as $question) {
            if (! in_array((int) $question->sort_order, [1, 2], true)) {
                $answers[$question->id] = 1;
            }
        }

        $response = $this->actingAs($user)->from(route('assessments.create', $patient))
            ->post(route('assessments.store', $patient), [
                'assessment_date' => '2026-08-27',
                'administration_mode' => 'mandiri',
                'answers' => $answers,
            ]);

        $response->assertRedirect(route('assessments.create', $patient));
        $response->assertSessionHasErrors('answers');
        $this->assertDatabaseCount('assessments', 0);
    }

    private function clinicalContext(): array
    {
        $user = User::factory()->create();
        $user->forceFill([
            'role' => 'perawat',
            'is_active' => true,
        ])->save();

        $patient = Patient::create([
            'kode_pasien' => 'TEST-001',
            'nama_inisial' => 'TS',
            'usia' => 45,
            'jenis_kelamin' => 'Laki-laki',
            'sadar' => true,
            'mampu_berkomunikasi' => true,
            'memahami_pertanyaan' => true,
            'bersedia_assessment' => true,
            'created_by' => $user->id,
        ]);

        return [$user, $patient];
    }
}
