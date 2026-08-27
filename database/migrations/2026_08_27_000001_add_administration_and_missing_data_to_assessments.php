<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->string('administration_mode', 20)->default('mandiri')->after('assessment_date');
            $table->unsignedTinyInteger('missing_item_count')->default(0)->after('total_score');
            $table->boolean('emotional_score_valid')->default(true)->after('emotional_score');
            $table->boolean('social_score_valid')->default(true)->after('social_score');
        });

        Schema::table('assessment_answers', function (Blueprint $table) {
            $table->boolean('is_missing')->default(false)->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_answers', function (Blueprint $table) {
            $table->dropColumn('is_missing');
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn([
                'administration_mode',
                'missing_item_count',
                'emotional_score_valid',
                'social_score_valid',
            ]);
        });
    }
};
