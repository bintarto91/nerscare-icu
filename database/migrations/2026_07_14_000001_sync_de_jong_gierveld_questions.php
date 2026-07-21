<?php

use App\Support\DeJongGierveldScale;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        foreach (DeJongGierveldScale::questions() as $sortOrder => $questionText) {
            $exists = DB::table('assessment_questions')
                ->where('sort_order', $sortOrder)
                ->exists();

            if ($exists) {
                DB::table('assessment_questions')
                    ->where('sort_order', $sortOrder)
                    ->update([
                        'question_text' => $questionText,
                        'is_active' => true,
                        'updated_at' => $now,
                    ]);
            } else {
                DB::table('assessment_questions')->insert([
                    'question_text' => $questionText,
                    'sort_order' => $sortOrder,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        DB::table('assessment_questions')
            ->where('sort_order', '>', 11)
            ->update([
                'is_active' => false,
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        DB::table('assessment_questions')
            ->where('sort_order', 11)
            ->update([
                'is_active' => false,
                'updated_at' => now(),
            ]);
    }
};
