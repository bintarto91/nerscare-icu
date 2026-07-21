<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Hasil Assessment - {{ $assessment->patient->kode_pasien }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            background: #f1f5f9;
            margin: 0;
            padding: 24px;
            font-size: 13px;
            line-height: 1.6;
        }

        .page {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 34px;
            border-radius: 8px;
            box-shadow: 0 16px 45px rgba(15, 23, 42, .12);
        }

        .print-actions {
            max-width: 900px;
            margin: 0 auto 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            cursor: pointer;
            background: #0b6f73;
            color: white;
            font-weight: bold;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-secondary {
            background: #475569;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #0b6f73;
            padding-bottom: 18px;
            margin-bottom: 22px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #0b6f73;
        }

        .header p {
            margin: 6px 0 0;
            color: #475569;
        }

        .section {
            margin-bottom: 22px;
        }

        .section h2 {
            font-size: 16px;
            color: #0b6f73;
            margin: 0 0 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f8fafc;
            color: #334155;
            width: 230px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .summary-card {
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            background: #f8fafc;
        }

        .summary-label {
            color: #64748b;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 22px;
            font-weight: bold;
            color: #0b6f73;
        }

        .category {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: bold;
            background: #e6f3f5;
            color: #0b6f73;
        }

        .text-box {
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px;
            background: #f8fafc;
            margin-bottom: 12px;
        }

        .text-box h3 {
            margin: 0 0 8px;
            color: #0b6f73;
            font-size: 14px;
        }

        .text-box p {
            margin: 0;
        }

        .clinical-note {
            border: 1px solid #fed7aa;
            background: #fff7ed;
            color: #9a3412;
            padding: 12px;
            border-radius: 12px;
            margin-top: 18px;
        }

        .signature {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 36px;
        }

        .signature-box {
            text-align: center;
            min-height: 110px;
        }

        .signature-line {
            margin-top: 70px;
            border-top: 1px solid #111827;
            padding-top: 6px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .print-actions {
                display: none;
            }

            .page {
                max-width: none;
                margin: 0;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            @page {
                size: A4;
                margin: 16mm;
            }
        }
    </style>
</head>

<body>
@php
    $assessmentDate = $assessment->assessment_date
        ? \Carbon\Carbon::parse($assessment->assessment_date)->format('d/m/Y')
        : '-';

    $perawatName = $assessment->patient->nama_perawat_pengisi
        ?? optional($assessment->user)->name
        ?? '-';

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

<div class="print-actions">
    <button class="btn" onclick="window.print()">Cetak / Save as PDF</button>
    <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="page">
    <div class="header">
        <h1>{{ $reportSettings['report_title'] }}</h1>
        <p>{{ $reportSettings['report_subtitle'] }}</p>
        <p><strong>{{ $reportSettings['report_institution_name'] }}</strong></p>
        <p>{{ $reportSettings['report_unit_name'] }}</p>
    </div>

    <div class="section">
        <h2>Identitas Pasien</h2>

        <table>
            <tr>
                <th>Kode Pasien / No. RM</th>
                <td>{{ $assessment->patient->kode_pasien }}</td>
            </tr>
            <tr>
                <th>Nama / Inisial</th>
                <td>{{ $assessment->patient->nama_inisial }}</td>
            </tr>
            <tr>
                <th>Usia</th>
                <td>{{ $assessment->patient->usia }} tahun</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $assessment->patient->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Diagnosis Medis Utama</th>
                <td>{{ $assessment->patient->diagnosis_medis_utama ?: '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Assessment</th>
                <td>{{ $assessmentDate }}</td>
            </tr>
            <tr>
                <th>Perawat Pengisi</th>
                <td>{{ $perawatName }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Ringkasan Hasil</h2>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Skor</div>
                <div class="summary-value">{{ $assessment->total_score }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Kategori Loneliness</div>
                <div>
                    <span class="category">{{ $assessment->category }}</span>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Emotional Loneliness</div>
                <div class="summary-value">{{ $dimensionScores['emotional'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Social Loneliness</div>
                <div class="summary-value">{{ $dimensionScores['social'] }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Kategori Lain</div>
                <div>
                    <span class="category">{{ $dominantDimension }}</span>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Jumlah Pertanyaan</div>
                <div class="summary-value">{{ $assessment->answers->count() }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Interpretasi dan Rekomendasi</h2>

        <div class="text-box">
            <h3>Interpretasi Awal</h3>
            <p>{{ $assessment->interpretation }}</p>
        </div>

        <div class="text-box">
            <h3>Rekomendasi Dukungan Keperawatan</h3>
            <p>{{ $assessment->nursing_recommendation }}</p>
        </div>

        <div class="text-box">
            <h3>Rekomendasi Edukasi Keluarga</h3>
            <p>{{ $assessment->family_education_recommendation }}</p>
        </div>

        @if($assessment->notes)
            <div class="text-box">
                <h3>Catatan Perawat</h3>
                <p>{{ $assessment->notes }}</p>
            </div>
        @endif

        <div class="clinical-note">
            <strong>Catatan Klinis:</strong>
            {{ $reportSettings['report_clinical_note'] }}
        </div>
    </div>

    <div class="section">
        <h2>Detail Jawaban Assessment</h2>

        <table>
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Pertanyaan</th>
                    <th style="width:150px;">Jawaban</th>
                    <th style="width:80px;">Skor Item</th>
                </tr>
            </thead>

            <tbody>
                @foreach($assessment->answers as $answer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $answer->question->question_text ?? $answer->question->question ?? '-' }}</td>
                        <td>{{ $answer->answer_text }}</td>
                        <td>{{ $answer->score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="signature">
        <div class="signature-box">
            <div>{{ $reportSettings['report_left_signature_label'] }}</div>
            <div class="signature-line">{{ $perawatName }}</div>
        </div>

        <div class="signature-box">
            <div>{{ $reportSettings['report_right_signature_label'] }}</div>
            <div class="signature-line">{{ $reportSettings['report_right_signature_name'] ?: '................................' }}</div>
        </div>
    </div>

    @if(!empty($reportSettings['report_footer_text']))
        <div style="margin-top: 28px; text-align:center; font-size:12px; color:#64748b;">
            {{ $reportSettings['report_footer_text'] }}
        </div>
    @endif
    </div>

<script>
    window.onload = function () {
        // Biarkan kosong supaya halaman bisa dicek dulu.
        // Kalau mau otomatis muncul dialog print, aktifkan baris di bawah:
        // window.print();
    };
</script>
</body>
</html>
