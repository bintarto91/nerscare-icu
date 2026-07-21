@extends('layouts.app')

@section('title', 'Assessment Loneliness')
@section('page_title', 'Assessment Loneliness')
@section('page_subtitle', 'Pengisian instrumen penilaian loneliness pasien ICU.')

@section('content')
<style>
    .assessment-header {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 24px;
        padding: 26px;
        margin-bottom: 22px;
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 18px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
        position: relative;
        overflow: hidden;
    }

    .assessment-header::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        right: -70px;
        top: -80px;
    }

    .assessment-header > div {
        position: relative;
        z-index: 1;
    }

    .assessment-header h2 {
        margin: 0 0 8px;
        font-size: 27px;
        color: white;
    }

    .assessment-header p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.6;
    }

    .patient-summary {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 18px;
        padding: 16px;
        display: grid;
        gap: 8px;
        font-size: 14px;
        backdrop-filter: blur(8px);
    }

    .patient-summary div {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,.14);
        padding-bottom: 8px;
    }

    .patient-summary div:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .patient-summary span {
        color: #d9fffb;
    }

    .patient-summary strong {
        text-align: right;
        color: white;
    }

    .assessment-progress {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: 0 12px 35px rgba(15,23,42,.06);
    }

    .progress-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
        color: #334155;
        font-size: 14px;
        font-weight: 800;
    }

    .progress-bar {
        height: 12px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #0b6f73, #2563a9);
        border-radius: 999px;
        transition: .2s;
    }

    .mobile-step-box {
        display: none;
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 18px;
        padding: 14px;
        margin-bottom: 16px;
        box-shadow: 0 12px 35px rgba(15,23,42,.06);
    }

    .mobile-step-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        margin-bottom: 12px;
    }

    .mobile-step-title {
        font-weight: 900;
        color: #0f172a;
    }

    .mobile-step-count {
        color: #0b6f73;
        font-weight: 900;
        font-size: 13px;
        background: #edf7f8;
        border-radius: 999px;
        padding: 6px 10px;
    }

    .mobile-step-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .question-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 12px 35px rgba(15,23,42,.05);
    }

    .question-top {
        display: flex;
        gap: 13px;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .question-number {
        width: 38px;
        height: 38px;
        border-radius: 14px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        flex-shrink: 0;
    }

    .question-text {
        flex: 1;
    }

    .question-text strong {
        display: block;
        color: #0f172a;
        font-size: 15px;
        line-height: 1.6;
    }

    .answer-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 10px;
    }

    .answer-option {
        cursor: pointer;
        display: block;
    }

    .answer-option input {
        display: none;
    }

    .answer-box {
        border: 1px solid #cbd5e1;
        border-radius: 16px;
        padding: 13px;
        text-align: center;
        background: #f8fafc;
        transition: .18s;
        min-height: 82px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .answer-label {
        font-size: 14px;
        color: #334155;
        font-weight: 800;
        line-height: 1.35;
    }

    .answer-option input:checked + .answer-box {
        background: #0b6f73;
        border-color: #0b6f73;
        box-shadow: 0 12px 26px rgba(15,118,110,.22);
        transform: translateY(-2px);
    }

    .answer-option input:checked + .answer-box .answer-label {
        color: white;
    }

    .assessment-footer {
        position: sticky;
        bottom: 0;
        background: rgba(238,245,247,.92);
        backdrop-filter: blur(10px);
        border-top: 1px solid #dbeafe;
        padding: 14px 0 0;
        margin-top: 20px;
        z-index: 5;
    }

    .footer-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
        box-shadow: 0 -8px 30px rgba(15,23,42,.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .score-preview {
        font-weight: 800;
        color: #0f172a;
    }

    .score-preview span {
        color: #0b6f73;
        font-size: 20px;
    }

    .incomplete-note {
        margin-top: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
        font-size: 13px;
        display: none;
    }

    .result-preview-box {
        display: none;
        margin-top: 20px;
        border: 2px solid #0b6f73;
        border-radius: 20px;
    }

    .result-preview-box .cards {
        margin-bottom: 18px;
    }

    .dimension-note {
        background: #f8fbfc;
        border: 1px solid #d8e4ea;
        border-radius: 16px;
        padding: 14px 16px;
        color: #425867;
        line-height: 1.6;
        font-size: 14px;
    }

    .dimension-note strong {
        color: #0b6f73;
    }

    @media(max-width: 1000px) {
        .assessment-header,
        .answer-options {
            grid-template-columns: 1fr;
        }

        .patient-summary div {
            display: block;
        }

        .patient-summary strong {
            display: block;
            text-align: left;
            margin-top: 3px;
        }
    }

    @media(max-width: 760px) {
        .assessment-header {
            padding: 20px;
            border-radius: 22px;
        }

        .assessment-header h2 {
            font-size: 24px;
        }

        .assessment-header p {
            font-size: 14px;
        }

        .mobile-step-box {
            display: block;
            position: sticky;
            top: 68px;
            z-index: 4;
        }

        .question-card {
            display: none;
            padding: 18px;
            border-radius: 20px;
            margin-bottom: 14px;
        }

        .question-card.mobile-active-question {
            display: block;
        }

        .question-top {
            flex-direction: column;
            gap: 10px;
        }

        .question-number {
            width: 44px;
            height: 44px;
        }

        .question-text strong {
            font-size: 16px;
        }

        .answer-options {
            gap: 9px;
        }

        .answer-box {
            min-height: 64px;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            gap: 14px;
            text-align: left;
        }

        .assessment-footer {
            padding-top: 10px;
        }

        .footer-card {
            align-items: stretch;
            border-radius: 18px 18px 0 0;
        }

        .score-preview {
            width: 100%;
        }

        .footer-card .actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .footer-card .btn,
        .footer-card button {
            width: 100%;
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }

        .result-preview-box .cards {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $totalQuestions = $questions->count();
    $answerOptions = \App\Support\DeJongGierveldScale::answerOptions();
    $scoreRules = \App\Support\DeJongGierveldScale::scoreRules();
    $scoreCategories = \App\Support\DeJongGierveldScale::scoreCategoryFromClient();
@endphp

<div class="assessment-header">
    <div>
        <h2>Assessment Loneliness</h2>
        <p>
            Isi instrumen berdasarkan respons pasien atau hasil komunikasi dengan pasien.
            Pastikan semua pertanyaan terjawab sebelum submit.
        </p>
    </div>

    <div class="patient-summary">
        <div>
            <span>Kode Pasien</span>
            <strong>{{ $patient->kode_pasien }}</strong>
        </div>
        <div>
            <span>Nama/Inisial</span>
            <strong>{{ $patient->nama_inisial }}</strong>
        </div>
        <div>
            <span>Usia</span>
            <strong>{{ $patient->usia }} tahun</strong>
        </div>
        <div>
            <span>Diagnosis</span>
            <strong>{{ $patient->diagnosis_medis_utama ?: '-' }}</strong>
        </div>
    </div>
</div>

<div class="clinical-note">
    <strong>Petunjuk:</strong>
    Pilih jawaban sesuai kondisi pasien. Sistem menghitung skor De Jong Gierveld secara otomatis:
    item emotional dihitung dari jawaban kadang-kadang sampai selalu, sedangkan item social
    dihitung dari jawaban tidak pernah sampai kadang-kadang.
</div>

@if($questions->count() <= 0)
    <div class="alert-error">
        Belum ada pertanyaan assessment yang aktif. Silakan hubungi admin untuk mengaktifkan instrumen assessment.
    </div>
@else
    <form method="POST" action="{{ route('assessments.store', $patient) }}" id="assessmentForm">
        @csrf

        <div class="assessment-progress">
            <div class="progress-row">
                <span>Progress Pengisian</span>
                <span id="progressText">0 / {{ $totalQuestions }} pertanyaan</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
        </div>

        <div class="mobile-step-box" id="mobileStepBox">
            <div class="mobile-step-top">
                <div class="mobile-step-title">Pertanyaan Assessment</div>
                <div class="mobile-step-count" id="mobileStepCount">1 / {{ $totalQuestions }}</div>
            </div>

            <div class="mobile-step-actions">
                <button type="button" class="btn btn-light" id="mobilePrevBtn" onclick="goToPrevQuestion()">
                    Sebelumnya
                </button>

                <button type="button" class="btn" id="mobileNextBtn" onclick="goToNextQuestion()">
                    Berikutnya
                </button>
            </div>
        </div>

        <div class="panel" style="margin-bottom: 18px;">
            <div class="grid-2">
                <div class="form-group">
                    <label>Tanggal Assessment</label>
                    <input
                        type="date"
                        name="assessment_date"
                        value="{{ old('assessment_date', date('Y-m-d')) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Catatan Perawat</label>
                    <input
                        type="text"
                        name="notes"
                        value="{{ old('notes') }}"
                        placeholder="Opsional: catatan singkat kondisi pasien"
                    >
                </div>
            </div>
        </div>

        <div id="questionList">
            @foreach($questions as $index => $question)
                @php
                    $dimension = \App\Support\DeJongGierveldScale::dimensionForQuestion($question);
                @endphp
                <div
                    class="question-card"
                    id="question-{{ $question->id }}"
                    data-question-index="{{ $index }}"
                    data-question-id="{{ $question->id }}"
                    data-question-order="{{ $question->sort_order }}"
                    data-dimension="{{ $dimension }}"
                >
                    <div class="question-top">
                        <div class="question-number">{{ $index + 1 }}</div>
                        <div class="question-text">
                            <strong>{{ $question->question_text ?? $question->question ?? $question->title ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="answer-options">
                        @foreach($answerOptions as $score => $label)
                            <label class="answer-option">
                                <input
                                    type="radio"
                                    name="answers[{{ $question->id }}]"
                                    value="{{ $score }}"
                                    class="answer-radio"
                                    data-answer-value="{{ $score }}"
                                    data-question="{{ $question->id }}"
                                    data-question-index="{{ $index }}"
                                    {{ (string) old('answers.' . $question->id) === (string) $score ? 'checked' : '' }}
                                    required
                                >
                                <div class="answer-box">
                                    <div class="answer-label">{{ $label }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="panel result-preview-box" id="resultPreviewBox">
            <div class="panel-header">
                <div>
                    <h3>Hasil Assessment</h3>
                    <p>Hasil ini belum tersimpan. Klik Submit Assessment untuk menyimpan hasil resmi.</p>
                </div>
            </div>

            <div class="cards" style="margin-bottom:18px;">
                <div class="card">
                    <div class="label">Total Skor</div>
                    <div class="number" id="resultScorePreview">0</div>
                </div>

                <div class="card">
                    <div class="label">Kategori Loneliness</div>
                    <div class="number" id="resultCategoryPreview" style="font-size:26px;">-</div>
                </div>

                <div class="card">
                    <div class="label">Emotional Loneliness</div>
                    <div class="number" id="emotionalScorePreview">0</div>
                </div>

                <div class="card">
                    <div class="label">Social Loneliness</div>
                    <div class="number" id="socialScorePreview">0</div>
                </div>
            </div>

            <div class="dimension-note" style="margin-bottom:16px;">
                Kategori lain yang lebih tinggi:
                <strong id="dominantDimensionPreview">-</strong>
            </div>

            <div class="clinical-note">
                <strong>Interpretasi Awal:</strong>
                <div id="interpretationPreview" style="margin-top:8px;">-</div>
            </div>

            <div class="alert-success" style="margin-top:16px;">
                Jika hasil sudah sesuai, klik <strong>Submit Assessment</strong> untuk menyimpan
                dan menampilkan rekomendasi keperawatan serta edukasi keluarga.
            </div>
        </div>

        <div class="incomplete-note" id="incompleteNote">
            Masih ada pertanyaan yang belum diisi. Lengkapi semua pertanyaan sebelum submit assessment.
        </div>

        <div class="assessment-footer">
            <div class="footer-card">
                <div class="score-preview">
                    <div>
                        Total Skor:
                        <span id="scorePreview">0</span>
                    </div>

                    <div style="margin-top:6px;">
                        Kategori:
                        <strong id="categoryPreview" style="color:#0b6f73;">-</strong>
                    </div>

                    <div style="margin-top:6px;">
                        Kategori lain:
                        <strong id="dominantDimensionFooter" style="color:#0b6f73;">-</strong>
                    </div>
                </div>

                <div class="actions">
                    <button type="button" class="btn btn-light" onclick="resetAnswers()">
                        Reset Jawaban
                    </button>

                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn" id="submitAssessmentBtn" disabled>
                        Submit Assessment
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        const totalQuestions = {{ $totalQuestions }};
        const scoreRules = @json($scoreRules);
        const scoreCategories = @json($scoreCategories);
        let activeQuestionIndex = 0;

        function isMobileView() {
            return window.innerWidth <= 760;
        }

        function getQuestionCards() {
            return Array.from(document.querySelectorAll('.question-card'));
        }

        function showActiveQuestion(index) {
            const cards = getQuestionCards();

            if (!cards.length) {
                return;
            }

            if (index < 0) {
                index = 0;
            }

            if (index >= cards.length) {
                index = cards.length - 1;
            }

            activeQuestionIndex = index;

            cards.forEach(function(card, cardIndex) {
                card.classList.toggle('mobile-active-question', cardIndex === activeQuestionIndex);
            });

            const mobileStepCount = document.getElementById('mobileStepCount');
            const prevBtn = document.getElementById('mobilePrevBtn');
            const nextBtn = document.getElementById('mobileNextBtn');

            if (mobileStepCount) {
                mobileStepCount.innerText = (activeQuestionIndex + 1) + ' / ' + totalQuestions;
            }

            if (prevBtn) {
                prevBtn.disabled = activeQuestionIndex === 0;
                prevBtn.style.opacity = activeQuestionIndex === 0 ? '0.55' : '1';
            }

            if (nextBtn) {
                if (activeQuestionIndex >= totalQuestions - 1) {
                    nextBtn.innerText = 'Lihat Hasil';
                } else {
                    nextBtn.innerText = 'Berikutnya';
                }
            }

            if (isMobileView()) {
                const activeCard = cards[activeQuestionIndex];
                if (activeCard) {
                    activeCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }

        function goToPrevQuestion() {
            showActiveQuestion(activeQuestionIndex - 1);
        }

        function goToNextQuestion() {
            if (activeQuestionIndex >= totalQuestions - 1) {
                const resultBox = document.getElementById('resultPreviewBox');

                if (resultBox && resultBox.style.display !== 'none') {
                    resultBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    return;
                }
            }

            showActiveQuestion(activeQuestionIndex + 1);
        }

        function findFirstUnansweredIndex() {
            const cards = getQuestionCards();

            for (let i = 0; i < cards.length; i++) {
                const questionId = cards[i].dataset.questionId;
                const checked = document.querySelector('input[name="answers[' + questionId + ']"]:checked');

                if (!checked) {
                    return i;
                }
            }

            return 0;
        }

        function updateAssessmentProgress() {
            const checkedAnswers = document.querySelectorAll('.answer-radio:checked');
            const progressText = document.getElementById('progressText');
            const progressFill = document.getElementById('progressFill');
            const scorePreview = document.getElementById('scorePreview');

            let totalScore = 0;
            const dimensionScores = {
                emotional: 0,
                social: 0,
            };

            checkedAnswers.forEach(function(answer) {
                const answerValue = parseInt(answer.dataset.answerValue || answer.value || 0);
                const questionCard = answer.closest('.question-card');
                const dimension = questionCard ? questionCard.dataset.dimension : 'emotional';
                const itemNumber = questionCard ? parseInt(questionCard.dataset.questionOrder || 0) : 0;
                const score = scoreAnswer(itemNumber, answerValue);

                totalScore += score;

                if (dimension === 'social') {
                    dimensionScores.social += score;
                } else {
                    dimensionScores.emotional += score;
                }
            });

            const answered = checkedAnswers.length;
            const percent = totalQuestions > 0 ? (answered / totalQuestions) * 100 : 0;

            progressText.innerText = answered + ' / ' + totalQuestions + ' pertanyaan';
            progressFill.style.width = percent + '%';
            scorePreview.innerText = totalScore;

            const categoryPreview = document.getElementById('categoryPreview');
            const resultPreviewBox = document.getElementById('resultPreviewBox');
            const resultScorePreview = document.getElementById('resultScorePreview');
            const resultCategoryPreview = document.getElementById('resultCategoryPreview');
            const interpretationPreview = document.getElementById('interpretationPreview');
            const submitBtn = document.getElementById('submitAssessmentBtn');
            const emotionalScorePreview = document.getElementById('emotionalScorePreview');
            const socialScorePreview = document.getElementById('socialScorePreview');
            const dominantDimensionPreview = document.getElementById('dominantDimensionPreview');
            const dominantDimensionFooter = document.getElementById('dominantDimensionFooter');

            let category = '-';
            let interpretation = '-';
            let dominantDimension = '-';

            if (dimensionScores.emotional > dimensionScores.social) {
                dominantDimension = 'Emotional Loneliness';
            } else if (dimensionScores.social > dimensionScores.emotional) {
                dominantDimension = 'Social Loneliness';
            } else if (answered > 0) {
                dominantDimension = 'Emotional dan Social seimbang';
            }

            if (emotionalScorePreview) {
                emotionalScorePreview.innerText = dimensionScores.emotional;
            }

            if (socialScorePreview) {
                socialScorePreview.innerText = dimensionScores.social;
            }

            if (dominantDimensionPreview) {
                dominantDimensionPreview.innerText = dominantDimension;
            }

            if (dominantDimensionFooter) {
                dominantDimensionFooter.innerText = dominantDimension;
            }

            if (answered === totalQuestions) {
                const matchedCategory = findScoreCategory(totalScore);

                category = matchedCategory ? matchedCategory.category : '-';
                interpretation = matchedCategory ? matchedCategory.interpretation : '-';

                categoryPreview.innerText = category;
                resultScorePreview.innerText = totalScore;
                resultCategoryPreview.innerText = category;
                interpretationPreview.innerText = interpretation;

                resultPreviewBox.style.display = 'block';

                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                categoryPreview.innerText = '-';
                if (dominantDimensionFooter) {
                    dominantDimensionFooter.innerText = '-';
                }
                resultPreviewBox.style.display = 'none';

                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
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

        function findScoreCategory(totalScore) {
            return scoreCategories.find(function(item) {
                return totalScore >= item.min_score && totalScore <= item.max_score;
            });
        }

        function resetAnswers() {
            showAppConfirm('Reset semua jawaban assessment?', function() {
                document.querySelectorAll('.answer-radio').forEach(function(answer) {
                    answer.checked = false;
                });

                updateAssessmentProgress();
                showActiveQuestion(0);
            }, {
                title: 'Reset jawaban?',
                confirmText: 'Ya, reset'
            });
        }

        document.querySelectorAll('.answer-radio').forEach(function(answer) {
            answer.addEventListener('change', function() {
                updateAssessmentProgress();

                if (isMobileView()) {
                    const selectedIndex = parseInt(answer.dataset.questionIndex || 0);

                    if (selectedIndex < totalQuestions - 1) {
                        setTimeout(function() {
                            showActiveQuestion(selectedIndex + 1);
                        }, 220);
                    }
                }
            });
        });

        document.getElementById('assessmentForm').addEventListener('submit', function(event) {
            const answered = document.querySelectorAll('.answer-radio:checked').length;
            const note = document.getElementById('incompleteNote');

            if (answered < totalQuestions) {
                event.preventDefault();

                const firstUnanswered = findFirstUnansweredIndex();

                if (isMobileView()) {
                    showActiveQuestion(firstUnanswered);
                }

                note.style.display = 'block';
                note.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        window.addEventListener('resize', function() {
            showActiveQuestion(activeQuestionIndex);
        });

        document.addEventListener('DOMContentLoaded', function() {
            activeQuestionIndex = findFirstUnansweredIndex();
            showActiveQuestion(activeQuestionIndex);
            updateAssessmentProgress();
        });

        showActiveQuestion(findFirstUnansweredIndex());
        updateAssessmentProgress();
    </script>
@endif
@endsection
