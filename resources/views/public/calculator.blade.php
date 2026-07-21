<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=8">
    <meta name="theme-color" content="#0b6f73">
    <link rel="icon" href="{{ asset('icons/icon.svg') }}?v=8" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=8" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}?v=8">
    <meta charset="UTF-8">
    <title>{{ $settings['landing_calculator_title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <style>
        :root {
            --ink: #10212b;
            --muted: #5f7180;
            --line: #d8e4ea;
            --surface: #ffffff;
            --surface-soft: #f4f9fb;
            --teal: #0b6f73;
            --teal-dark: #084e55;
            --blue: #2563a9;
            --blue-soft: #eaf2ff;
            --mint: #dff7f5;
            --amber: #b7791f;
            --amber-soft: #fff7e6;
            --danger: #b42318;
            --shadow: 0 22px 58px rgba(16, 33, 43, .10);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at 12% 8%, rgba(11, 111, 115, .12), transparent 28%),
                radial-gradient(circle at 86% 12%, rgba(37, 99, 169, .12), transparent 30%),
                linear-gradient(180deg, #f6fbfc 0%, #eef6f8 56%, #f8fbfc 100%);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
            padding-bottom: 108px;
        }

        a {
            text-decoration: none;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, .94);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .topbar-inner {
            max-width: 1180px;
            min-height: 72px;
            margin: auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-weight: 900;
        }

        .brand-mark {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #f4fbfb;
            display: block;
            overflow: hidden;
            flex: 0 0 46px;
            box-shadow: 0 14px 26px rgba(11, 111, 115, .18);
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .brand span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            margin-top: 2px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 18px;
            border-radius: 14px;
            border: 1px solid transparent;
            background: var(--teal);
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 13px 26px rgba(11, 111, 115, .18);
            transition: .18s;
        }

        .btn:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
        }

        .btn-light {
            background: white;
            border-color: var(--line);
            color: var(--ink);
        }

        .btn-light:hover {
            background: #edf5f7;
        }

        .page-notice {
            position: fixed;
            left: 50%;
            bottom: 26px;
            z-index: 60;
            width: min(420px, calc(100% - 32px));
            padding: 15px 17px;
            border-radius: 16px;
            background: #10212b;
            color: white;
            box-shadow: 0 18px 48px rgba(16, 33, 43, .28);
            opacity: 0;
            transform: translate(-50%, 18px);
            pointer-events: none;
            transition: .2s ease;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 800;
        }

        .page-notice.show {
            opacity: 1;
            transform: translate(-50%, 0);
        }

        .container {
            max-width: 1180px;
            margin: 34px auto 0;
            padding: 0 24px;
        }

        .hero {
            overflow: hidden;
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(300px, .75fr);
            gap: 28px;
            align-items: stretch;
            margin-bottom: 22px;
            padding: 34px;
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, .26);
            background:
                linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px),
                linear-gradient(135deg, #128477 0%, #0b6f73 45%, #075263 72%, #082f49 100%);
            background-size: 48px 100%, 100% 100%;
            color: white;
            box-shadow: 0 30px 78px rgba(8, 47, 73, .20);
        }

        .hero::after {
            content: "";
            position: absolute;
            right: -120px;
            bottom: -170px;
            width: 390px;
            height: 390px;
            border: 46px solid rgba(255, 255, 255, .08);
            border-radius: 50%;
        }

        .hero-main,
        .hero-side,
        .note,
        .progress-card,
        .question-card,
        .result-card,
        .result-box,
        .interpretation,
        .recommendation {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        .hero-main {
            position: relative;
            z-index: 1;
            padding: 0;
            background: transparent;
            border: 0;
            box-shadow: none;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 13px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .24);
            color: white;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .4px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .hero h1 {
            max-width: 760px;
            color: white;
            font-size: 44px;
            line-height: 1.08;
            margin-bottom: 16px;
        }

        .hero p {
            max-width: 760px;
            color: #e9fffd;
            line-height: 1.75;
            font-size: 17px;
            margin-bottom: 22px;
        }

        .hero-benefits {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            max-width: 820px;
        }

        .benefit-chip {
            min-height: 76px;
            padding: 14px 15px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 18px;
            background: rgba(255, 255, 255, .13);
            backdrop-filter: blur(8px);
        }

        .benefit-chip strong {
            display: block;
            color: white;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .benefit-chip span {
            display: block;
            color: #d8fffb;
            font-size: 12px;
            line-height: 1.45;
        }

        .hero-side {
            position: relative;
            z-index: 1;
            padding: 24px;
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .20);
            border-radius: 24px;
            box-shadow: 0 22px 58px rgba(0, 0, 0, .16);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 18px;
            backdrop-filter: blur(12px);
        }

        .hero-side > div:first-child span {
            color: #b8c6ce;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .hero-side strong {
            display: block;
            margin-top: 8px;
            font-size: 58px;
            line-height: 1;
        }

        .hero-side p {
            color: #dce8ee;
            font-size: 13px;
            line-height: 1.55;
        }

        .side-list {
            display: grid;
            gap: 10px;
        }

        .side-list div {
            display: grid;
            grid-template-columns: 28px 1fr;
            gap: 10px;
            align-items: center;
            min-height: 48px;
            padding: 10px 12px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .13);
            color: #ecfffd;
            font-size: 13px;
            font-weight: 800;
        }

        .side-list span {
            color: #ecfffd;
            font-size: 13px;
            font-weight: 800;
            text-transform: none;
        }

        .side-list b {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: white;
            color: var(--teal);
            display: grid;
            place-items: center;
            font-size: 13px;
        }

        .note {
            background: linear-gradient(135deg, #fff8e9, #ffffff);
            border-color: #f4d28a;
            color: #7a4d11;
            padding: 18px 20px;
            line-height: 1.65;
            margin-bottom: 18px;
            font-size: 14px;
            border-left: 5px solid #d97706;
        }

        .progress-card,
        .question-card,
        .result-card {
            padding: 22px;
            margin-bottom: 18px;
        }

        .progress-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: var(--ink);
            font-size: 14px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .bar {
            height: 12px;
            background: #e5eef2;
            border-radius: 999px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--teal), var(--blue));
            transition: .2s;
        }

        .question-title {
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .number {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: var(--mint);
            color: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
        }

        .question-title strong {
            line-height: 1.55;
            font-size: 17px;
        }

        .question-hint {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
        }

        .question-card {
            position: relative;
            overflow: hidden;
            transition: .18s;
        }

        .question-card::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 5px;
            background: #d8e4ea;
        }

        .question-card.answered {
            border-color: rgba(11, 111, 115, .45);
            box-shadow: 0 22px 58px rgba(11, 111, 115, .10);
        }

        .question-card.answered::before {
            background: var(--teal);
        }

        .question-card.answered .number {
            background: var(--teal);
            color: white;
        }

        .answers {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 10px;
        }

        .answer-option {
            cursor: pointer;
            display: block;
        }

        .answer-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .answer-box {
            border: 1px solid var(--line);
            background: linear-gradient(180deg, #ffffff, #f8fbfc);
            border-radius: 16px;
            padding: 14px 10px;
            text-align: center;
            min-height: 88px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: .18s;
        }

        .label {
            color: var(--ink);
            font-size: 14px;
            font-weight: 800;
            line-height: 1.35;
        }

        .answer-option input:checked + .answer-box {
            background: linear-gradient(135deg, var(--teal), var(--blue));
            border-color: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(11, 111, 115, .24);
        }

        .answer-option input:focus-visible + .answer-box {
            outline: 3px solid rgba(37, 99, 169, .24);
            outline-offset: 2px;
        }

        .answer-option input:checked + .answer-box .label {
            color: white;
        }

        .result-card {
            border-color: rgba(11, 111, 115, .5);
            background:
                linear-gradient(180deg, #ffffff 0%, #f7fbfc 100%);
            display: none;
        }

        .result-card h2 {
            margin-bottom: 14px;
            font-size: 22px;
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 14px;
            margin-bottom: 16px;
        }

        .result-box {
            box-shadow: none;
            padding: 16px;
            text-align: center;
            background: white;
            border-radius: 18px;
        }

        .result-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .result-number {
            color: var(--teal);
            font-size: 32px;
            font-weight: 900;
        }

        .category {
            display: inline-flex;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 16px;
            font-weight: 900;
        }

        .cat-low {
            background: #e6f5ea;
            color: #17623a;
        }

        .cat-medium {
            background: #fff4d6;
            color: #8a5b0e;
        }

        .cat-high {
            background: #fde7e5;
            color: var(--danger);
        }

        .interpretation,
        .recommendation {
            box-shadow: none;
            padding: 16px;
            line-height: 1.7;
            color: #334653;
        }

        .interpretation {
            background: #edf7f8;
            margin-bottom: 12px;
        }

        .recommendation {
            background: #ffffff;
        }

        .section-label {
            display: block;
            margin-bottom: 8px;
            color: var(--ink);
            font-weight: 900;
        }

        .footer-actions {
            position: fixed;
            inset: auto 0 0 0;
            z-index: 30;
            background: rgba(244, 249, 251, .82);
            border-top: 1px solid var(--line);
            backdrop-filter: blur(10px);
            padding: 14px 18px;
        }

        .footer-inner {
            max-width: 1180px;
            margin: auto;
            background: white;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 16px 18px;
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
            box-shadow: 0 -10px 28px rgba(16, 33, 43, .08);
        }

        .total-preview {
            font-weight: 900;
        }

        .total-preview span {
            color: var(--teal);
            font-size: 28px;
        }

        .total-preview small {
            color: var(--muted);
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media(max-width: 840px) {
            body {
                padding-bottom: 154px;
            }

            .hero,
            .hero-benefits,
            .answers,
            .result-grid {
                grid-template-columns: 1fr;
            }

            .topbar-inner {
                align-items: center;
                flex-direction: row;
                padding: 14px 18px;
            }

            .brand {
                min-width: 0;
                max-width: calc(100% - 104px);
            }

            .brand-mark {
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
                border-radius: 13px;
                font-size: 15px;
            }

            .brand > div:last-child {
                font-size: 14px;
                line-height: 1.25;
                min-width: 0;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .brand span {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .actions {
                flex: 0 0 auto;
            }

            .actions .btn {
                min-height: 40px;
                padding: 0 14px;
                font-size: 13px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero {
                padding: 24px;
                border-radius: 22px;
            }

            .footer-inner {
                align-items: stretch;
                flex-direction: column;
            }
        }

        @media(max-width: 420px) {
            .brand span {
                display: none;
            }

            .actions .btn {
                min-height: 38px;
                padding: 0 12px;
            }
        }
    </style>
</head>

<body>
    <nav class="topbar">
        <div class="topbar-inner">
            <a href="{{ route('public.landing') }}" class="brand">
                <div class="brand-mark">
                    <img src="{{ asset('icons/icon.svg') }}?v=8" alt="NersCare ICU">
                </div>
                <div>
                    {{ $settings['app_name'] }}
                    <span>Kalkulator public loneliness</span>
                </div>
            </a>

            <div class="actions">
                <a href="{{ route('public.landing') }}" class="btn btn-light">Beranda</a>
                <a href="{{ route('login') }}" class="btn">Login Petugas</a>
            </div>
        </div>
    </nav>

    <div class="page-notice" id="pageNotice" role="status" aria-live="polite"></div>

    <main class="container">
        <section class="hero">
            <div class="hero-main">
                <div class="eyebrow">Simulasi edukatif</div>
                <h1>{{ $settings['landing_calculator_title'] }}</h1>
                <p>{{ $settings['landing_calculator_description'] }}</p>
                <div class="hero-benefits">
                    <div class="benefit-chip">
                        <strong>Tanpa login</strong>
                        <span>Bisa dicoba langsung oleh pengunjung umum.</span>
                    </div>
                    <div class="benefit-chip">
                        <strong>Tidak tersimpan</strong>
                        <span>Jawaban simulasi tidak masuk ke database pasien.</span>
                    </div>
                    <div class="benefit-chip">
                        <strong>Hasil langsung</strong>
                        <span>Kategori tampil setelah semua pertanyaan lengkap.</span>
                    </div>
                </div>
            </div>
            <div class="hero-side">
                <div>
                    <span>Total pertanyaan</span>
                    <strong>{{ $questions->count() }}</strong>
                </div>
                <div class="side-list">
                    <div><b>1</b><span>Baca pertanyaan dengan tenang.</span></div>
                    <div><b>2</b><span>Pilih jawaban yang paling sesuai.</span></div>
                    <div><b>3</b><span>Lihat skor dan saran edukasi umum.</span></div>
                </div>
            </div>
        </section>

        <div class="note">
            <strong>Penting:</strong>
            {{ $settings['clinical_disclaimer'] }}
        </div>

        <div class="progress-card">
            <div class="progress-row">
                <span>Progress Pengisian</span>
                <span id="progressText">0 / {{ $questions->count() }} pertanyaan</span>
            </div>
            <div class="bar">
                <div class="bar-fill" id="progressFill"></div>
            </div>
        </div>

        <form id="publicCalculatorForm">
            <div id="questionsContainer"></div>
        </form>

        <div class="result-card" id="resultCard">
            <h2>Hasil Simulasi</h2>

            <div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Total Skor</div>
                    <div class="result-number" id="resultScore">0</div>
                </div>

                <div class="result-box">
                    <div class="result-label">Kategori</div>
                    <div id="resultCategory"></div>
                </div>

                <div class="result-box">
                    <div class="result-label">Emotional Loneliness</div>
                    <div class="result-number" id="resultEmotionalScore">0</div>
                </div>

                <div class="result-box">
                    <div class="result-label">Social Loneliness</div>
                    <div class="result-number" id="resultSocialScore">0</div>
                </div>

                <div class="result-box">
                    <div class="result-label">Kategori Lain</div>
                    <div id="resultDominantDimension">-</div>
                </div>

                <div class="result-box">
                    <div class="result-label">Jumlah Pertanyaan</div>
                    <div class="result-number">{{ $questions->count() }}</div>
                </div>
            </div>

            <div class="interpretation">
                <strong class="section-label">Interpretasi Awal</strong>
                <div id="resultInterpretation"></div>
            </div>

            <div class="recommendation">
                <strong class="section-label">Saran Edukasi Umum</strong>
                <div id="resultRecommendation"></div>
            </div>
        </div>
    </main>

    <div class="footer-actions">
        <div class="footer-inner">
            <div class="total-preview">
                Total Skor:
                <span id="scorePreview">0</span>
                <br>
                <small>Kategori: <strong id="categoryPreview">-</strong></small>
                <br>
                <small>Kategori lain: <strong id="dominantDimensionFooter">-</strong></small>
            </div>

            <div class="actions">
                <button type="button" class="btn btn-light" onclick="resetCalculator()">Reset</button>
                <button type="button" class="btn" onclick="scrollToResult()">Lihat Hasil</button>
            </div>
        </div>
    </div>

    <script>
        const questions = @json($questions);
        const interpretations = @json($interpretations);
        const scoreRules = @json($scoreRules);
        const options = Object.entries(@json($answerOptions)).map(function(option) {
            return {
                value: parseInt(option[0]),
                label: option[1]
            };
        });

        const questionsContainer = document.getElementById('questionsContainer');

        function getQuestionDimension(question) {
            const itemNumber = parseInt(question.sort_order || 0);
            return scoreRules.socialItems.includes(itemNumber) ? 'social' : 'emotional';
        }

        function scoreAnswer(itemNumber, answerValue) {
            if (scoreRules.emotionalItems.includes(itemNumber)) {
                return scoreRules.emotionalScoredValues.includes(answerValue) ? 1 : 0;
            }

            if (scoreRules.socialItems.includes(itemNumber)) {
                return scoreRules.socialScoredValues.includes(answerValue) ? 1 : 0;
            }

            return 0;
        }

        function appendQuestion(question, index) {
            const questionNumber = index + 1;
            const card = document.createElement('div');
            card.className = 'question-card';
            card.dataset.dimension = getQuestionDimension(question);
            card.dataset.questionOrder = question.sort_order || questionNumber;

            const title = document.createElement('div');
            title.className = 'question-title';

            const number = document.createElement('div');
            number.className = 'number';
            number.textContent = questionNumber;

            const copy = document.createElement('div');

            const text = document.createElement('strong');
            text.textContent = question.question_text || question;

            const hint = document.createElement('span');
            hint.className = 'question-hint';
            hint.textContent = 'Pilih satu jawaban yang paling sesuai dengan kondisi pasien.';

            title.appendChild(number);
            copy.appendChild(text);
            copy.appendChild(hint);
            title.appendChild(copy);
            card.appendChild(title);

            const answers = document.createElement('div');
            answers.className = 'answers';

            options.forEach(function(option) {
                const label = document.createElement('label');
                label.className = 'answer-option';

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = 'question_' + questionNumber;
                input.value = option.value;
                input.className = 'answer-radio';
                input.dataset.answerValue = option.value;

                const box = document.createElement('div');
                box.className = 'answer-box';

                const answerLabel = document.createElement('div');
                answerLabel.className = 'label';
                answerLabel.textContent = option.label;

                box.appendChild(answerLabel);
                label.appendChild(input);
                label.appendChild(box);
                answers.appendChild(label);
            });

            card.appendChild(answers);
            questionsContainer.appendChild(card);
        }

        questions.forEach(appendQuestion);

        function calculateResult() {
            const checkedAnswers = document.querySelectorAll('.answer-radio:checked');
            const answered = checkedAnswers.length;
            const totalQuestions = questions.length;

            let totalScore = 0;
            const dimensionScores = {
                emotional: 0,
                social: 0
            };

            checkedAnswers.forEach(function(answer) {
                const answerValue = parseInt(answer.dataset.answerValue || answer.value || 0);
                const card = answer.closest('.question-card');
                const dimension = card ? card.dataset.dimension : 'emotional';
                const itemNumber = card ? parseInt(card.dataset.questionOrder || 0) : 0;
                const score = scoreAnswer(itemNumber, answerValue);

                totalScore += score;

                if (dimension === 'social') {
                    dimensionScores.social += score;
                } else {
                    dimensionScores.emotional += score;
                }
            });

            const percent = totalQuestions > 0 ? (answered / totalQuestions) * 100 : 0;

            document.querySelectorAll('.question-card').forEach(function(card) {
                const hasAnswer = card.querySelector('.answer-radio:checked');
                card.classList.toggle('answered', Boolean(hasAnswer));
            });

            document.getElementById('progressText').innerText = answered + ' / ' + totalQuestions + ' pertanyaan';
            document.getElementById('progressFill').style.width = percent + '%';
            document.getElementById('scorePreview').innerText = totalScore;

            let category = '-';
            let categoryClass = '';
            let interpretation = '';
            let recommendation = '';
            let dominantDimension = '-';

            if (answered === totalQuestions) {
                if (dimensionScores.emotional > dimensionScores.social) {
                    dominantDimension = 'Emotional Loneliness';
                } else if (dimensionScores.social > dimensionScores.emotional) {
                    dominantDimension = 'Social Loneliness';
                } else {
                    dominantDimension = 'Emotional dan Social seimbang';
                }

                const matched = interpretations.find(function(item) {
                    return totalScore >= item.min_score && totalScore <= item.max_score;
                });

                if (matched) {
                    category = matched.category;
                    interpretation = matched.interpretation;
                    recommendation = matched.family_education_recommendation;

                    if (category.toLowerCase().includes('not')) {
                        categoryClass = 'cat-low';
                    } else if (category.toLowerCase().includes('moderate')) {
                        categoryClass = 'cat-medium';
                    } else if (category.toLowerCase().includes('severe')) {
                        categoryClass = 'cat-high';
                    } else {
                        categoryClass = 'cat-medium';
                    }
                } else {
                    category = 'Belum Ada Pengaturan';
                    categoryClass = 'cat-medium';
                    interpretation = 'Belum ada pengaturan interpretasi yang sesuai dengan total skor ini.';
                    recommendation = 'Silakan hubungi admin untuk melengkapi pengaturan interpretasi.';
                }

                document.getElementById('resultCard').style.display = 'block';
            }

            document.getElementById('categoryPreview').innerText = category;
            document.getElementById('dominantDimensionFooter').innerText = dominantDimension;
            document.getElementById('resultScore').innerText = totalScore;
            document.getElementById('resultEmotionalScore').innerText = dimensionScores.emotional;
            document.getElementById('resultSocialScore').innerText = dimensionScores.social;
            document.getElementById('resultDominantDimension').innerText = dominantDimension;
            document.getElementById('resultCategory').innerHTML = category === '-'
                ? '-'
                : '<span class="category ' + categoryClass + '">' + category + '</span>';
            document.getElementById('resultInterpretation').innerText = interpretation;
            document.getElementById('resultRecommendation').innerText = recommendation;
        }

        function resetCalculator() {
            document.querySelectorAll('.answer-radio').forEach(function(answer) {
                answer.checked = false;
            });

            document.getElementById('resultCard').style.display = 'none';
            calculateResult();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function scrollToResult() {
            const answered = document.querySelectorAll('.answer-radio:checked').length;

            if (answered < questions.length) {
                showPageNotice('Lengkapi semua pertanyaan terlebih dahulu untuk melihat hasil.');
                return;
            }

            document.getElementById('resultCard').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        let pageNoticeTimer = null;

        function showPageNotice(message) {
            const notice = document.getElementById('pageNotice');

            if (!notice) {
                return;
            }

            notice.textContent = message;
            notice.classList.add('show');

            if (pageNoticeTimer) {
                window.clearTimeout(pageNoticeTimer);
            }

            pageNoticeTimer = window.setTimeout(function() {
                notice.classList.remove('show');
            }, 3200);
        }

        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('answer-radio')) {
                calculateResult();
            }
        });

        calculateResult();
    </script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/service-worker.js');
            });
        }
    </script>
</body>
</html>
