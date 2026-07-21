@extends('layouts.app')

@section('title', 'Detail Pasien ICU')
@section('page_title', 'Detail Pasien ICU')
@section('page_subtitle', 'Informasi pasien dan status kelayakan assessment loneliness.')

@section('content')
@php
    $eligible = $patient->sadar
        && $patient->mampu_berkomunikasi
        && $patient->memahami_pertanyaan
        && $patient->bersedia_assessment;
@endphp

<style>
    .patient-header {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 22px;
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: center;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
    }

    .patient-header h2 {
        margin: 0 0 8px;
        font-size: 28px;
    }

    .patient-header p {
        margin: 0;
        color: #d9fffb;
    }

    .status-card {
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 8px;
        padding: 16px;
        min-width: 240px;
    }

    .status-card strong {
        display: block;
        margin-bottom: 8px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        margin-bottom: 22px;
    }

    .info-list {
        display: grid;
        gap: 12px;
    }

    .info-item {
        padding: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .info-label {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 6px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .info-value {
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.5;
    }

    .check-list {
        display: grid;
        gap: 10px;
    }

    .check-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .check-icon {
        width: 28px;
        height: 28px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-weight: 800;
    }

    .check-icon.ok {
        background: #dcfce7;
        color: #166534;
    }

    .check-icon.no {
        background: #fee2e2;
        color: #991b1b;
    }

    .assessment-warning {
        margin-top: 18px;
    }

    @media(max-width: 900px) {
        .patient-header,
        .info-grid {
            grid-template-columns: 1fr;
            display: grid;
        }

        .patient-header {
            align-items: stretch;
        }
    }
</style>

<div class="patient-header">
    <div>
        <h2>{{ $patient->nama_inisial }}</h2>
        <p>Kode Pasien / No. RM: <strong>{{ $patient->kode_pasien }}</strong></p>
    </div>

    <div class="status-card">
        <strong>Status Assessment</strong>
        @if($eligible)
            <span class="badge">Layak dilakukan assessment</span>
        @else
            <span class="badge badge-danger">Belum layak assessment</span>
        @endif
    </div>
</div>

<div class="actions" style="margin-bottom: 18px;">
    <a class="btn btn-warning" href="{{ route('patients.edit', $patient) }}">
        Edit Data
    </a>

    @if($eligible)
        <a class="btn" href="{{ route('assessments.create', $patient) }}">
            Lanjut ke Assessment
        </a>
    @endif

    <a class="btn btn-secondary" href="{{ route('patients.index') }}">
        Kembali
    </a>
</div>

@if(!$eligible)
    <div class="alert-error assessment-warning">
        Assessment loneliness hanya dapat dilakukan jika pasien sadar, mampu berkomunikasi,
        memahami pertanyaan sederhana, dan bersedia mengikuti assessment.
    </div>
@endif

<div class="info-grid">
    <div class="panel">
        <div class="panel-header">
            <div>
                <h3>Identitas & Informasi Klinis</h3>
                <p>Data dasar pasien ICU.</p>
            </div>
        </div>

        <div class="info-list">
            <div class="info-item">
                <div class="info-label">Usia</div>
                <div class="info-value">{{ $patient->usia }} tahun</div>
            </div>

            <div class="info-item">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">{{ $patient->jenis_kelamin }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Tanggal Masuk ICU</div>
                <div class="info-value">
                    {{ $patient->tanggal_masuk_icu ? $patient->tanggal_masuk_icu->format('d/m/Y') : '-' }}
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Diagnosis Medis Utama</div>
                <div class="info-value">{{ $patient->diagnosis_medis_utama ?: '-' }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Status Kesadaran</div>
                <div class="info-value">{{ $patient->status_kesadaran ?: '-' }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Kemampuan Komunikasi</div>
                <div class="info-value">{{ $patient->kemampuan_komunikasi ?: '-' }}</div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h3>Konfirmasi Kondisi Assessment</h3>
                <p>Syarat awal sebelum assessment loneliness dilakukan.</p>
            </div>
        </div>

        <div class="check-list">
            <div class="check-item">
                <div class="check-icon {{ $patient->sadar ? 'ok' : 'no' }}">
                    {{ $patient->sadar ? '✓' : '!' }}
                </div>
                <div>
                    <strong>Pasien dalam kondisi sadar</strong><br>
                    <span class="muted">{{ $patient->sadar ? 'Terpenuhi' : 'Belum terpenuhi' }}</span>
                </div>
            </div>

            <div class="check-item">
                <div class="check-icon {{ $patient->mampu_berkomunikasi ? 'ok' : 'no' }}">
                    {{ $patient->mampu_berkomunikasi ? '✓' : '!' }}
                </div>
                <div>
                    <strong>Mampu berkomunikasi verbal/nonverbal</strong><br>
                    <span class="muted">{{ $patient->mampu_berkomunikasi ? 'Terpenuhi' : 'Belum terpenuhi' }}</span>
                </div>
            </div>

            <div class="check-item">
                <div class="check-icon {{ $patient->memahami_pertanyaan ? 'ok' : 'no' }}">
                    {{ $patient->memahami_pertanyaan ? '✓' : '!' }}
                </div>
                <div>
                    <strong>Memahami pertanyaan sederhana</strong><br>
                    <span class="muted">{{ $patient->memahami_pertanyaan ? 'Terpenuhi' : 'Belum terpenuhi' }}</span>
                </div>
            </div>

            <div class="check-item">
                <div class="check-icon {{ $patient->bersedia_assessment ? 'ok' : 'no' }}">
                    {{ $patient->bersedia_assessment ? '✓' : '!' }}
                </div>
                <div>
                    <strong>Bersedia mengikuti assessment</strong><br>
                    <span class="muted">{{ $patient->bersedia_assessment ? 'Terpenuhi' : 'Belum terpenuhi' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Riwayat Assessment Pasien</h3>
            <p>Assessment loneliness yang pernah dilakukan pada pasien ini.</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Skor</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patient->assessments as $assessment)
                <tr>
                    <td>{{ $assessment->created_at ? $assessment->created_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $assessment->total_score ?? $assessment->total_skor ?? $assessment->score ?? '-' }}</td>
                    <td>
                        <span class="badge">
                            {{ $assessment->kategori_loneliness ?? $assessment->kategori ?? $assessment->category ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            Belum ada riwayat assessment untuk pasien ini.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
