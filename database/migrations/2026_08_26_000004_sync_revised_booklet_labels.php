<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('booklet_pages')) {
            return;
        }

        DB::table('booklet_pages')
            ->where('sort_order', 5)
            ->update([
                'points' => json_encode([
                    '0-2: Tidak kesepian.',
                    '3-8: Kesepian tingkat sedang.',
                    '9-10: Kesepian tingkat berat.',
                    '11: Kesepian tingkat sangat berat.',
                ]),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('booklet_pages')) {
            return;
        }

        DB::table('booklet_pages')
            ->where('sort_order', 5)
            ->update([
                'points' => json_encode([
                    '0-2: Not lonely.',
                    '3-8: Moderate lonely.',
                    '9-10: Severe lonely.',
                    '11: Very severe lonely.',
                ]),
                'updated_at' => now(),
            ]);
    }
};
