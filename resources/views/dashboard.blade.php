@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan AI-Assisted Assessment loneliness pasien ICU.')

@section('content')
@php
    $role = auth()->user()->role ?? '-';

    $totalUsers = $totalUsers ?? 0;
    $totalPatients = $totalPatients ?? 0;
    $totalAssessments = $totalAssessments ?? 0;
    $totalQuestions = $totalQuestions ?? 0;
    $totalEducation = $totalEducation ?? 0;

    $categoryCollection = collect($categoryCounts ?? []);
    $maxCategory = $categoryCollection->max() ?: 1;

    $topCategoryName = '-';
    $topCategoryTotal = 0;

    if ($categoryCollection->count() > 0) {
        $topCategoryName = $categoryCollection->sortDesc()->keys()->first() ?: 'Belum Dikategorikan';
        $topCategoryTotal = $categoryCollection->sortDesc()->first() ?: 0;
    }

    $latestAssessmentTotal = collect($latestAssessments ?? [])->count();

    $riskHighTotal = 0;
    $riskMediumTotal = 0;
    $riskLowTotal = 0;

    foreach ($categoryCollection as $category => $total) {
        $categoryLower = strtolower($category ?? '');

        if (str_contains($categoryLower, 'severe') || str_contains($categoryLower, 'tinggi')) {
            $riskHighTotal += $total;
        } elseif (str_contains($categoryLower, 'moderate') || str_contains($categoryLower, 'sedang')) {
            $riskMediumTotal += $total;
        } elseif (str_contains($categoryLower, 'not') || str_contains($categoryLower, 'rendah')) {
            $riskLowTotal += $total;
        }
    }
@endphp

<style>
    .dashboard-hero {
        background: linear-gradient(135deg, #0b6f73 0%, #084e55 100%);
        color: white;
        border-radius: 28px;
        padding: 34px;
        margin-bottom: 18px;
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(300px, .8fr);
        gap: 24px;
        align-items: center;
        box-shadow: 0 22px 58px rgba(8, 47, 73, .18);
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        right: -90px;
        top: -90px;
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .06);
        right: 120px;
        bottom: -100px;
    }

    .dashboard-hero > div {
        position: relative;
        z-index: 1;
    }

    .dashboard-hero h2 {
        margin: 0 0 10px;
        color: white;
        font-size: 32px;
        line-height: 1.18;
    }

    .dashboard-hero p {
        margin: 0;
        max-width: 720px;
        color: #e9fffd;
        font-size: 15px;
        line-height: 1.75;
    }

    .hero-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .hero-actions .btn-light {
        background: white;
        color: #0b6f73;
        border-color: white;
    }

    .hero-note {
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .20);
        border-radius: 20px;
        padding: 20px;
        backdrop-filter: blur(8px);
    }

    .hero-note strong {
        display: block;
        color: white;
        font-size: 16px;
        margin-bottom: 8px;
    }

    .hero-note span {
        display: block;
        color: #d8fffb;
        font-size: 13px;
        line-height: 1.65;
    }

    .stat-card {
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 24px;
        box-shadow: 0 18px 46px rgba(8, 47, 73, .08);
        position: relative;
        overflow: hidden;
        min-height: 220px;
        padding: 28px;
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 22px 54px rgba(8, 47, 73, .12);
    }

    .stat-card::after {
        content: "";
        position: absolute;
        width: 110px;
        height: 110px;
        border-radius: 999px;
        background: #e6f7f6;
        right: -36px;
        bottom: -40px;
        opacity: .8;
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: #e6f7f6;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .stat-icon .ui-icon {
        width: 24px;
        height: 24px;
        stroke-width: 2.15;
    }

    .stat-card .label,
    .stat-card .number,
    .stat-card .stat-sub {
        position: relative;
        z-index: 1;
    }

    .stat-sub {
        color: #7a8b97;
        font-size: 12px;
        margin-top: 6px;
    }

    .insight-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin: 22px 0;
    }

    .insight-card {
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 22px;
        padding: 22px;
        box-shadow: 0 14px 36px rgba(8, 47, 73, .07);
        position: relative;
        overflow: hidden;
    }

    .insight-card::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        border-radius: 999px;
        right: -34px;
        top: -34px;
        background: rgba(11, 111, 115, .08);
    }

    .insight-label {
        color: #5f7180;
        font-size: 13px;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .insight-value {
        color: #10212b;
        font-size: 24px;
        font-weight: 900;
        line-height: 1.25;
        position: relative;
        z-index: 1;
    }

    .insight-note {
        color: #7a8b97;
        font-size: 12px;
        margin-top: 8px;
        line-height: 1.5;
        position: relative;
        z-index: 1;
    }

    .risk-card {
        background: linear-gradient(135deg, #fff7ed 0%, #fff1f2 100%);
        border-color: #fed7aa;
    }

    .risk-card::after {
        background: rgba(251, 113, 133, .16);
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .panel-header p {
        margin: 4px 0 0;
        color: #5f7180;
        font-size: 13px;
    }

    .category-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }

    .category-summary-card {
        border-radius: 16px;
        padding: 14px;
        background: #f8fbfc;
        border: 1px solid #d8e4ea;
    }

    .category-summary-card strong {
        display: block;
        font-size: 22px;
        color: #10212b;
        line-height: 1.1;
    }

    .category-summary-card span {
        display: block;
        font-size: 12px;
        color: #5f7180;
        margin-top: 5px;
    }

    .category-summary-card.low {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .category-summary-card.medium {
        background: #fff7ed;
        border-color: #fed7aa;
    }

    .category-summary-card.high {
        background: #fff1f2;
        border-color: #fecdd3;
    }

    .category-item {
        margin-bottom: 14px;
    }

    .category-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .category-name {
        color: #334653;
        font-weight: 800;
    }

    .category-total {
        color: #0b6f73;
        font-weight: 900;
    }

    .bar {
        height: 10px;
        background: #e5eef2;
        border-radius: 999px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #0b6f73, #14b8a6);
        border-radius: 999px;
    }

    .empty-state {
        text-align: center;
        padding: 24px;
        color: #5f7180;
        background: #f8fbfc;
        border: 1px dashed #c7d6de;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.6;
    }

    .patient-mini {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #d8e4ea;
    }

    .patient-mini:last-child {
        border-bottom: none;
    }

    .patient-name {
        color: #10212b;
        font-weight: 900;
        margin-bottom: 4px;
    }

    .patient-meta {
        color: #5f7180;
        font-size: 13px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .assessment-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 900;
        background: #e6f7f6;
        color: #0b6f73;
        white-space: nowrap;
    }

    .assessment-badge.high {
        background: #ffe4e6;
        color: #be123c;
    }

    .assessment-badge.medium {
        background: #fff7ed;
        color: #c2410c;
    }

    .assessment-badge.low {
        background: #dcfce7;
        color: #15803d;
    }

    .score-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
        border-radius: 999px;
        padding: 6px 10px;
        background: #eef6f8;
        color: #0b6f73;
        font-weight: 900;
    }

    .quick-note {
        margin-top: 22px;
        border-radius: 22px;
        padding: 20px;
        background: linear-gradient(135deg, #ecfeff 0%, #f0fdfa 100%);
        border: 1px solid #ccfbf1;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .quick-note-icon {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        box-shadow: 0 10px 24px rgba(8, 47, 73, .08);
    }

    .quick-note-icon .ui-icon {
        width: 21px;
        height: 21px;
        stroke-width: 2.2;
    }

    .quick-note strong {
        display: block;
        color: #0f766e;
        margin-bottom: 4px;
    }

    .quick-note span {
        display: block;
        color: #335c67;
        font-size: 13px;
        line-height: 1.6;
    }

    @media(max-width: 1100px) {
        .dashboard-hero,
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .insight-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 900px) {
        .cards {
            grid-template-columns: 1fr !important;
        }

        .stat-card {
            min-height: auto;
        }

        .category-summary {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 760px) {
        .dashboard-hero {
            padding: 22px;
            border-radius: 22px;
        }

        .dashboard-hero h2 {
            font-size: 24px;
        }

        .hero-actions {
            flex-direction: column;
        }

        .hero-actions .btn {
            width: 100%;
            text-align: center;
            justify-content: center;
        }

        .panel {
            padding: 18px;
            border-radius: 20px;
        }

        .panel-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .patient-mini {
            align-items: flex-start;
            flex-direction: column;
        }

        .patient-mini .btn {
            width: 100%;
            text-align: center;
        }

        .quick-note {
            flex-direction: column;
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
        }

        .table-responsive td:last-child {
            justify-content: flex-start;
            text-align: left;
        }

        .table-responsive td:last-child::before {
            display: none;
        }

        .table-responsive td:last-child .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="dashboard-hero">
    <div>
        <h2>Selamat datang, {{ auth()->user()->name }}</h2>
        <p>
            Gunakan dashboard ini untuk memantau data pasien ICU, assessment loneliness,
            hasil penilaian, serta edukasi bagi perawat dan keluarga pasien.
        </p>

        <div class="hero-actions">
            @if($role !== 'keluarga')
                <a href="{{ route('assessments.select_patient') }}" class="btn btn-light">
                    Mulai Assessment
                </a>
                <a href="{{ route('patients.index') }}" class="btn">
                    Kelola Pasien
                </a>
            @endif

            <a href="{{ route('education.keluarga') }}" class="btn">
                Edukasi Keluarga
            </a>
        </div>
    </div>

    <div class="hero-note">
        <strong>Catatan Klinis</strong>
        <span>
            Sistem ini merupakan alat bantu assessment. Interpretasi tetap perlu disesuaikan
            dengan kondisi klinis pasien dan clinical judgement perawat.
        </span>
    </div>
</div>

<div class="cards">
    @if($role === 'admin')
        <div class="card stat-card">
            <div class="stat-icon" aria-hidden="true">@include('partials.ui-icon', ['name' => 'users'])</div>
            <div class="label">Total Pengguna</div>
            <div class="number">{{ $totalUsers }}</div>
            <div class="stat-sub">Akun aktif dalam sistem</div>
        </div>
    @endif

    <div class="card stat-card">
        <div class="stat-icon" aria-hidden="true">@include('partials.ui-icon', ['name' => 'patient'])</div>
        <div class="label">Total Pasien</div>
        <div class="number">{{ $totalPatients }}</div>
        <div class="stat-sub">Pasien ICU tercatat</div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon" aria-hidden="true">@include('partials.ui-icon', ['name' => 'assessment'])</div>
        <div class="label">Total Assessment</div>
        <div class="number">{{ $totalAssessments }}</div>
        <div class="stat-sub">Hasil penilaian tersimpan</div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon" aria-hidden="true">@include('partials.ui-icon', ['name' => 'question'])</div>
        <div class="label">Pertanyaan Assessment</div>
        <div class="number">{{ $totalQuestions }}</div>
        <div class="stat-sub">Instrumen siap digunakan</div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon" aria-hidden="true">@include('partials.ui-icon', ['name' => 'book'])</div>
        <div class="label">Materi Edukasi Aktif</div>
        <div class="number">{{ $totalEducation }}</div>
        <div class="stat-sub">Konten edukasi tersedia</div>
    </div>
</div>

<div class="insight-grid">
    <div class="insight-card">
        <div class="insight-label">Kategori Terbanyak</div>
        <div class="insight-value">{{ $topCategoryName }}</div>
        <div class="insight-note">
            Total {{ $topCategoryTotal }} assessment berada pada kategori ini.
        </div>
    </div>

    <div class="insight-card risk-card">
        <div class="insight-label">Severe / Very severe</div>
        <div class="insight-value">{{ $riskHighTotal }}</div>
        <div class="insight-note">
            Pasien dengan kategori severe atau very severe lonely perlu menjadi prioritas tindak lanjut.
        </div>
    </div>

    <div class="insight-card">
        <div class="insight-label">Assessment Terbaru</div>
        <div class="insight-value">{{ $latestAssessmentTotal }}</div>
        <div class="insight-note">
            Riwayat assessment terakhir yang ditampilkan pada dashboard.
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel">
        <div class="panel-header">
            <div>
                <h3>Kategori Loneliness</h3>
                <p>Distribusi hasil assessment berdasarkan kategori.</p>
            </div>
        </div>

        <div class="category-summary">
            <div class="category-summary-card low">
                <strong>{{ $riskLowTotal }}</strong>
                <span>Not lonely</span>
            </div>

            <div class="category-summary-card medium">
                <strong>{{ $riskMediumTotal }}</strong>
                <span>Moderate lonely</span>
            </div>

            <div class="category-summary-card high">
                <strong>{{ $riskHighTotal }}</strong>
                <span>Severe / Very severe</span>
            </div>
        </div>

        @if($categoryCollection->count() > 0)
            @foreach($categoryCollection as $category => $total)
                <div class="category-item">
                    <div class="category-row">
                        <span class="category-name">{{ $category ?: 'Belum Dikategorikan' }}</span>
                        <span class="category-total">{{ $total }}</span>
                    </div>

                    <div class="bar">
                        <div class="bar-fill" style="width: {{ ($total / $maxCategory) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                Belum ada data kategori loneliness. Data akan muncul setelah assessment disubmit.
            </div>
        @endif

        <div class="quick-note">
            <div class="quick-note-icon">@include('partials.ui-icon', ['name' => 'alert'])</div>
            <div>
                <strong>Rekomendasi Monitoring</strong>
                <span>
                    Perhatikan pasien dengan kategori sedang dan tinggi untuk tindak lanjut komunikasi terapeutik,
                    edukasi keluarga, serta evaluasi ulang sesuai kondisi klinis.
                </span>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h3>Pasien Terbaru</h3>
                <p>Data pasien terakhir yang diinput ke sistem.</p>
            </div>

            @if($role !== 'keluarga')
                <a href="{{ route('patients.index') }}" class="btn btn-sm">
                    Lihat Semua
                </a>
            @endif
        </div>

        @forelse($latestPatients as $patient)
            <div class="patient-mini">
                <div>
                    <div class="patient-name">{{ $patient->nama_inisial }}</div>
                    <div class="patient-meta">
                        {{ $patient->kode_pasien }} | {{ $patient->usia }} tahun | {{ $patient->jenis_kelamin }}
                    </div>
                </div>

                @if($role !== 'keluarga')
                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-light btn-sm">
                        Detail
                    </a>
                @endif
            </div>
        @empty
            <div class="empty-state">
                Belum ada data pasien.
            </div>
        @endforelse
    </div>
</div>

<br>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Assessment Terbaru</h3>
            <p>Riwayat assessment loneliness terakhir yang tersimpan.</p>
        </div>

        @if($role !== 'keluarga')
            <a href="{{ route('assessments.index') }}" class="btn btn-sm">
                Lihat Riwayat
            </a>
        @endif
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Tanggal</th>
                    <th>Skor</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestAssessments as $assessment)
                    @php
                        $categoryText = $assessment['category'] ?? null;
                        $categoryLower = strtolower($categoryText ?? '');

                        $categoryClass = '';
                        if (str_contains($categoryLower, 'tinggi')) {
                            $categoryClass = 'high';
                        } elseif (str_contains($categoryLower, 'sedang')) {
                            $categoryClass = 'medium';
                        } elseif (str_contains($categoryLower, 'rendah')) {
                            $categoryClass = 'low';
                        }
                    @endphp

                    <tr>
                        <td data-label="Pasien">
                            <strong>{{ $assessment['patient_name'] }}</strong><br>
                            <small>{{ $assessment['patient_code'] }}</small>
                        </td>

                        <td data-label="Tanggal">
                            {{ $assessment['date'] ? $assessment['date']->format('d/m/Y H:i') : '-' }}
                        </td>

                        <td data-label="Skor">
                            <span class="score-pill">
                                {{ $assessment['score'] ?? '-' }}
                            </span>
                        </td>

                        <td data-label="Kategori">
                            @if($categoryText)
                                <span class="assessment-badge {{ $categoryClass }}">
                                    {{ $categoryText }}
                                </span>
                            @else
                                <span class="assessment-badge medium">
                                    Belum Ada
                                </span>
                            @endif
                        </td>

                        <td data-label="Aksi">
                            @if($role !== 'keluarga')
                                <a href="{{ route('assessments.show', $assessment['id']) }}" class="btn btn-sm">
                                    Detail
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                Belum ada assessment yang tersimpan.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
