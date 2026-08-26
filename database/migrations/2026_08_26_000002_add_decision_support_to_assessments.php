<?php

use App\Support\DeJongGierveldScale;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->unsignedTinyInteger('emotional_score')->default(0)->after('total_score');
            $table->unsignedTinyInteger('social_score')->default(0)->after('emotional_score');
            $table->string('decision_code', 10)->nullable()->after('category');
            $table->string('decision_profile')->nullable()->after('decision_code');
            $table->text('clinical_decision_note')->nullable()->after('family_education_recommendation');
            $table->json('personalization_triggers')->nullable()->after('clinical_decision_note');
            $table->boolean('safety_alert')->default(false)->after('personalization_triggers');
            $table->text('safety_alert_notes')->nullable()->after('safety_alert');
        });

        $now = now();

        foreach (DeJongGierveldScale::questions() as $sortOrder => $questionText) {
            DB::table('assessment_questions')
                ->where('sort_order', $sortOrder)
                ->update([
                    'question_text' => $questionText,
                    'is_active' => true,
                    'updated_at' => $now,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn([
                'emotional_score',
                'social_score',
                'decision_code',
                'decision_profile',
                'clinical_decision_note',
                'personalization_triggers',
                'safety_alert',
                'safety_alert_notes',
            ]);
        });
    }
};