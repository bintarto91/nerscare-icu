@extends('layouts.app')

@section('title', 'Pilih Pasien Assessment')
@section('page_title', 'Assessment Loneliness')
@section('page_subtitle', 'Pilih pasien ICU yang memenuhi syarat untuk dilakukan assessment loneliness.')

@section('content')
<style>
    .assessment-select-hero {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
    }

    .assessment-select-hero h2 {
        margin: 0 0 8px;
        font-size: 27px;
    }

    .assessment-select-hero p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.6;
    }

    .patient-eligible {
        display: inline-flex;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        background: #dcfce7;
        color: #166534;
    }

    .patient-not-eligible {
        display: inline-flex;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        background: #fee2e2;
        color: #991b1b;
    }

    .check-mini {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .check-ok,
    .check-no {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .check-ok {
        background: #dcfce7;
        color: #166534;
    }

    .check-no {
        background: #fee2e2;
        color: #991b1b;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="assessment-select-hero">
    <h2>Pilih Pasien untuk Assessment</h2>
    <p>
        Assessment loneliness hanya dapat dimulai pada pasien ICU yang sadar,
        mampu berkomunikasi, memahami pertanyaan sederhana, dan bersedia mengikuti assessment.
    </p>
</div>

<div class="clinical-note">
    <strong>Alur:</strong>
    Pilih pasien dari daftar di bawah. Jika pasien belum memenuhi syarat, buka detail/edit data pasien terlebih dahulu.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pasien Siap Assessment</h3>
            <p>Cari dan pilih pasien sebelum memulai instrumen assessment loneliness.</p>
        </div>

        <a href="{{ route('patients.create') }}" class="btn btn-sm">
            + Tambah Pasien
        </a>
    </div>

    <form method="GET" action="{{ route('assessments.select_patient') }}" class="search-row">
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari kode pasien, inisial, atau diagnosis..."
        >

        <button class="btn" type="submit">
            🔍 Cari
        </button>

        @if($search)
            <a class="btn btn-secondary" href="{{ route('assessments.select_patient') }}">
                Reset
            </a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Informasi ICU</th>
                    <th>Kelayakan</th>
                    <th>Perawat</th>
                    <th width="220">Aksi</th>
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
                        <td>
                            <strong>{{ $patient->nama_inisial }}</strong><br>
                            <span class="muted">{{ $patient->kode_pasien }}</span><br>
                            <span class="muted">{{ $patient->usia }} tahun • {{ $patient->jenis_kelamin }}</span>
                        </td>

                        <td>
                            <strong>{{ $patient->diagnosis_medis_utama ?: '-' }}</strong><br>
                            <span class="muted">
                                Masuk ICU:
                                {{ $patient->tanggal_masuk_icu ? $patient->tanggal_masuk_icu->format('d/m/Y') : '-' }}
                            </span><br>
                            <span class="muted">
                                Komunikasi: {{ $patient->kemampuan_komunikasi ?: '-' }}
                            </span>
                        </td>

                        <td>
                            @if($eligible)
                                <span class="patient-eligible">Siap Assessment</span>
                            @else
                                <span class="patient-not-eligible">Belum Memenuhi</span>
                            @endif

                            <div class="check-mini">
                                <span class="{{ $patient->sadar ? 'check-ok' : 'check-no' }}">Sadar</span>
                                <span class="{{ $patient->mampu_berkomunikasi ? 'check-ok' : 'check-no' }}">Komunikasi</span>
                                <span class="{{ $patient->memahami_pertanyaan ? 'check-ok' : 'check-no' }}">Paham</span>
                                <span class="{{ $patient->bersedia_assessment ? 'check-ok' : 'check-no' }}">Bersedia</span>
                            </div>
                        </td>

                        <td>
                            {{ $patient->nama_perawat_pengisi ?: '-' }}<br>
                            <span class="muted">
                                {{ $patient->tanggal_pengisian ? $patient->tanggal_pengisian->format('d/m/Y') : '-' }}
                            </span>
                        </td>

                        <td>
                            <div class="actions">
                                @if($eligible)
                                    <a href="{{ route('assessments.create', $patient) }}" class="btn btn-sm">
                                        Mulai Assessment
                                    </a>
                                @else
                                    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm">
                                        Lengkapi Data
                                    </a>
                                @endif

                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-light btn-sm">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                Belum ada pasien yang ditemukan.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $patients->links() }}
    </div>
</div>
@endsection