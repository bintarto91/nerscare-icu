@extends('layouts.app')

@section('title', 'Tindak Lanjut Assessment')
@section('page_title', 'Tindak Lanjut Assessment')
@section('page_subtitle', 'Perbarui status tindak lanjut hasil assessment loneliness pasien ICU.')

@section('content')
@php
    $statusOptions = [
        'Belum Ditindaklanjuti',
        'Sudah Edukasi Perawat',
        'Sudah Edukasi Keluarga',
        'Perlu Monitoring Ulang',
        'Selesai',
    ];

    $currentStatus = old('follow_up_status', $assessment->follow_up_status ?? 'Belum Ditindaklanjuti');
@endphp

<style>
    .follow-hero {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 18px;
    }

    .follow-hero h2 {
        margin: 0 0 8px;
        font-size: 27px;
    }

    .follow-hero p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.6;
    }

    .summary-box {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 8px;
        padding: 16px;
        display: grid;
        gap: 8px;
        font-size: 14px;
    }

    .summary-box div {
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    .summary-box span {
        color: #d9fffb;
    }

    .status-options {
        display: grid;
        gap: 10px;
        margin-bottom: 18px;
    }

    .status-card {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 8px;
        padding: 14px;
        cursor: pointer;
        transition: .18s;
    }

    .status-card:hover {
        border-color: #0b6f73;
        box-shadow: 0 10px 24px rgba(15, 118, 110, .08);
    }

    .status-card input {
        width: auto;
        margin-top: 3px;
        accent-color: #0b6f73;
    }

    .status-card strong {
        display: block;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .status-card span {
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    @media(max-width: 900px) {
        .follow-hero {
            grid-template-columns: 1fr;
        }

        .summary-box div {
            display: block;
        }
    }
</style>

<div class="follow-hero">
    <div>
        <h2>{{ $assessment->patient->nama_inisial }}</h2>
        <p>
            Update status tindak lanjut berdasarkan hasil assessment loneliness pasien.
            Status ini akan tampil pada riwayat assessment dan detail hasil.
        </p>
    </div>

    <div class="summary-box">
        <div>
            <span>Kode Pasien</span>
            <strong>{{ $assessment->patient->kode_pasien }}</strong>
        </div>

        <div>
            <span>Total Skor</span>
            <strong>{{ $assessment->total_score }}</strong>
        </div>

        <div>
            <span>Kategori</span>
            <strong>{{ $assessment->category }}</strong>
        </div>

        <div>
            <span>Tanggal Assessment</span>
            <strong>{{ $assessment->assessment_date ? \Carbon\Carbon::parse($assessment->assessment_date)->format('d/m/Y') : '-' }}</strong>
        </div>
    </div>
</div>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Tindak lanjut dapat berupa edukasi perawat, edukasi keluarga, monitoring ulang,
    atau status selesai sesuai kondisi pasien dan kebijakan ruang ICU.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tindak Lanjut</h3>
            <p>Isi status, tanggal, dan catatan tindak lanjut assessment.</p>
        </div>

        <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-light btn-sm">
            ← Kembali ke Hasil
        </a>
    </div>

    <form method="POST" action="{{ route('assessments.follow_up.update', $assessment) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Status Tindak Lanjut</label>

            <div class="status-options">
                @foreach($statusOptions as $status)
                    <label class="status-card">
                        <input
                            type="radio"
                            name="follow_up_status"
                            value="{{ $status }}"
                            {{ $currentStatus === $status ? 'checked' : '' }}
                            required
                        >

                        <div>
                            <strong>{{ $status }}</strong>
                            <span>
                                @if($status === 'Belum Ditindaklanjuti')
                                    Hasil assessment belum dilakukan tindak lanjut edukasi atau monitoring.
                                @elseif($status === 'Sudah Edukasi Perawat')
                                    Edukasi atau intervensi dukungan keperawatan sudah diberikan.
                                @elseif($status === 'Sudah Edukasi Keluarga')
                                    Keluarga sudah diberikan edukasi dukungan emosional sesuai arahan perawat.
                                @elseif($status === 'Perlu Monitoring Ulang')
                                    Pasien perlu dipantau kembali atau dilakukan assessment ulang.
                                @else
                                    Tindak lanjut sudah selesai sesuai kebutuhan pasien.
                                @endif
                            </span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label>Tanggal Tindak Lanjut</label>
                <input
                    type="date"
                    name="follow_up_date"
                    value="{{ old('follow_up_date', $assessment->follow_up_date ? $assessment->follow_up_date->format('Y-m-d') : date('Y-m-d')) }}"
                >
            </div>

            <div class="form-group">
                <label>Petugas Pengisi</label>
                <input
                    type="text"
                    value="{{ auth()->user()->name }}"
                    disabled
                >
            </div>
        </div>

        <div class="form-group">
            <label>Catatan Tindak Lanjut</label>
            <textarea
                name="follow_up_notes"
                placeholder="Contoh: Edukasi keluarga sudah diberikan mengenai cara memberikan dukungan emosional kepada pasien."
                style="min-height: 160px;"
            >{{ old('follow_up_notes', $assessment->follow_up_notes) }}</textarea>
        </div>

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                💾 Simpan Tindak Lanjut
            </button>

            <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection