@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page_title', 'Data Pasien ICU')
@section('page_subtitle', 'Kelola data pasien ICU yang akan dilakukan assessment loneliness.')

@section('content')
<style>
    .patient-hero {
        background: linear-gradient(135deg, #0b6f73 0%, #0f766e 50%, #2563a9 100%);
        color: white;
        border-radius: 26px;
        padding: 26px;
        margin-bottom: 20px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 20px;
        align-items: center;
        box-shadow: 0 20px 54px rgba(8, 47, 73, .18);
        position: relative;
        overflow: hidden;
    }

    .patient-hero::after {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        right: -80px;
        top: -90px;
    }

    .patient-hero > div {
        position: relative;
        z-index: 1;
    }

    .patient-hero h2 {
        color: white;
        margin: 0 0 8px;
        font-size: 28px;
        line-height: 1.25;
    }

    .patient-hero p {
        color: #d9fffb;
        margin: 0;
        line-height: 1.7;
        max-width: 760px;
        font-size: 14px;
    }

    .patient-hero-action {
        position: relative;
        z-index: 1;
    }

    .patient-hero-action .btn {
        background: white;
        color: #0b6f73;
        border-color: white;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 14px;
        font-weight: 900;
    }

    .patient-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .patient-summary-card {
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 22px;
        padding: 20px;
        box-shadow: 0 14px 36px rgba(8, 47, 73, .07);
        position: relative;
        overflow: hidden;
    }

    .patient-summary-card::after {
        content: "";
        position: absolute;
        width: 90px;
        height: 90px;
        border-radius: 999px;
        background: rgba(11, 111, 115, .07);
        right: -34px;
        top: -34px;
    }

    .summary-icon {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }

    .summary-icon .ui-icon {
        width: 20px;
        height: 20px;
        stroke-width: 2.2;
    }

    .summary-label {
        color: #5f7180;
        font-size: 13px;
        position: relative;
        z-index: 1;
    }

    .summary-number {
        color: #0b6f73;
        font-size: 30px;
        font-weight: 900;
        margin-top: 6px;
        position: relative;
        z-index: 1;
    }

    .page-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .search-box {
        display: flex;
        gap: 10px;
        flex: 1;
        min-width: 280px;
        background: white;
        border: 1px solid #d8e4ea;
        border-radius: 18px;
        padding: 10px;
        box-shadow: 0 12px 30px rgba(8, 47, 73, .06);
    }

    .search-box input {
        flex: 1;
        border: none;
        box-shadow: none;
        padding: 10px 12px;
    }

    .search-box input:focus {
        box-shadow: none;
    }

    .patient-code {
        font-weight: 900;
        color: #0b6f73;
        font-size: 15px;
    }

    .patient-name {
        font-weight: 900;
        color: #0f172a;
        font-size: 16px;
        margin-top: 3px;
    }

    .muted {
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .status-checks {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .check-ok,
    .check-no {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        white-space: nowrap;
    }

    .check-ok {
        background: #dcfce7;
        color: #166534;
    }

    .check-no {
        background: #fee2e2;
        color: #991b1b;
    }

    .patient-table-wrapper {
        overflow-x: auto;
    }

    .patient-table {
        min-width: 1060px;
    }

    .patient-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .patient-table tbody tr {
        transition: .15s;
    }

    .patient-table tbody tr:hover td {
        background: #f8fbfc;
    }

    .patient-action-group {
        display: flex;
        gap: 7px;
        flex-wrap: wrap;
    }

    .patient-action-group .btn {
        border-radius: 10px;
        font-size: 12px;
        white-space: nowrap;
    }

    .eligibility-box {
        margin-top: 9px;
    }

    .eligibility-ready {
        background: #e6f7f6;
        color: #0b6f73;
    }

    .pagination-box {
        margin-top: 18px;
    }

    .top-note {
        margin-bottom: 18px;
        border-radius: 18px;
    }

    .empty-patient-state {
        text-align: center;
        padding: 34px 20px;
        background: #f8fbfc;
        border: 1px dashed #c7d6de;
        border-radius: 18px;
        color: #5f7180;
        line-height: 1.7;
    }

    .empty-patient-state strong {
        color: #0b6f73;
    }

    @media(max-width: 1100px) {
        .patient-summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .patient-hero {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 760px) {
        .patient-hero {
            padding: 20px;
            border-radius: 22px;
        }

        .patient-hero h2 {
            font-size: 22px;
            line-height: 1.2;
        }

        .patient-hero p {
            font-size: 13px;
            line-height: 1.6;
        }

        .patient-hero-action .btn {
            width: 100%;
        }

        .patient-summary-grid {
            grid-template-columns: 1fr;
        }

        .search-box {
            flex-direction: column;
            min-width: 100%;
            border-radius: 18px;
        }

        .page-actions {
            align-items: stretch;
        }

        .page-actions .btn {
            width: 100%;
        }

        .patient-table {
            min-width: 0;
        }

        .patient-action-group {
            flex-direction: column;
            width: 100%;
        }

        .patient-action-group .btn,
        .patient-action-group form,
        .patient-action-group button {
            width: 100%;
        }

        .patient-table-wrapper {
            overflow: visible;
        }

        .patient-table.mobile-card-table,
        .patient-table.mobile-card-table thead,
        .patient-table.mobile-card-table tbody,
        .patient-table.mobile-card-table tr,
        .patient-table.mobile-card-table th,
        .patient-table.mobile-card-table td {
            display: block;
            width: 100%;
        }

        .patient-table.mobile-card-table thead {
            display: none;
        }

        .patient-table.mobile-card-table tbody tr {
            margin-bottom: 16px;
            border: 1px solid #d8e4ea;
            border-radius: 20px;
            background: white;
            box-shadow: 0 14px 34px rgba(8, 47, 73, .07);
            overflow: hidden;
        }

        .patient-table.mobile-card-table td {
            display: grid;
            grid-template-columns: 118px 1fr;
            gap: 12px;
            border: none;
            border-bottom: 1px solid #edf3f6;
            padding: 13px 14px;
            white-space: normal;
        }

        .patient-table.mobile-card-table td::before {
            content: attr(data-label);
            color: #64748b;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .patient-table.mobile-card-table td:last-child {
            border-bottom: none;
        }

        .patient-table.mobile-card-table td[data-label="Aksi"] {
            display: block;
        }

        .patient-table.mobile-card-table td[data-label="Aksi"]::before {
            display: block;
            margin-bottom: 10px;
        }
    }

    @media(max-width: 420px) {
        .patient-table.mobile-card-table td {
            grid-template-columns: 1fr;
            gap: 6px;
        }
    }
</style>

@php
    $totalPatients = $patients->total();

    $readyCount = collect($patients->items())->filter(function ($patient) {
        return $patient->sadar
            && $patient->mampu_berkomunikasi
            && $patient->memahami_pertanyaan
            && $patient->bersedia_assessment;
    })->count();

    $notReadyCount = collect($patients->items())->count() - $readyCount;
@endphp

<div class="patient-hero">
    <div>
        <h2>Data Pasien ICU</h2>
        <p>
            Kelola data pasien ICU yang akan dilakukan assessment loneliness.
            Pastikan status kesadaran, kemampuan komunikasi, pemahaman, dan persetujuan assessment sudah lengkap.
        </p>
    </div>

    <div class="patient-hero-action">
        <a href="{{ route('patients.create') }}" class="btn">
            + Tambah Pasien
        </a>
    </div>
</div>

<div class="patient-summary-grid">
    <div class="patient-summary-card">
        <div class="summary-icon">@include('partials.ui-icon', ['name' => 'patient'])</div>
        <div class="summary-label">Total Pasien</div>
        <div class="summary-number">{{ $totalPatients }}</div>
    </div>

    <div class="patient-summary-card">
        <div class="summary-icon">@include('partials.ui-icon', ['name' => 'check'])</div>
        <div class="summary-label">Siap Assessment</div>
        <div class="summary-number">{{ $readyCount }}</div>
    </div>

    <div class="patient-summary-card">
        <div class="summary-icon">@include('partials.ui-icon', ['name' => 'alert'])</div>
        <div class="summary-label">Belum Memenuhi</div>
        <div class="summary-number">{{ $notReadyCount }}</div>
    </div>

    <div class="patient-summary-card">
        <div class="summary-icon">@include('partials.ui-icon', ['name' => 'search'])</div>
        <div class="summary-label">Hasil Pencarian</div>
        <div class="summary-number">{{ $patients->count() }}</div>
    </div>
</div>

<div class="clinical-note top-note">
    <strong>Catatan:</strong>
    Assessment loneliness hanya dilakukan pada pasien ICU yang sadar, mampu berkomunikasi,
    memahami pertanyaan sederhana, dan bersedia mengikuti assessment.
</div>

<div class="page-actions">
    <form method="GET" action="{{ route('patients.index') }}" class="search-box">
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari kode pasien, inisial, atau diagnosis..."
        >

        <button type="submit" class="btn">
            Cari
        </button>

        @if($search)
            <a href="{{ route('patients.index') }}" class="btn btn-light">
                Reset
            </a>
        @endif
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pasien</h3>
            <p>Data pasien ICU yang tersimpan dalam sistem.</p>
        </div>

        <a href="{{ route('patients.create') }}" class="btn btn-sm">
            + Tambah Pasien
        </a>
    </div>

    <div class="patient-table-wrapper">
        <table class="patient-table mobile-card-table">
            <thead>
                <tr>
                    <th>Kode / Inisial</th>
                    <th>Identitas</th>
                    <th>Kondisi Assessment</th>
                    <th>Diagnosis</th>
                    <th>Perawat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($patients as $patient)
                    @php
                        $eligible = $patient->sadar
                            && $patient->mampu_berkomunikasi
                            && $patient->memahami_pertanyaan
                            && $patient->bersedia_assessment;
                    @endphp

                    <tr>
                        <td data-label="Kode / Inisial">
                            <div class="patient-code">{{ $patient->kode_pasien }}</div>
                            <div class="patient-name">{{ $patient->nama_inisial }}</div>
                            <div class="muted">
                                Masuk ICU:
                                {{ $patient->tanggal_masuk_icu ? $patient->tanggal_masuk_icu->format('d/m/Y') : '-' }}
                            </div>
                        </td>

                        <td data-label="Identitas">
                            <strong>{{ $patient->usia }} tahun</strong><br>
                            <span class="muted">{{ $patient->jenis_kelamin }}</span>
                        </td>

                        <td data-label="Kondisi Assessment">
                            <div class="status-checks">
                                <span class="{{ $patient->sadar ? 'check-ok' : 'check-no' }}">
                                    {{ $patient->sadar ? '✓' : '×' }} Sadar
                                </span>

                                <span class="{{ $patient->mampu_berkomunikasi ? 'check-ok' : 'check-no' }}">
                                    {{ $patient->mampu_berkomunikasi ? '✓' : '×' }} Komunikasi
                                </span>

                                <span class="{{ $patient->memahami_pertanyaan ? 'check-ok' : 'check-no' }}">
                                    {{ $patient->memahami_pertanyaan ? '✓' : '×' }} Paham
                                </span>

                                <span class="{{ $patient->bersedia_assessment ? 'check-ok' : 'check-no' }}">
                                    {{ $patient->bersedia_assessment ? '✓' : '×' }} Bersedia
                                </span>
                            </div>

                            <div class="eligibility-box">
                                @if($eligible)
                                    <span class="badge eligibility-ready">Siap Assessment</span>
                                @else
                                    <span class="badge badge-danger">Belum Memenuhi</span>
                                @endif
                            </div>
                        </td>

                        <td data-label="Diagnosis">
                            <strong>{{ $patient->diagnosis_medis_utama ?: '-' }}</strong>
                            <br>
                            <span class="muted">
                                Kesadaran: {{ $patient->status_kesadaran ?: '-' }}<br>
                                Komunikasi: {{ $patient->kemampuan_komunikasi ?: '-' }}
                            </span>
                        </td>

                        <td data-label="Perawat">
                            <strong>{{ $patient->nama_perawat_pengisi ?: '-' }}</strong>
                            <br>
                            <span class="muted">
                                {{ $patient->tanggal_pengisian ? $patient->tanggal_pengisian->format('d/m/Y') : '-' }}
                            </span>
                        </td>

                        <td data-label="Aksi">
                            <div class="patient-action-group">
                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-light btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                @if($eligible)
                                    <a href="{{ route('assessments.create', $patient) }}" class="btn btn-sm">
                                        Assessment
                                    </a>
                                @else
                                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary btn-sm">
                                        Cek Kondisi
                                    </a>
                                @endif

                                <form
                                    method="POST"
                                    action="{{ route('patients.destroy', $patient) }}"
                                    data-confirm="Yakin hapus data pasien ini?"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-patient-state">
                                Belum ada data pasien.
                                <br>
                                Klik tombol <strong>Tambah Pasien</strong> untuk mulai menginput data pasien ICU.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $patients->links() }}
    </div>
</div>
@endsection
