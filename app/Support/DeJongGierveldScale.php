<?php

namespace App\Support;

class DeJongGierveldScale
{
    public const EMOTIONAL_ITEMS = [2, 3, 5, 6, 9, 10];
    public const SOCIAL_ITEMS = [1, 4, 7, 8, 11];

    public static function questions(): array
    {
        return [
            1 => 'Selalu ada seseorang yang bisa saya ajak bicara mengenai masalah sehari-hari saya.',
            2 => 'Saya rindu memiliki teman yang sangat dekat.',
            3 => 'Saya mengalami perasaan hampa secara umum.',
            4 => 'Ada banyak orang yang bisa saya andalkan saat saya menghadapi masalah.',
            5 => 'Saya merindukan nikmatnya kebersamaan dengan orang lain.',
            6 => 'Saya merasa lingkaran pertemanan dan kenalan saya terlalu terbatas.',
            7 => 'Ada banyak orang yang bisa saya percayai sepenuhnya.',
            8 => 'Ada cukup banyak orang yang terasa dekat dengan saya.',
            9 => 'Saya merindukan dikelilingi orang-orang.',
            10 => 'Saya sering merasa ditolak.',
            11 => 'Saya dapat menghubungi teman-teman saya kapan pun saya membutuhkan mereka.',
        ];
    }

    public static function answerOptions(): array
    {
        return [
            1 => 'STS - Sangat tidak sesuai',
            2 => 'TS - Tidak sesuai',
            3 => 'KL - Kurang lebih',
            4 => 'S - Sesuai',
            5 => 'SS - Sangat sesuai',
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
                'category' => 'Tidak kesepian',
                'min_score' => 0,
                'max_score' => 2,
                'interpretation' => 'Hasil skor pada saat asesmen menunjukkan kategori tidak kesepian.',
            ],
            [
                'category' => 'Kesepian tingkat sedang',
                'min_score' => 3,
                'max_score' => 8,
                'interpretation' => 'Hasil skor pada saat asesmen menunjukkan tingkat kesepian sedang.',
            ],
            [
                'category' => 'Kesepian tingkat berat',
                'min_score' => 9,
                'max_score' => 10,
                'interpretation' => 'Hasil skor pada saat asesmen menunjukkan tingkat kesepian berat.',
            ],
            [
                'category' => 'Kesepian tingkat sangat berat',
                'min_score' => 11,
                'max_score' => 11,
                'interpretation' => 'Hasil skor pada saat asesmen menunjukkan tingkat kesepian sangat berat.',
            ],
        ];
    }

    public static function decisionOutputs(): array
    {
        return [
            'N0' => [
                'interpretation' => 'Hasil asesmen menunjukkan kategori tidak kesepian. Pada saat asesmen tidak tampak kebutuhan emosional maupun sosial yang menonjol berdasarkan skor.',
                'nursing_recommendation' => 'Pertahankan dukungan psikososial rutin melalui komunikasi terapeutik, orientasi, penghormatan terhadap privasi dan martabat, pemberian pilihan sederhana, serta pemantauan perubahan kebutuhan selama perawatan.',
                'family_education_recommendation' => 'Hadir dengan tenang, dengarkan pasien, sampaikan kabar yang familiar, dan pertahankan komunikasi sesuai keinginan serta kondisi pasien.',
                'clinical_decision_note' => 'Hasil menggambarkan kondisi pasien pada saat asesmen dan bukan diagnosis. Lakukan asesmen ulang bila kondisi klinis atau kebutuhan pasien berubah.',
            ],
            'NE' => [
                'interpretation' => 'Hasil asesmen menunjukkan kategori tidak kesepian, tetapi terdapat kecenderungan kebutuhan pada aspek emosional.',
                'nursing_recommendation' => 'Pertahankan dukungan rutin dan kehadiran terapeutik. Beri kesempatan pasien berbicara, dengarkan secara aktif, validasi perasaan, dan bantu pasien mempertahankan rasa aman serta kontrol selama perawatan.',
                'family_education_recommendation' => 'Dengarkan pasien tanpa memaksa untuk berbicara. Gunakan komunikasi yang tenang, familiar, dan memberikan rasa aman.',
                'clinical_decision_note' => 'Skor total belum menunjukkan loneliness. Rekomendasi pada tahap ini bersifat dukungan dan pemantauan, bukan terapi khusus berdasarkan skor.',
            ],
            'NS' => [
                'interpretation' => 'Hasil asesmen menunjukkan kategori tidak kesepian, tetapi terdapat kecenderungan kebutuhan pada aspek sosial.',
                'nursing_recommendation' => 'Pertahankan dukungan rutin dan koneksi sosial. Identifikasi orang yang bermakna bagi pasien dan bantu mempertahankan hubungan dengan keluarga atau orang terdekat sesuai preferensi pasien.',
                'family_education_recommendation' => 'Pertahankan kontak melalui kunjungan, pesan, suara, telepon, video, atau cara lain yang paling nyaman dan diperbolehkan.',
                'clinical_decision_note' => 'Skor total belum menunjukkan loneliness. Keterlibatan keluarga tetap perlu mempertimbangkan kondisi klinis dan preferensi pasien.',
            ],
            'NB' => [
                'interpretation' => 'Hasil asesmen menunjukkan kategori tidak kesepian. Kebutuhan emosional dan sosial relatif seimbang dan belum menunjukkan loneliness yang bermakna berdasarkan skor total.',
                'nursing_recommendation' => 'Pertahankan komunikasi terapeutik, koneksi dengan keluarga atau orang bermakna, serta personalisasi perawatan sesuai kebutuhan pasien.',
                'family_education_recommendation' => 'Hadir, dengarkan pasien, sampaikan kabar yang familiar, dan bantu pasien tetap merasa terhubung.',
                'clinical_decision_note' => 'Tidak diperlukan intensifikasi dukungan hanya berdasarkan skor saat ini. Tetap pantau perubahan kebutuhan selama perawatan di ICU.',
            ],
            'ME' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat sedang dengan kebutuhan emosional yang lebih menonjol. Pasien membutuhkan dukungan agar merasa didengar, dipahami, aman, dan tetap memiliki kontrol selama perawatan.',
                'nursing_recommendation' => 'Prioritaskan kehadiran terapeutik dan pendekatan yang humanistik. Dengarkan pasien, gunakan pertanyaan terbuka yang singkat, validasi emosi, dan berikan waktu untuk merespons. Personalisasikan dukungan psikososial; fasilitasi dukungan spiritual, makna, atau harapan bila dibutuhkan atau diinginkan pasien.',
                'family_education_recommendation' => 'Hadir dengan tenang dan lebih banyak mendengarkan. Hindari memaksa pasien untuk "kuat", segera merasa lebih baik, atau berpikir positif. Sampaikan kabar yang familiar dan beri kesempatan pasien beristirahat.',
                'clinical_decision_note' => 'Pilih satu sampai dua bentuk dukungan yang paling sesuai dengan kebutuhan pasien. Dukungan spiritual diberikan berdasarkan preferensi atau kebutuhan pasien, bukan secara otomatis.',
            ],
            'MS' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat sedang dengan kebutuhan koneksi sosial yang lebih menonjol. Pasien membutuhkan dukungan untuk tetap terhubung dengan keluarga atau orang yang bermakna.',
                'nursing_recommendation' => 'Prioritaskan pemeliharaan hubungan dengan orang yang bermakna. Identifikasi siapa yang ingin dihubungi pasien dan pertimbangkan kunjungan, rekaman suara, telepon, atau video sesuai kondisi. Bila pasien sulit berkomunikasi, gunakan bantuan komunikasi yang sederhana dan pertahankan kontinuitas relasi.',
                'family_education_recommendation' => 'Tanyakan bentuk komunikasi yang paling nyaman bagi pasien. Berikan pesan yang singkat, familiar, dan menenangkan. Gunakan kunjungan, suara, telepon, atau video sesuai kondisi pasien dan arahan ICU.',
                'clinical_decision_note' => 'Teknologi bukan kewajiban. Pilih metode komunikasi yang paling sederhana, aman, bermakna, dan dapat ditoleransi pasien.',
            ],
            'MB' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat sedang. Kebutuhan emosional dan sosial relatif seimbang, sehingga dukungan perlu membantu pasien merasa didengar sekaligus tetap terhubung dengan orang yang bermakna.',
                'nursing_recommendation' => 'Prioritaskan kehadiran terapeutik dan keterlibatan keluarga atau orang yang bermakna. Tambahkan satu bentuk dukungan lain sesuai kebutuhan pasien, seperti bantuan komunikasi, dukungan spiritual, atau personalisasi psikososial dan lingkungan.',
                'family_education_recommendation' => 'Hadir dengan tenang, dengarkan pasien, sampaikan kabar yang familiar, dan tanyakan siapa atau hal apa yang ingin tetap dihubungkan dengan pasien. Sesuaikan durasi interaksi dengan toleransi pasien.',
                'clinical_decision_note' => 'Pilih satu sampai tiga bentuk dukungan berdasarkan kebutuhan dominan setelah asesmen. Jangan memberikan seluruh dukungan secara otomatis hanya karena skor.',
            ],
            'HE' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat berat dengan kebutuhan emosional yang lebih menonjol. Diperlukan dukungan psikososial yang lebih terarah terhadap rasa dipahami, keamanan emosional, kontrol, dan kebutuhan personal pasien.',
                'nursing_recommendation' => 'Prioritaskan kehadiran terapeutik yang konsisten dan personalisasi dukungan psikososial. Pertimbangkan dukungan spiritual, makna, atau harapan bila terdapat kebutuhan, dan libatkan orang yang bermakna bila pasien menginginkannya. Evaluasi respons setelah dukungan diberikan.',
                'family_education_recommendation' => 'Berikan kehadiran yang konsisten tetapi tidak berlebihan. Dengarkan tanpa menghakimi atau memaksa pasien berpikir positif. Gunakan kabar yang familiar dan komunikasi yang menenangkan.',
                'clinical_decision_note' => 'Skor berat bukan otomatis menjadi indikasi rujukan psikolog atau psikiater. Pertimbangkan kondisi klinis dan tanda bahaya secara terpisah. Dokumentasikan respons pasien dan tindak lanjut.',
            ],
            'HS' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat berat dengan kebutuhan koneksi sosial yang lebih menonjol. Dukungan diarahkan terutama pada pemeliharaan hubungan pasien dengan orang yang bermakna.',
                'nursing_recommendation' => 'Prioritaskan keterlibatan keluarga atau orang yang bermakna serta kontinuitas relasi. Bila hambatan komunikasi menghalangi pasien berinteraksi, gunakan bantuan komunikasi yang sesuai. Evaluasi toleransi pasien terhadap kontak keluarga atau orang terdekat.',
                'family_education_recommendation' => 'Prioritaskan orang yang paling bermakna bagi pasien. Gunakan kunjungan, suara familiar, telepon, atau video sesuai preferensi. Buat kontak singkat dan bermakna; hentikan atau kurangi bila pasien lelah atau mengalami distres.',
                'clinical_decision_note' => 'Intensitas koneksi tidak harus berarti durasi yang lebih panjang. Sesuaikan dengan kemampuan komunikasi, kondisi medis, privasi, dan kebijakan ICU.',
            ],
            'HB' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat berat dengan kebutuhan emosional dan sosial yang sama-sama menonjol. Diperlukan pendekatan multimodal untuk mendukung hubungan terapeutik dan keterhubungan sosial.',
                'nursing_recommendation' => 'Prioritaskan kehadiran terapeutik dan keterlibatan keluarga atau orang yang bermakna. Tambahkan satu bentuk dukungan lain berdasarkan asesmen, seperti bantuan komunikasi, dukungan spiritual, atau personalisasi psikososial dan lingkungan. Evaluasi dan dokumentasikan respons pasien.',
                'family_education_recommendation' => 'Dengarkan tanpa menghakimi, pertahankan hubungan yang familiar, dan tanyakan preferensi pasien. Hindari terlalu banyak orang atau komunikasi yang terlalu panjang karena dapat menyebabkan kelelahan.',
                'clinical_decision_note' => 'Gunakan maksimal satu sampai tiga bentuk dukungan prioritas pada satu tahap, kemudian evaluasi respons pasien. Skor bukan diagnosis dan bukan satu-satunya dasar keputusan klinis.',
            ],
            'VHB' => [
                'interpretation' => 'Hasil asesmen menunjukkan loneliness tingkat sangat berat. Kebutuhan emosional dan sosial sama-sama sangat menonjol. Pasien membutuhkan dukungan psikososial yang terarah dan individual.',
                'nursing_recommendation' => 'Prioritaskan kehadiran terapeutik dan keterlibatan keluarga atau orang yang bermakna. Tambahkan dukungan lain sesuai kebutuhan pasien, seperti bantuan komunikasi, dukungan spiritual, atau personalisasi psikososial dan lingkungan. Evaluasi kenyamanan, komunikasi, rasa terhubung, kelelahan, dan distres. Dokumentasikan hasil untuk tindak lanjut antar-shift.',
                'family_education_recommendation' => 'Hadir secara konsisten, dengarkan pasien, pertahankan kontak dengan orang yang bermakna, gunakan komunikasi yang familiar, dan sesuaikan durasi dengan toleransi pasien. Koordinasikan semua bentuk dukungan dengan perawat.',
                'clinical_decision_note' => 'Hasil bukan diagnosis gangguan jiwa. Skor sangat tinggi tidak otomatis berarti rujukan. Lakukan evaluasi klinis terpisah untuk distres berat, risiko keselamatan, delirium, psikosis, atau kondisi lain yang memerlukan eskalasi.',
            ],
        ];
    }

    public static function decisionForScores(int $emotionalScore, int $socialScore): array
    {
        $totalScore = $emotionalScore + $socialScore;
        $category = static::resultForScore($totalScore);

        if ($emotionalScore === 0 && $socialScore === 0) {
            $profile = 'Tidak ada domain menonjol';
            $code = 'N0';
        } else {
            $emotionalPercentage = ($emotionalScore / 6) * 100;
            $socialPercentage = ($socialScore / 5) * 100;

            if (abs($emotionalPercentage - $socialPercentage) <= 15) {
                $profile = $totalScore === 11
                    ? 'Emosional & sosial sangat menonjol'
                    : 'Emosional & sosial relatif seimbang';
                $code = match ($category['category']) {
                    'Tidak kesepian' => 'NB',
                    'Kesepian tingkat sedang' => 'MB',
                    'Kesepian tingkat berat' => 'HB',
                    default => 'VHB',
                };
            } elseif ($emotionalPercentage > $socialPercentage) {
                $profile = 'Emosional dominan';
                $code = $category['category'] === 'Tidak kesepian' ? 'NE' : ($category['category'] === 'Kesepian tingkat sedang' ? 'ME' : 'HE');
            } else {
                $profile = 'Sosial dominan';
                $code = $category['category'] === 'Tidak kesepian' ? 'NS' : ($category['category'] === 'Kesepian tingkat sedang' ? 'MS' : 'HS');
            }
        }

        return array_merge($category, static::decisionOutputs()[$code], [
            'code' => $code,
            'profile' => $profile,
            'emotional_score' => $emotionalScore,
            'social_score' => $socialScore,
            'total_score' => $totalScore,
        ]);
    }

    public static function scoreResponses(array $responses): array
    {
        $dimensionScores = [
            'emotional' => 0,
            'social' => 0,
        ];
        $missingItems = [];
        $scoredResponses = [];

        foreach (array_keys(static::questions()) as $itemNumber) {
            $answerValue = $responses[$itemNumber] ?? null;

            if ($answerValue === null || $answerValue === '') {
                $missingItems[] = $itemNumber;
                $scoredResponses[$itemNumber] = null;
                continue;
            }

            $answerValue = (int) $answerValue;

            if ($answerValue < 1 || $answerValue > 5) {
                throw new \InvalidArgumentException("Nilai respons item {$itemNumber} harus berada pada rentang 1 sampai 5.");
            }

            $score = static::scoreAnswer($itemNumber, $answerValue);
            $dimension = static::dimensionForItem($itemNumber);
            $dimensionScores[$dimension] += $score;
            $scoredResponses[$itemNumber] = [
                'answer_value' => $answerValue,
                'score' => $score,
            ];
        }

        if (count($missingItems) > 1) {
            throw new \InvalidArgumentException('Maksimal satu item boleh tidak dijawab agar skor total tetap valid.');
        }

        $missingDimension = $missingItems === []
            ? null
            : static::dimensionForItem($missingItems[0]);
        $totalScore = $dimensionScores['emotional'] + $dimensionScores['social'];

        if ($missingItems === []) {
            $result = static::decisionForScores(
                $dimensionScores['emotional'],
                $dimensionScores['social']
            );
        } else {
            $category = static::resultForScore($totalScore);
            $invalidDomainLabel = ($missingDimension === 'emotional' ? 'emosional' : 'sosial') . ' loneliness';

            $result = array_merge($category, [
                'code' => null,
                'profile' => 'Tidak dapat ditentukan karena subskala ' . $invalidDomainLabel . ' tidak lengkap',
                'interpretation' => $category['interpretation'] . ' Skor total tetap valid karena hanya satu item tidak terisi, tetapi subskala ' . $invalidDomainLabel . ' tidak valid.',
                'nursing_recommendation' => 'Pertahankan dukungan psikososial rutin dan lakukan asesmen ulang atau lengkapi item yang kosong sebelum menggunakan rekomendasi berbasis profil emosional-sosial.',
                'family_education_recommendation' => 'Pertahankan dukungan yang tenang dan familiar sesuai preferensi serta kondisi pasien. Jangan meningkatkan intensitas dukungan hanya berdasarkan profil domain yang belum lengkap.',
                'clinical_decision_note' => 'Satu item tidak terisi: skor total dapat digunakan sesuai aturan data hilang, tetapi kode keputusan dan profil domain tidak diterbitkan karena salah satu subskala tidak valid.',
                'emotional_score' => $dimensionScores['emotional'],
                'social_score' => $dimensionScores['social'],
                'total_score' => $totalScore,
            ]);
        }

        return array_merge($result, [
            'scored_responses' => $scoredResponses,
            'missing_items' => $missingItems,
            'missing_item_count' => count($missingItems),
            'emotional_score_valid' => $missingDimension !== 'emotional',
            'social_score_valid' => $missingDimension !== 'social',
        ]);
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
        ];
    }

    public static function categoryLabel(int $score): string
    {
        return self::resultForScore($score)['category'];
    }

    public static function categoryLabels(): array
    {
        return array_column(self::categories(), 'category');
    }

    public static function categoryRiskLevel(?string $category): string
    {
        $category = mb_strtolower(trim((string) $category));

        if ($category === '') {
            return 'unknown';
        }

        if (
            str_contains($category, 'sangat berat')
            || str_contains($category, 'berat')
            || str_contains($category, 'very severe')
            || str_contains($category, 'severe')
            || str_contains($category, 'tinggi')
        ) {
            return 'high';
        }

        if (str_contains($category, 'sedang') || str_contains($category, 'moderate')) {
            return 'medium';
        }

        if (
            str_contains($category, 'tidak kesepian')
            || str_contains($category, 'not lonely')
            || str_contains($category, 'rendah')
        ) {
            return 'low';
        }

        return 'unknown';
    }

    public static function scoreCategoryFromClient(): array
    {
        return array_map(function (array $category) {
            return [
                'category' => $category['category'],
                'min_score' => $category['min_score'],
                'max_score' => $category['max_score'],
                'interpretation' => $category['interpretation'],
            ];
        }, self::categories());
    }

    public static function decisionOutputsForClient(): array
    {
        return static::decisionOutputs();
    }

    public static function personalizationTriggers(): array
    {
        return [
            'communication_barrier' => [
                'code' => 'I2',
                'label' => 'Pasien sulit bicara atau terintubasi tetapi masih mampu berkomunikasi',
                'focus' => 'Dukungan komunikasi pasien',
                'recommendation' => 'Gunakan papan YA/TIDAK, alfabet atau pictogram, satu pertanyaan setiap kali, dan konfirmasi kembali pesan pasien.',
            ],
            'family_contact' => [
                'code' => 'I4',
                'label' => 'Pasien ingin menghubungi keluarga atau orang tertentu',
                'focus' => 'Keterlibatan keluarga atau orang bermakna',
                'recommendation' => 'Identifikasi orang yang bermakna; pilih kunjungan, suara, telepon, atau video sesuai kondisi dan preferensi pasien.',
            ],
            'spiritual_need' => [
                'code' => 'I3',
                'label' => 'Pasien takut, kehilangan harapan, meminta doa, atau ritual',
                'focus' => 'Dukungan spiritual, makna, dan harapan',
                'recommendation' => 'Kaji preferensi pasien, fasilitasi sesuai keinginan, dan hindari pemaksaan.',
            ],
            'loss_of_control' => [
                'code' => 'I5',
                'label' => 'Pasien merasa kehilangan kontrol',
                'focus' => 'Pilihan dan kontrol',
                'recommendation' => 'Berikan pilihan kecil yang aman dan realistis sesuai kondisi pasien.',
            ],
            'familiar_activity' => [
                'code' => 'I5',
                'label' => 'Pasien bosan atau membutuhkan hal yang familiar',
                'focus' => 'Aktivitas bermakna',
                'recommendation' => 'Gunakan musik, foto, cerita, objek yang familiar, atau kegiatan sederhana sesuai kondisi pasien.',
            ],
            'sleep_calm' => [
                'code' => 'I5',
                'label' => 'Pasien sulit tidur atau terganggu kebisingan',
                'focus' => 'Tidur dan ketenangan',
                'recommendation' => 'Kurangi stimulasi yang tidak perlu dan dukung rutinitas istirahat.',
            ],
            'orientation_need' => [
                'code' => 'I5',
                'label' => 'Pasien kehilangan orientasi',
                'focus' => 'Orientasi',
                'recommendation' => 'Sampaikan hari/tanggal, lokasi, petugas, dan rencana hari secara sederhana.',
            ],
            'privacy_dignity' => [
                'code' => 'I5',
                'label' => 'Privasi atau martabat menjadi masalah',
                'focus' => 'Privasi dan martabat',
                'recommendation' => 'Jaga tirai dan paparan tubuh, minta izin sebelum melibatkan keluarga, dan pertahankan kerahasiaan informasi.',
            ],
        ];
    }

    public static function safetyAlerts(): array
    {
        return [
            'self_harm' => [
                'label' => 'Pasien menyatakan ingin menyakiti diri',
                'response' => 'Prioritaskan evaluasi klinis segera dan eskalasi sesuai jalur pelayanan atau SOP rumah sakit.',
                'urgency' => 'segera',
            ],
            'severe_confusion_agitation' => [
                'label' => 'Kebingungan berat atau agitasi berat',
                'response' => 'Lakukan evaluasi klinis dan pertimbangkan kondisi lain seperti delirium sesuai penilaian klinis.',
                'urgency' => 'prioritas',
            ],
            'hallucination_psychosis' => [
                'label' => 'Halusinasi atau gejala psikosis',
                'response' => 'Koordinasikan evaluasi profesional sesuai jalur klinis.',
                'urgency' => 'prioritas',
            ],
            'severe_distress' => [
                'label' => 'Distres berat',
                'response' => 'Evaluasi kondisi dan lakukan eskalasi sesuai SOP rumah sakit.',
                'urgency' => 'prioritas',
            ],
            'beyond_routine_support' => [
                'label' => 'Masalah psikologis melampaui dukungan keperawatan rutin',
                'response' => 'Koordinasikan dengan tenaga profesional sesuai kebutuhan.',
                'urgency' => 'koordinasi',
            ],
        ];
    }

    public static function selectedSafetyAlerts(array $selectedKeys): array
    {
        $alerts = static::safetyAlerts();

        return array_values(array_filter(array_map(
            function (string $key) use ($alerts): ?array {
                if (! isset($alerts[$key])) {
                    return null;
                }

                return array_merge(['key' => $key], $alerts[$key]);
            },
            array_values(array_unique($selectedKeys))
        )));
    }

    public static function dominantDimensionLabel(array $dimensionScores): string
    {
        return static::decisionForScores(
            (int) ($dimensionScores['emotional'] ?? 0),
            (int) ($dimensionScores['social'] ?? 0)
        )['profile'];
    }
}
