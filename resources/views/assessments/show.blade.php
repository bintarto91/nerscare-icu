@extends('layouts.app')

@section('title', 'Hasil AI-Assisted Assessment')
@section('page_title', 'Hasil AI-Assisted Assessment')
@section('page_subtitle', 'Hasil penilaian loneliness pasien ICU dan rekomendasi edukasi.')

@section('content')
@php
    $totalScore = $assessment->total_score ?? 0;
    $answerCount = $assessment->answers->count();
    $maxScore = max($answerCount, 1);
    $scorePercentage = min(100, round(($totalScore / $maxScore) * 100));

    $assessmentDate = $assessment->assessment_date
        ? \Carbon\Carbon::parse($assessment->assessment_date)->format('d/m/Y')
        : '-';

    $assessmentDateFull = $assessment->assessment_date
        ? \Carbon\Carbon::parse($assessment->assessment_date)->translatedFormat('d F Y')
        : '-';

    $category = $assessment->category ?? '-';
    $categoryLower = strtolower($category);

    if (str_contains($categoryLower, 'not') || str_contains($categoryLower, 'tidak') || str_contains($categoryLower, 'rendah')) {
        $categoryClass = 'result-low';
        $categoryIcon = '✅';
        $categoryLabel = str_contains($categoryLower, 'not') ? 'Not lonely' : 'Risiko Rendah';
        $categoryMessage = str_contains($categoryLower, 'not')
            ? 'Total skor berada pada kategori not lonely berdasarkan De Jong Gierveld Loneliness Scale.'
            : 'Kondisi loneliness relatif rendah. Tetap lakukan komunikasi terapeutik dan observasi berkala.';
    } elseif (str_contains($categoryLower, 'moderate') || str_contains($categoryLower, 'sedang')) {
        $categoryClass = 'result-medium';
        $categoryIcon = '⚠️';
        $categoryLabel = str_contains($categoryLower, 'moderate') ? 'Moderate lonely' : 'Risiko Sedang';
        $categoryMessage = str_contains($categoryLower, 'moderate')
            ? 'Total skor berada pada kategori moderate lonely dan perlu dukungan emosional maupun sosial.'
            : 'Perlu perhatian lanjutan melalui dukungan emosional, komunikasi terstruktur, dan edukasi keluarga.';
    } elseif (str_contains($categoryLower, 'severe') || str_contains($categoryLower, 'tinggi')) {
        $categoryClass = 'result-high';
        $categoryIcon = '🚨';
        $categoryLabel = str_contains($categoryLower, 'very severe')
            ? 'Very severe lonely'
            : (str_contains($categoryLower, 'severe') ? 'Severe lonely' : 'Risiko Tinggi');
        $categoryMessage = str_contains($categoryLower, 'very severe')
            ? 'Total skor berada pada kategori very severe lonely dan perlu menjadi prioritas tindak lanjut.'
            : (str_contains($categoryLower, 'severe')
                ? 'Total skor berada pada kategori severe lonely dan membutuhkan tindak lanjut dukungan lebih intensif.'
                : 'Pasien perlu menjadi prioritas tindak lanjut, observasi lebih intensif, dan dukungan keluarga/perawat.');
    } else {
        $categoryClass = 'result-default';
        $categoryIcon = 'ℹ️';
        $categoryLabel = 'Belum Dikategorikan';
        $categoryMessage = 'Kategori belum tersedia. Pastikan assessment sudah dihitung dan tersimpan dengan benar.';
    }

    $perawatName = $assessment->patient->nama_perawat_pengisi
        ?? optional($assessment->user)->name
        ?? '-';

    $followUpStatus = $assessment->follow_up_status ?? null;

    $followUpClass = 'follow-default';
    if ($followUpStatus) {
        $followLower = strtolower($followUpStatus);
        if (str_contains($followLower, 'selesai') || str_contains($followLower, 'sudah')) {
            $followUpClass = 'follow-done';
        } elseif (str_contains($followLower, 'proses') || str_contains($followLower, 'lanjut')) {
            $followUpClass = 'follow-process';
        } else {
            $followUpClass = 'follow-waiting';
        }
    }

    $dimensionScores = [
        'emotional' => 0,
        'social' => 0,
    ];

    foreach ($assessment->answers as $answer) {
        $question = $answer->question;
        $dimension = \App\Support\DeJongGierveldScale::dimensionForQuestion($question);

        $dimensionScores[$dimension] += (int) ($answer->score ?? 0);
    }

    $dominantDimension = \App\Support\DeJongGierveldScale::dominantDimensionLabel($dimensionScores);
@endphp

<style>
    .result-header {
        background: linear-gradient(135deg, #0b6f73 0%, #0f766e 45%, #2563a9 100%);
        color: white;
        border-radius: 28px;
        padding: 30px;
        margin-bottom: 22px;
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(300px, .85fr);
        gap: 22px;
        align-items: center;
        box-shadow: 0 22px 58px rgba(15, 118, 110, .20);
        position: relative;
        overflow: hidden;
    }

    .result-header::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        right: -80px;
        top: -90px;
    }

    .result-header::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .07);
        left: 40%;
        bottom: -100px;
    }

    .result-header > div {
        position: relative;
        z-index: 1;
    }

    .result-header h2 {
        margin: 0 0 8px;
        font-size: 30px;
        color: white;
        line-height: 1.2;
    }

    .result-header p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.7;
        max-width: 720px;
    }

    .result-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .24);
        color: white;
        border-radius: 999px;
        padding: 8px 13px;
        font-weight: 900;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .patient-result-box {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 22px;
        padding: 18px;
        display: grid;
        gap: 10px;
        font-size: 14px;
        backdrop-filter: blur(8px);
    }

    .patient-result-box div {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, .14);
    }

    .patient-result-box div:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .patient-result-box span {
        color: #d9fffb;
    }

    .patient-result-box strong {
        color: white;
        text-align: right;
    }

    .result-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .result-actions .actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .result-summary-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 22px;
        margin-bottom: 22px;
    }

    .score-visual-card {
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 26px;
        padding: 26px;
        box-shadow: 0 18px 46px rgba(8, 47, 73, .08);
        position: relative;
        overflow: hidden;
    }

    .score-visual-card::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 999px;
        background: rgba(11, 111, 115, .08);
        right: -75px;
        top: -75px;
    }

    .score-main {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 22px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .score-circle {
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background:
            radial-gradient(circle at center, white 55%, transparent 56%),
            conic-gradient(#0b6f73 {{ $scorePercentage }}%, #e2e8f0 0);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 0 1px #e2e8f0;
    }

    .score-circle-inner {
        text-align: center;
    }

    .score-circle-inner strong {
        display: block;
        font-size: 36px;
        color: #0b6f73;
        line-height: 1;
    }

    .score-circle-inner span {
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
    }

    .score-info h3 {
        margin: 0 0 8px;
        font-size: 22px;
        color: #10212b;
    }

    .score-info p {
        margin: 0;
        color: #5f7180;
        line-height: 1.7;
        font-size: 14px;
    }

    .score-progress {
        margin-top: 18px;
    }

    .score-progress-bar {
        height: 12px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .score-progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #0b6f73, #2563a9);
        width: {{ $scorePercentage }}%;
    }

    .score-meta {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
    }

    .category-visual-card {
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 26px;
        padding: 26px;
        box-shadow: 0 18px 46px rgba(8, 47, 73, .08);
    }

    .category-icon {
        width: 58px;
        height: 58px;
        border-radius: 20px;
        background: #edf7f8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 14px;
    }

    .category-visual-card h3 {
        margin: 0;
        font-size: 21px;
        color: #10212b;
    }

    .category-visual-card p {
        color: #5f7180;
        line-height: 1.7;
        font-size: 14px;
        margin: 12px 0 0;
    }

    .category-result {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 14px;
        border-radius: 999px;
        font-weight: 900;
        font-size: 16px;
        margin-top: 14px;
    }

    .dimension-visual-card {
        grid-column: 1 / -1;
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 26px;
        padding: 24px;
        box-shadow: 0 18px 46px rgba(8, 47, 73, .08);
    }

    .dimension-title {
        margin-bottom: 16px;
    }

    .dimension-title h3 {
        margin: 0 0 6px;
        color: #10212b;
        font-size: 21px;
    }

    .dimension-title p {
        margin: 0;
        color: #64748b;
        line-height: 1.6;
        font-size: 14px;
    }

    .dimension-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .dimension-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 16px;
    }

    .dimension-pill span {
        display: block;
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .dimension-pill strong {
        display: block;
        color: #0b6f73;
        font-size: 28px;
        line-height: 1.15;
    }

    .dimension-pill.dimension-dominant strong {
        font-size: 20px;
        color: #10212b;
    }

    .result-low {
        background: #dcfce7;
        color: #166534;
    }

    .result-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .result-high {
        background: #fee2e2;
        color: #991b1b;
    }

    .result-default {
        background: #e2e8f0;
        color: #334155;
    }

    .result-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .result-stat-card {
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 22px;
        padding: 20px;
        box-shadow: 0 14px 36px rgba(8, 47, 73, .07);
        position: relative;
        overflow: hidden;
    }

    .result-stat-card::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        border-radius: 999px;
        background: rgba(11, 111, 115, .07);
        right: -36px;
        top: -36px;
    }

    .result-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }

    .result-stat-card .label,
    .result-stat-card .number,
    .result-stat-card .stat-sub {
        position: relative;
        z-index: 1;
    }

    .result-stat-card .number {
        font-size: 28px;
        font-weight: 900;
        color: #10212b;
        line-height: 1.2;
    }

    .stat-sub {
        color: #7a8b97;
        font-size: 12px;
        margin-top: 6px;
        line-height: 1.5;
    }

    .follow-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 900;
    }

    .follow-default,
    .follow-waiting {
        background: #fff7ed;
        color: #c2410c;
    }

    .follow-process {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .follow-done {
        background: #dcfce7;
        color: #166534;
    }

    .result-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        margin-bottom: 22px;
    }

    .result-section {
        margin-bottom: 18px;
        padding: 20px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        position: relative;
        overflow: hidden;
    }

    .result-section::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: #0b6f73;
    }

    .result-section h3 {
        margin: 0 0 10px;
        color: #0b6f73;
        font-size: 17px;
    }

    .result-section p {
        margin: 0;
        color: #334155;
        line-height: 1.75;
        font-size: 14px;
    }

    .clinical-warning {
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
        border-radius: 20px;
        padding: 18px;
        line-height: 1.7;
        font-size: 14px;
        margin-top: 18px;
    }

    .answer-score {
        font-weight: 900;
        color: #0b6f73;
        font-size: 16px;
    }

    .answer-label {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 999px;
        background: #edf7f8;
        color: #0b6f73;
        font-weight: 800;
        font-size: 12px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .print-only {
        display: none;
    }

    @media(max-width: 1100px) {
        .result-header,
        .result-summary-grid,
        .dimension-grid,
        .result-grid {
            grid-template-columns: 1fr;
        }

        .result-stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 760px) {
        .result-header {
            padding: 22px;
            border-radius: 22px;
        }

        .result-header h2 {
            font-size: 24px;
        }

        .patient-result-box div {
            display: block;
        }

        .patient-result-box strong {
            display: block;
            text-align: left;
            margin-top: 3px;
        }

        .result-actions .actions {
            flex-direction: column;
            width: 100%;
        }

        .result-actions .btn {
            width: 100%;
            text-align: center;
            justify-content: center;
        }

        .score-main {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .score-circle {
            margin: 0 auto;
            width: 135px;
            height: 135px;
        }

        .result-stat-grid {
            grid-template-columns: 1fr;
        }

        .panel {
            padding: 18px;
            border-radius: 20px;
        }

        .panel-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .table-responsive table,
        .table-responsive thead,
        .table-responsive tbody,
        .table-responsive th,
        .table-responsive td,
        .table-responsive tr {
            display: block;
            width: 100%;
        }

        .table-responsive thead {
            display: none;
        }

        .table-responsive tr {
            background: #ffffff;
            border: 1px solid #d8e4ea;
            border-radius: 18px;
            padding: 14px;
            margin-bottom: 14px;
            box-shadow: 0 10px 28px rgba(8, 47, 73, .06);
        }

        .table-responsive td {
            border: none !important;
            padding: 9px 0 !important;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            text-align: right;
        }

        .table-responsive td::before {
            content: attr(data-label);
            font-weight: 900;
            color: #334653;
            text-align: left;
            min-width: 90px;
        }
    }

    @media print {
        body {
            background: white !important;
        }

        .sidebar,
        .topbar,
        .result-actions,
        .btn,
        form,
        .no-print {
            display: none !important;
        }

        .main {
            margin-left: 0 !important;
        }

        .content {
            padding: 0 !important;
        }

        .panel,
        .card,
        .result-header,
        .score-visual-card,
        .category-visual-card,
        .dimension-visual-card,
        .result-stat-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .result-header {
            color: #0f172a !important;
            background: white !important;
        }

        .result-header p,
        .patient-result-box span {
            color: #334155 !important;
        }

        .patient-result-box {
            background: white !important;
            border: 1px solid #ddd !important;
        }

        .print-only {
            display: block;
        }
    }
</style>

<div class="print-only" style="margin-bottom: 18px;">
    <h2>Hasil AI-Assisted Assessment ICU</h2>
    <p>Penilaian Loneliness Pasien ICU dan Rekomendasi Edukasi</p>
</div>

<div class="result-header">
    <div>
        <div class="result-status-badge">
            {{ $categoryIcon }} {{ $categoryLabel }}
        </div>

        <h2>{{ $assessment->patient->nama_inisial }}</h2>

        <p>
            Hasil assessment loneliness pasien ICU. Data ini digunakan sebagai alat bantu
            dokumentasi, interpretasi awal, dan dasar edukasi perawat-keluarga.
        </p>
    </div>

    <div class="patient-result-box">
        <div>
            <span>Kode Pasien</span>
            <strong>{{ $assessment->patient->kode_pasien }}</strong>
        </div>

        <div>
            <span>Tanggal Assessment</span>
            <strong>{{ $assessmentDate }}</strong>
        </div>

        <div>
            <span>Perawat Pengisi</span>
            <strong>{{ $perawatName }}</strong>
        </div>

        <div>
            <span>Jumlah Pertanyaan</span>
            <strong>{{ $answerCount }}</strong>
        </div>
    </div>
</div>

<div class="result-actions no-print">
    <div class="actions">
        <a class="btn" href="{{ route('assessments.print', $assessment) }}" target="_blank">
            🖨️ Cetak / Unduh PDF
        </a>

        <a class="btn btn-secondary" href="{{ route('assessments.index') }}">
            📋 Riwayat
        </a>

        <a class="btn btn-light" href="{{ route('patients.show', $assessment->patient) }}">
            👤 Detail Pasien
        </a>

        <a class="btn btn-warning" href="{{ route('assessments.create', $assessment->patient) }}">
            🔁 Assessment Ulang
        </a>

        <a class="btn btn-light" href="{{ route('assessments.follow_up.edit', $assessment) }}">
            ✅ Update Tindak Lanjut
        </a>
    </div>
</div>

<div class="result-summary-grid">
    <div class="score-visual-card">
        <div class="score-main">
            <div class="score-circle">
                <div class="score-circle-inner">
                    <strong>{{ $totalScore }}</strong>
                    <span>dari {{ $maxScore }}</span>
                </div>
            </div>

            <div class="score-info">
                <h3>Total Skor Loneliness</h3>
                <p>
                    Skor ini dihitung berdasarkan jawaban assessment pasien.
                    Semakin tinggi skor, semakin besar indikasi kebutuhan dukungan emosional
                    dan tindak lanjut keperawatan.
                </p>

                <div class="score-progress">
                    <div class="score-progress-bar">
                        <div class="score-progress-fill"></div>
                    </div>

                    <div class="score-meta">
                        <span>0%</span>
                        <span>{{ $scorePercentage }}%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="category-visual-card">
        <div class="category-icon">{{ $categoryIcon }}</div>

        <h3>{{ $categoryLabel }}</h3>

        <span class="category-result {{ $categoryClass }}">
            {{ $category }}
        </span>

        <p>{{ $categoryMessage }}</p>
    </div>

    <div class="dimension-visual-card">
        <div class="dimension-title">
            <h3>Kategori Lain</h3>
            <p>Perbandingan skor emotional loneliness dan social loneliness dari jawaban pasien.</p>
        </div>

        <div class="dimension-grid">
            <div class="dimension-pill">
                <span>Emotional Loneliness</span>
                <strong>{{ $dimensionScores['emotional'] }}</strong>
            </div>

            <div class="dimension-pill">
                <span>Social Loneliness</span>
                <strong>{{ $dimensionScores['social'] }}</strong>
            </div>

            <div class="dimension-pill dimension-dominant">
                <span>Lebih Tinggi</span>
                <strong>{{ $dominantDimension }}</strong>
            </div>
        </div>
    </div>
</div>

<div class="result-stat-grid">
    <div class="result-stat-card">
        <div class="result-stat-icon">📝</div>
        <div class="label">Total Skor</div>
        <div class="number">{{ $totalScore }}</div>
        <div class="stat-sub">Akumulasi skor seluruh jawaban</div>
    </div>

    <div class="result-stat-card">
        <div class="result-stat-icon">❓</div>
        <div class="label">Jumlah Pertanyaan</div>
        <div class="number">{{ $answerCount }}</div>
        <div class="stat-sub">Item assessment yang dijawab</div>
    </div>

    <div class="result-stat-card">
        <div class="result-stat-icon">📅</div>
        <div class="label">Tanggal Assessment</div>
        <div class="number" style="font-size: 20px;">{{ $assessmentDate }}</div>
        <div class="stat-sub">{{ $assessmentDateFull }}</div>
    </div>

    <div class="result-stat-card">
        <div class="result-stat-icon">✅</div>
        <div class="label">Status Tindak Lanjut</div>
        <div style="margin-top: 12px;">
            @if($followUpStatus)
                <span class="follow-badge {{ $followUpClass }}">
                    {{ $followUpStatus }}
                </span>
            @else
                <span class="follow-badge follow-waiting">
                    Belum Ditindaklanjuti
                </span>
            @endif
        </div>
        <div class="stat-sub">Status tindak lanjut perawat</div>
    </div>
</div>

<div class="panel" style="margin-bottom: 22px;">
    <div class="panel-header">
        <div>
            <h3>Interpretasi & Rekomendasi</h3>
            <p>Hasil awal dari sistem berdasarkan total skor assessment.</p>
        </div>
    </div>

    <div class="result-grid">
        <div>
            <div class="result-section">
                <h3>Interpretasi Awal</h3>
                <p>{{ $assessment->interpretation ?: 'Belum ada interpretasi.' }}</p>
            </div>

            <div class="result-section">
                <h3>Rekomendasi Dukungan Keperawatan</h3>
                <p>{{ $assessment->nursing_recommendation ?: 'Belum ada rekomendasi dukungan keperawatan.' }}</p>
            </div>
        </div>

        <div>
            <div class="result-section">
                <h3>Rekomendasi Edukasi Keluarga</h3>
                <p>{{ $assessment->family_education_recommendation ?: 'Belum ada rekomendasi edukasi keluarga.' }}</p>
            </div>

            @if($assessment->notes)
                <div class="result-section">
                    <h3>Catatan Perawat</h3>
                    <p>{{ $assessment->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="clinical-warning">
        <strong>Catatan Klinis:</strong>
        Hasil AI-Assisted Assessment ini merupakan alat bantu penilaian dan tidak menggantikan
        clinical judgement perawat. Interpretasi perlu disesuaikan dengan kondisi klinis pasien,
        kemampuan komunikasi pasien, observasi perawat, serta kebijakan ruang ICU.
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Detail Jawaban Assessment</h3>
            <p>Rincian jawaban pasien untuk setiap pertanyaan assessment loneliness.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Pertanyaan</th>
                    <th width="170">Jawaban</th>
                    <th width="90">Skor Item</th>
                </tr>
            </thead>

            <tbody>
                @forelse($assessment->answers as $answer)
                    <tr>
                        <td data-label="No">{{ $loop->iteration }}</td>

                        <td data-label="Pertanyaan">
                            {{ $answer->question->question_text ?? $answer->question->question ?? '-' }}
                        </td>

                        <td data-label="Jawaban">
                            <span class="answer-label">{{ $answer->answer_text }}</span>
                        </td>

                        <td data-label="Skor Item">
                            <span class="answer-score">{{ $answer->score }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                Belum ada detail jawaban assessment.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
