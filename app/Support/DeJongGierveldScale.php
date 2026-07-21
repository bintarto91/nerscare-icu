<?php

namespace App\Support;

class DeJongGierveldScale
{
    public const EMOTIONAL_ITEMS = [2, 3, 5, 6, 9, 10];
    public const SOCIAL_ITEMS = [1, 4, 7, 8, 11];

    public static function questions(): array
    {
        return [
            1 => 'Selalu ada seseorang yang dapat saya ajak bicara tentang masalah sehari-hari saya.',
            2 => 'Saya merindukan memiliki teman yang benar-benar dekat.',
            3 => 'Saya merasakan kekosongan secara umum.',
            4 => 'Ada cukup banyak orang yang dapat saya andalkan ketika saya mengalami masalah.',
            5 => 'Saya merindukan kesenangan saat ditemani orang lain.',
            6 => 'Saya merasa lingkaran teman dan kenalan saya terlalu terbatas.',
            7 => 'Ada banyak orang yang dapat saya percayai sepenuhnya.',
            8 => 'Ada cukup banyak orang yang saya rasa dekat dengan saya.',
            9 => 'Saya merindukan adanya orang-orang di sekitar saya.',
            10 => 'Saya sering merasa ditolak.',
            11 => 'Saya dapat menghubungi teman saya kapan pun saya membutuhkannya.',
        ];
    }

    public static function answerOptions(): array
    {
        return [
            1 => 'Tidak pernah',
            2 => 'Jarang',
            3 => 'Kadang-kadang',
            4 => 'Sering',
            5 => 'Selalu',
        ];
    }

    public static function scoreRules(): array
    {
        return [
            'emotionalItems' => self::EMOTIONAL_ITEMS,
            'socialItems' => self::SOCIAL_ITEMS,
            'emotionalScoredValues' => [3, 4, 5],
            'socialScoredValues' => [1, 2, 3],
        ];
    }

    public static function categories(): array
    {
        return [
            [
                'category' => 'Not lonely',
                'min_score' => 0,
                'max_score' => 2,
                'interpretation' => 'Total skor menunjukkan pasien berada pada kategori not lonely berdasarkan De Jong Gierveld Loneliness Scale.',
                'nursing_recommendation' => 'Pertahankan komunikasi terapeutik, observasi kondisi psikososial pasien, dan dokumentasikan respons pasien secara berkala.',
                'family_education_recommendation' => 'Keluarga tetap dianjurkan memberi dukungan emosional positif sesuai arahan perawat dan kebijakan ruang ICU.',
            ],
            [
                'category' => 'Moderate lonely',
                'min_score' => 3,
                'max_score' => 8,
                'interpretation' => 'Total skor menunjukkan pasien berada pada kategori moderate lonely dan membutuhkan perhatian dukungan emosional maupun sosial.',
                'nursing_recommendation' => 'Tingkatkan komunikasi terapeutik, validasi perasaan pasien, dan fasilitasi dukungan keluarga sesuai kondisi klinis dan kebijakan ICU.',
                'family_education_recommendation' => 'Keluarga dianjurkan memberi kalimat dukungan, menjaga komunikasi yang menenangkan, dan mengikuti arahan petugas kesehatan.',
            ],
            [
                'category' => 'Severe lonely',
                'min_score' => 9,
                'max_score' => 10,
                'interpretation' => 'Total skor menunjukkan pasien berada pada kategori severe lonely sehingga perlu tindak lanjut dukungan yang lebih intensif.',
                'nursing_recommendation' => 'Perawat disarankan melakukan pemantauan lebih dekat, menggali faktor penyebab kesepian, dan mengoordinasikan dukungan keluarga atau tim kesehatan lain bila diperlukan.',
                'family_education_recommendation' => 'Keluarga dianjurkan meningkatkan dukungan emosional yang stabil, menenangkan, dan tidak menambah kecemasan pasien.',
            ],
            [
                'category' => 'Very severe lonely',
                'min_score' => 11,
                'max_score' => 11,
                'interpretation' => 'Total skor menunjukkan pasien berada pada kategori very severe lonely dan perlu menjadi prioritas tindak lanjut.',
                'nursing_recommendation' => 'Lakukan dukungan terapeutik lebih intensif, pemantauan berkelanjutan, dan pertimbangkan kolaborasi dengan tim kesehatan terkait sesuai kebijakan klinis.',
                'family_education_recommendation' => 'Keluarga dianjurkan memberi dukungan emosional lebih aktif dan konsisten sesuai arahan perawat serta kondisi pasien.',
            ],
        ];
    }

    public static function scoreAnswer(int $itemNumber, int $answerValue): int
    {
        if (in_array($itemNumber, self::EMOTIONAL_ITEMS, true)) {
            return in_array($answerValue, [3, 4, 5], true) ? 1 : 0;
        }

        if (in_array($itemNumber, self::SOCIAL_ITEMS, true)) {
            return in_array($answerValue, [1, 2, 3], true) ? 1 : 0;
        }

        return 0;
    }

    public static function dimensionForItem(int $itemNumber): string
    {
        return in_array($itemNumber, self::SOCIAL_ITEMS, true) ? 'social' : 'emotional';
    }

    public static function dimensionForQuestion($question): string
    {
        return self::dimensionForItem((int) ($question->sort_order ?? 0));
    }

    public static function answerLabel(int $answerValue): string
    {
        return self::answerOptions()[$answerValue] ?? '-';
    }

    public static function resultForScore(int $score): array
    {
        foreach (self::categories() as $category) {
            if ($score >= $category['min_score'] && $score <= $category['max_score']) {
                return $category;
            }
        }

        return [
            'category' => '-',
            'interpretation' => 'Kategori belum tersedia untuk skor ini.',
            'nursing_recommendation' => 'Periksa kembali kelengkapan jawaban assessment.',
            'family_education_recommendation' => 'Periksa kembali kelengkapan jawaban assessment.',
        ];
    }

    public static function categoryLabel(int $score): string
    {
        return self::resultForScore($score)['category'];
    }

    public static function scoreCategoryFromClient(): array
    {
        return array_map(function (array $category) {
            return [
                'category' => $category['category'],
                'min_score' => $category['min_score'],
                'max_score' => $category['max_score'],
                'interpretation' => $category['interpretation'],
                'family_education_recommendation' => $category['family_education_recommendation'],
            ];
        }, self::categories());
    }

    public static function dominantDimensionLabel(array $dimensionScores): string
    {
        $emotional = (int) ($dimensionScores['emotional'] ?? 0);
        $social = (int) ($dimensionScores['social'] ?? 0);

        if ($emotional > $social) {
            return 'Emotional Loneliness';
        }

        if ($social > $emotional) {
            return 'Social Loneliness';
        }

        if ($emotional > 0 || $social > 0) {
            return 'Emotional dan Social seimbang';
        }

        return '-';
    }
}
